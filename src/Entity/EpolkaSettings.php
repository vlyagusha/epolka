<?php declare(strict_types=1);

namespace App\Entity;

class EpolkaSettings implements \JsonSerializable
{
    private int $connectionInterval;

    private string $connectionHost;

    public function getConnectionInterval(): int
    {
        return $this->connectionInterval;
    }

    public function setConnectionInterval(int $connectionInterval): void
    {
        $this->connectionInterval = $connectionInterval;
    }

    public function getConnectionHost(): string
    {
        return $this->connectionHost;
    }

    public function setConnectionHost(string $connectionHost): void
    {
        $this->connectionHost = $connectionHost;
    }

    public function jsonSerialize()
    {
        return [
            'connection_interval' => $this->getConnectionInterval(),
            'connection_host' => $this->getConnectionHost(),
        ];
    }
}
