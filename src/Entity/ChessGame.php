<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChessGameRepository")
 */
class ChessGame
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $player1White;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $player2Black;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDateTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameResult", inversedBy="chessGames")
     */
    private $result;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1White(): ?User
    {
        return $this->player1White;
    }

    public function setPlayer1White(?User $player1White): self
    {
        $this->player1White = $player1White;

        return $this;
    }

    public function getPlayer2Black(): ?User
    {
        return $this->player2Black;
    }

    public function setPlayer2Black(?User $player2Black): self
    {
        $this->player2Black = $player2Black;

        return $this;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getResult(): ?GameResult
    {
        return $this->result;
    }

    public function setResult(?GameResult $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }
}
