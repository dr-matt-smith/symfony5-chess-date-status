<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameResultRepository")
 */
class GameResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChessGame", mappedBy="result")
     */
    private $chessGames;

    public function __construct()
    {
        $this->chessGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ChessGame[]
     */
    public function getChessGames(): Collection
    {
        return $this->chessGames;
    }

    public function addChessGame(ChessGame $chessGame): self
    {
        if (!$this->chessGames->contains($chessGame)) {
            $this->chessGames[] = $chessGame;
            $chessGame->setResult($this);
        }

        return $this;
    }

    public function removeChessGame(ChessGame $chessGame): self
    {
        if ($this->chessGames->contains($chessGame)) {
            $this->chessGames->removeElement($chessGame);
            // set the owning side to null (unless already changed)
            if ($chessGame->getResult() === $this) {
                $chessGame->setResult(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->description;
    }
}
