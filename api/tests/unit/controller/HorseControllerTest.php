<?php

namespace App\Tests\Controller;

use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HorseControllerTest extends TestCase
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
     * @var
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
                'verify' => false
            ]
        ]);
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;

        $data = array(
            'username' => 'admin',
            'password' => 'admin',
        );

        var_export(json_encode($data));

        $response = $this->client->post('/api/authenticate', [
            RequestOptions::JSON => json_encode($data),
            'debug' => true
        ]);



        $responseData = json_decode($response->getBody());
        $this->token = $responseData['token'];
    }

    public function testPOST(): void
    {
        $name = 'Black Princess';

        $data = array(
            'name' => $name,
            'picture' => 'https://static.domain.com/images/image.jpeg',
        );

        $response = $this->client->post('/api/horses', [
            RequestOptions::JSON => \GuzzleHttp\json_encode($data),
            'headers' => [
                'X-AUTH-TOKEN' => $this->token
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $responseData = json_decode($response->getBody());
        $this->assertArrayHasKey('name', $responseData);
    }
}