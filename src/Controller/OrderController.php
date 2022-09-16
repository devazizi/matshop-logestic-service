<?php

namespace App\Controller;

use App\Constant\TripConstant;
use App\Entity\Trip;
use App\Repository\TripRepository;
use App\Services\Responser;
use Doctrine\Persistence\ManagerRegistry;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {

    }

    /**
     * @Route("/orders", methods={"POST"}, name="app_store_order")
     * @throws JsonException
     */
    public function store(Request $request): Response
    {
        $requestBody = $request->toArray();
        $orderId = array_key_exists('orderId', $requestBody) ? $requestBody['orderId'] : throw new JsonException('orderId required', 422);
        $orderWeight = array_key_exists('orderWeight', $requestBody) ? $requestBody['orderWeight'] : throw new JsonException('orderWeight id required', 422);
        $provinceId = array_key_exists('provinceId', $requestBody) ? $requestBody['provinceId'] : throw new JsonException('provinceId required', 422);
        $address = array_key_exists('address', $requestBody) ? $requestBody['address'] : throw new JsonException('address required', 422);
        $clientCellNumber = array_key_exists('clientCellNumber', $requestBody) ? $requestBody['clientCellNumber'] : throw new JsonException('clientCellNumber required', 422);
        $storeProvinceId = array_key_exists('storeProvinceId', $requestBody) ? $requestBody['storeProvinceId'] : throw new JsonException('storeProvinceId required', 422);
        $storeAddress = array_key_exists('storeAddress', $requestBody) ? $requestBody['storeAddress'] : throw new JsonException('storeAddress required', 422);
        $storeSupportCellNumber = array_key_exists('storeSupportCellNumber', $requestBody) ? $requestBody['storeSupportCellNumber'] : throw new JsonException('storeSupportCellNumber required', 422);

        $tripRepo = $this->doctrine->getRepository(Trip::class);

        if ($tripRepo->checkTripExistsByOrderId($orderId)) {
            throw new JsonException("order id must be unique");
        }

        $trip = new Trip();
        $trip->setOrderId($orderId);
        $trip->setWeight($orderWeight);
        $trip->setClientProvinceId($provinceId);
        $trip->setClientAddress($address);
        $trip->setClientCellNumber($clientCellNumber);
        $trip->setStoreProvinceId($storeProvinceId);
        $trip->setStoreAddress($storeAddress);
        $trip->setStoreSupportCellNumber($storeSupportCellNumber);
        $trip->setTripStatus(TripConstant::REQUEST_TO_FIND_TRIP_TRUCK);
        $tripEntity = $tripRepo->createTrip($trip);

        return $this->json(Responser::jsonResponse(true, $tripEntity, 'success'), 201);
    }

    /**
     * @Route("/orders", methods={"GET"}, name="app_index_orders_by_admin")
     */
    public function indexTrips(): Response
    {
        /** @var $tripRepo TripRepository */
        $tripRepo = $this->doctrine->getRepository(Trip::class);
        $trips = $tripRepo->indexTripsByAdmin();

        return $this->json(Responser::jsonResponse(true, $trips));
    }

    /**
     * @Route("/orders/{tripId}", methods={"GET"}, name="app_index_orders_by_admin")
     */
    public function getTrip(int $tripId): Response {

        /** @var $tripRepo TripRepository */
        $tripRepo = $this->doctrine->getRepository(Trip::class);
        $trip = $tripRepo->getTripByAdmin($tripId);

        if (is_null($trip)) {
            throw new JsonException("trip not found", 404);
        }

        return $this->json(Responser::jsonResponse(true, $trip));
    }
}
