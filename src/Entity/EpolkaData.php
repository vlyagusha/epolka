<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EpolkaDataRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class EpolkaData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private string $epolkaId;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $connectedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $connectId;

    /**
     * @ORM\Column(type="float")
     */
    private float $voltage;

    /**
     * @ORM\Column(type="integer")
     */
    private int $signalLevel;

    /**
     * @ORM\Column(type="json")
     */
    private array $sensors;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpolkaId(): string
    {
        return $this->epolkaId;
    }

    public function setEpolkaId(string $epolkaId): void
    {
        $this->epolkaId = $epolkaId;
    }

    public function getConnectedAt(): \DateTime
    {
        return $this->connectedAt;
    }

    public function setConnectedAt(\DateTime $connectedAt): void
    {
        $this->connectedAt = $connectedAt;
    }

    public function getConnectId(): int
    {
        return $this->connectId;
    }

    public function setConnectId(int $connectId): void
    {
        $this->connectId = $connectId;
    }

    public function getVoltage(): float
    {
        return $this->voltage;
    }

    public function setVoltage(float $voltage): void
    {
        $this->voltage = $voltage;
    }

    public function getSignalLevel(): int
    {
        return $this->signalLevel;
    }

    public function setSignalLevel(int $signalLevel): void
    {
        $this->signalLevel = $signalLevel;
    }

    public function getSensors(): array
    {
        return $this->sensors;
    }

    public function setSensors(array $sensors): void
    {
        $this->sensors = $sensors;
    }
}
