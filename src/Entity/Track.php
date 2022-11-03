<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $songTitle = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $artistName = null;

    #[ORM\Column]
    #[NotBlank]
    #[GreaterThanOrEqual(0)]
    private ?int $length = null;

    #[ORM\Column]
    private ?int $trackNumber = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VinylMix $mix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSongTitle(): ?string
    {
        return $this->songTitle;
    }

    public function setSongTitle(string $songTitle): self
    {
        $this->songTitle = $songTitle;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(string $artistName): self
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getMix(): ?VinylMix
    {
        return $this->mix;
    }

    public function setMix(?VinylMix $mix): self
    {
        $this->mix = $mix;

        return $this;
    }

    public function getTrackNumber(): ?int
    {
        return $this->trackNumber;
    }

    public function setTrackNumber(int $trackNumber): self
    {
        $this->trackNumber = $trackNumber;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s (by %s)', $this->songTitle, $this->artistName);
    }
}
