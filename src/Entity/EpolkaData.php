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
     * @ORM\Column(type="string", length=8)
     */
    private string $voltage;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private string $signalLevel;

    /**
     * @ORM\Column(type="json")
     */
    private array $sensors;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEpolkaId(): string
    {
        return $this->epolkaId;
    }

    /**
     * @param string $epolkaId
     */
    public function setEpolkaId(string $epolkaId): void
    {
        $this->epolkaId = $epolkaId;
    }

    /**
     * @return \DateTime
     */
    public function getConnectedAt(): \DateTime
    {
        return $this->connectedAt;
    }

    /**
     * @param \DateTime $connectedAt
     */
    public function setConnectedAt(\DateTime $connectedAt): void
    {
        $this->connectedAt = $connectedAt;
    }

    /**
     * @return int
     */
    public function getConnectId(): int
    {
        return $this->connectId;
    }

    /**
     * @param int $connectId
     */
    public function setConnectId(int $connectId): void
    {
        $this->connectId = $connectId;
    }

    /**
     * @return string
     */
    public function getVoltage(): string
    {
        return $this->voltage;
    }

    /**
     * @param string $voltage
     */
    public function setVoltage(string $voltage): void
    {
        $this->voltage = $voltage;
    }

    /**
     * @return string
     */
    public function getSignalLevel(): string
    {
        return $this->signalLevel;
    }

    /**
     * @param string $signalLevel
     */
    public function setSignalLevel(string $signalLevel): void
    {
        $this->signalLevel = $signalLevel;
    }

    /**
     * @return array
     */
    public function getSensors(): array
    {
        return $this->sensors;
    }

    /**
     * @param array $sensors
     */
    public function setSensors(array $sensors): void
    {
        $this->sensors = $sensors;
    }
}
