<?php

namespace App\Services;

use App\Entity\Trip;
use Doctrine\Persistence\ManagerRegistry;

class LogesticOrderService
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function checkTripExistsByOrderId(int $orderId)
    {
        $tripRepo = $this->doctrine->getRepository(Trip::class);
        $trip = $tripRepo->checkTripExistsByOrderId($orderId);

        if ($trip) {
            return true;
        }
        return false;
    }

    public function createTrip()
    {
//        $this->doctrine->
    }
}