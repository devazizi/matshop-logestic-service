<?php

namespace App\Entity;

use App\Repository\TripRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $orderId = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?int $clientProvinceId = null;

    #[ORM\Column(length: 255)]
    private ?string $clientAddress = null;

    #[ORM\Column(length: 40)]
    private ?string $clientCellNumber = null;

    #[ORM\Column]
    private ?int $storeProvinceId = null;

    #[ORM\Column(length: 255)]
    private ?string $storeAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $storeSupportCellNumber = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $truckId = null;

    #[ORM\Column(length: 255)]
    private ?string $tripStatus = null;

    public function __construct()
    {
        $this->updatedTimestamps();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getClientProvinceId(): ?int
    {
        return $this->clientProvinceId;
    }

    public function setClientProvinceId(int $clientProvinceId): self
    {
        $this->clientProvinceId = $clientProvinceId;

        return $this;
    }

    public function getClientAddress(): ?string
    {
        return $this->clientAddress;
    }

    public function setClientAddress(string $clientAddress): self
    {
        $this->clientAddress = $clientAddress;

        return $this;
    }

    public function getClientCellNumber(): ?string
    {
        return $this->clientCellNumber;
    }

    public function setClientCellNumber(string $clientCellNumber): self
    {
        $this->clientCellNumber = $clientCellNumber;

        return $this;
    }

    public function getStoreProvinceId(): ?int
    {
        return $this->storeProvinceId;
    }

    public function setStoreProvinceId(int $storeProvinceId): self
    {
        $this->storeProvinceId = $storeProvinceId;

        return $this;
    }

    public function getStoreAddress(): ?string
    {
        return $this->storeAddress;
    }

    public function setStoreAddress(string $storeAddress): self
    {
        $this->storeAddress = $storeAddress;

        return $this;
    }

    public function getStoreSupportCellNumber(): ?string
    {
        return $this->storeSupportCellNumber;
    }

    public function setStoreSupportCellNumber(string $storeSupportCellNumber): self
    {
        $this->storeSupportCellNumber = $storeSupportCellNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTruckId(): ?int
    {
        return $this->truckId;
    }

    public function setTruckId(int $truckId): self
    {
        $this->truckId = $truckId;

        return $this;
    }

    public function getTripStatus(): ?string
    {
        return $this->tripStatus;
    }

    public function setTripStatus(string $tripStatus): self
    {
        $this->tripStatus = $tripStatus;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new \DateTimeImmutable("now");
        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }
}
