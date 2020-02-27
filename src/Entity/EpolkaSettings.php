<?php declare(strict_types=1);

namespace App\Entity;

class EpolkaSettings implements \JsonSerializable
{
    private string $connectionInterval;

    public function getConnectionInterval(): string
    {
        return $this->connectionInterval;
    }

    public function setConnectionInterval(string $connectionInterval): void
    {
        $this->connectionInterval = $connectionInterval;
    }

    public function jsonSerialize()
    {
        return [
            'connection_interval' => $this->getConnectionInterval()
        ];
    }
}
