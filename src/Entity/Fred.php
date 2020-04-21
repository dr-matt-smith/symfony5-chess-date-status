<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FredRepository")
 */
class Fred
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dinnerTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDinnerTime(): ?\DateTimeInterface
    {
        return $this->dinnerTime;
    }

    public function setDinnerTime(\DateTimeInterface $dinnerTime): self
    {
        $this->dinnerTime = $dinnerTime;

        return $this;
    }
}
