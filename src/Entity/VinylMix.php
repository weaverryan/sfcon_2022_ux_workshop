<?php

namespace App\Entity;

use App\Repository\VinylMixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: VinylMixRepository::class)]
class VinylMix
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column]
    private int $votes = 0;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['title'])]
    private ?string $slug = null;

    /**
     * @var Collection<Track>
     */
    #[ORM\OneToMany(mappedBy: 'mix', targetEntity: Track::class, orphanRemoval: true)]
    #[ORM\OrderBy(['trackNumber' => 'ASC'])]
    private Collection $tracks;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrackCount(): ?int
    {
        return count($this->tracks);
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function upVote(): void
    {
        $this->votes++;
    }

    public function downVote(): void
    {
        $this->votes--;
    }

    public function getVotesString(): string
    {
        $prefix = ($this->votes === 0) ? '' : (($this->votes >= 0) ? '+' : '-');

        return sprintf('%s %d', $prefix, abs($this->votes));
    }

    public function getImageUrl(int $width): string
    {
        return sprintf(
            'https://picsum.photos/id/%d/%d',
            ($this->getId() + 50) % 1000, // number between 0 and 1000, based on the id
            $width
        );
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Track>
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks->add($track);
            $track->setMix($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getMix() === $this) {
                $track->setMix(null);
            }
        }

        return $this;
    }

    public function getMinutesRemaining(): int
    {
        $length = 0;
        foreach ($this->tracks as $track) {
            $length += $track->getLength();
        }

        return floor(($this->getTotalPossibleSeconds() - $length) / 60);
    }

    public function getTotalPossibleMinutes(): int
    {
        return floor($this->getTotalPossibleSeconds() / 60);
    }

    private function getTotalPossibleSeconds(): int
    {
        return 60 * 60;
    }

    public function getNextTrackNumber(): int
    {
        $maxTrack = 0;
        foreach ($this->getTracks() as $track) {
            $maxTrack = max($maxTrack, $track->getTrackNumber());
        }

        return $maxTrack + 1;
    }
}
