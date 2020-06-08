<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="test_epolka_ids")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class TestEpolkaId
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=128)
     */
    private string $epolkaId;

    public function getEpolkaId(): string
    {
        return $this->epolkaId;
    }

    public function setEpolkaId(string $epolkaId): void
    {
        $this->epolkaId = $epolkaId;
    }
}
