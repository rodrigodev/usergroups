<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\Service\HorseService;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as Swagger;
use App\Application\Request\Horse\HorseRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\Model;
use Ramsey\Uuid\UuidInterface;

final class HorseController extends AbstractFOSRestController
{
    /**
     * @var HorseService
     */
    private $horseService;

    /**
     * HorseController constructor.
     * @param HorseService $horseService
     */
    public function __construct(HorseService $horseService)
    {
        $this->horseService = $horseService;
    }

    /**
     * Creates a Horse resource
     * @param HorseRequest $horseRequest
     * @Rest\Post("/horses", name="create_horse")
     * @return View
     * @Swagger\Parameter(
     *     name="create horse request",
     *     in="body",
     *     description="A request to create a horse",
     *     @Swagger\Schema(ref=@Model(type=HorseRequest::class))
     * )
     * @Swagger\Response(
     *     response=201,
     *     description="Created",
     * )
     * @Swagger\Tag(name="Horses")
     *
     */
    public function postHorse(HorseRequest $horseRequest): View
    {
        $horse = $this->horseService->addHorse($horseRequest);

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($horse, Response::HTTP_CREATED);
    }

    /**
     * Retrieves a Horse resource
     * @param string $horseId
     * @Rest\Get("/horses/{horseId}")
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Gets a horse by id"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function getHorse(string $horseId): View
    {
        $horse = $this->horseService->getHorse($horseId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($horse, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Horse resource
     * @Rest\Get("/horses")
     * @return View
     * @Swagger\Response(
     *     response=200,
     *     description="Gets all horses"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function getHorses(): View
    {
        $horses = $this->horseService->getAllHorses();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of horse object
        return View::create($horses, Response::HTTP_OK);
    }

    /**
     * Replaces Horse resource
     * @param string $horseId
     * @param Request $request
     * @Rest\Put("/horses/{horseId}")
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Replaces a horse resource"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function putHorse(string $horseId, Request $request): View
    {
        $horse = $this->horseService->updateHorse($horseId, $request->get('name'));

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($horse, Response::HTTP_OK);
    }

    /**
     * Removes a Horse resource
     * @Rest\Delete("/horses/{horseId}")
     * @throws EntityNotFoundException
     * @param string $horseId
     * @return View
     * @Swagger\Response(
     *     response=200,
     *     description="Removes a horse by id"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function deleteHorse(string $horseId): View
    {
        $this->horseService->deleteHorse($horseId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}