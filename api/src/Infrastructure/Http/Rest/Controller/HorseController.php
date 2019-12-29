<?php

namespace App\Infrastructure\Http\Rest\Controller;

use App\Application\Exceptions\ValidationException;
use App\Application\Service\HorseService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
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
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class HorseController extends AbstractFOSRestController
{
    /**
     * @var HorseService
     */
    private HorseService $horseService;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * HorseController constructor.
     * @param HorseService $horseService
     * @param ValidatorInterface $validator
     */
    public function __construct(HorseService $horseService, ValidatorInterface $validator)
    {
        $this->horseService = $horseService;
        $this->validator = $validator;
    }

    /**
     * Creates a Horse resource
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return View
     * @throws Exception
     * @Rest\Post("/horses", name="create_horse")
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
     */
    public function postHorse(Request $request, ValidatorInterface $validator): View
    {
        $horseRequest = HorseRequest::createFromRequest($request);

        try {
            $this->validate($horseRequest);
        } catch (ValidationException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        $horse = $this->horseService->addHorse($horseRequest);

        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($horse, Response::HTTP_CREATED);
    }

    /**
     * Retrieves a Horse resource
     * @param string $horseUuid
     * @Rest\Get("/horses/{horseUuid}")
     * @return View
     * @throws EntityNotFoundException
     * @Swagger\Response(
     *     response=200,
     *     description="Gets a horse by uuid"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function getHorse(string $horseUuid): View
    {
        $horse = $this->horseService->getHorse($horseUuid);

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
     * @param string $horseUuid
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return View
     * @throws Exception
     * @Rest\Put("/horses/{horseUuid}")
     * @Swagger\Parameter(
     *     name="name",
     *     in="body",
     *     description="The horse data",
     *     @Swagger\Schema(ref=@Model(type=HorseRequest::class))
     * )
     * @Swagger\Response(
     *     response=200,
     *     description="Replaces a horse resource"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function putHorse(string $horseUuid, Request $request, ValidatorInterface $validator): View
    {
        $horseRequest = HorseRequest::createFromRequest($request);

        try {
            $this->validate($horseRequest);
        } catch (ValidationException $e) {
            throw new HttpException(500, $e->getMessage());
        }

        $horse = $this->horseService->updateHorse($horseUuid, $horseRequest);

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($horse, Response::HTTP_OK);
    }

    /**
     * Removes a Horse resource
     * @Rest\Delete("/horses/{horseUuid}")
     * @throws EntityNotFoundException
     * @param string $horseUuid
     * @return View
     * @Swagger\Response(
     *     response=200,
     *     description="Removes a horse by id"
     * )
     * @Swagger\Tag(name="Horses")
     */
    public function deleteHorse(string $horseUuid): View
    {
        $this->horseService->deleteHorse($horseUuid);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param HorseRequest $horseRequest
     * @throws ValidationException
     */
    private function validate(HorseRequest $horseRequest): void
    {
        $errors = $this->validator->validate($horseRequest);

        if (count($errors) > 0) {
            throw new ValidationException((string) $errors);
        }
    }
}