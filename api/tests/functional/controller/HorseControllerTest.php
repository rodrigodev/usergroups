<?php

namespace App\Tests\Functional\Controller;

use App\DataFixtures\HorseFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HorseControllerTest extends KernelTestCase
{
    /**
     * @var Client
     */
    private static $staticClient;
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://nginx',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'defaults' => [
                'exceptions' => true,
                'verify' => true
            ]
        ]);
        self::bootKernel();
    }

    protected function setUp()
    {
        $loader = new Loader();
        $loader->addFixture(new UserFixtures());
        $loader->addFixture(new HorseFixtures());

        $em = $this->getService('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);

        $executor->execute($loader->getFixtures());

        $this->client = self::$staticClient;

        $data = array(
            'username' => 'admin',
            'password' => 'admin',
        );

        $response = $this->client->post('/api/authenticate', [
            RequestOptions::JSON => $data
        ]);

        $responseData = json_decode($response->getBody(), true);
        $this->token = $responseData['token'];

        parent::setUp();
    }

    protected function tearDown()
    {
        //$purger = new ORMPurger($this->getService('doctrine')->getManager());
        //$purger->purge();
    }

    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
    }

    public function testGetAll(): void
    {
        $response = $this->client->get('/api/horses', [
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);

        foreach ($responseData as $resource) {
            $this->assertArrayHasKey('name', $resource);
            $this->assertArrayHasKey('uuid', $resource);

            $this->assertContains($resource['uuid'], HorseFixtures::$uuids);
        }
    }

    public function testPOST(): void
    {
        $name = 'Black Princess';

        $data = array(
            'name' => $name,
            'picture' => 'https://static.domain.com/images/image.jpeg',
        );

        $response = $this->client->post('/api/horses', [
            RequestOptions::JSON => $data,
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('uuid', $responseData);

        $this->assertEquals($name, $responseData['name']);
    }

    public function testGet(): void
    {
        $uuid = HorseFixtures::$uuids[0];

        $response = $this->client->get(sprintf('/api/horses/%s', $uuid), [
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('uuid', $responseData);

        $this->assertEquals($uuid, $responseData['uuid']);
    }

    public function testPUT(): void
    {
        $name = 'Black Princess II';
        $uuid = HorseFixtures::$uuids[1];

        $data = array(
            'name' => $name,
            'picture' => 'https://static.domain.com/images/image.jpeg',
        );

        $response = $this->client->put(sprintf('/api/horses/%s', $uuid), [
            RequestOptions::JSON => $data,
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('name', $responseData);
        $this->assertEquals($name, $responseData['name']);
    }

    public function testDelete(): void
    {
        $uuid = HorseFixtures::$uuids[3];

        $response = $this->client->delete(sprintf('/api/horses/%s', $uuid), [
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(204, $response->getStatusCode());
    }
}