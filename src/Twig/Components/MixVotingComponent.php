<?php

namespace App\Twig\Components;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('mix_voting')]
final class MixVotingComponent
{
    use DefaultActionTrait;

    #[LiveProp]
    public VinylMix $mix;

    #[LiveAction]
    public function vote(#[LiveArg] string $direction, EntityManagerInterface $entityManager)
    {
        if ($direction === 'up') {
            $this->mix->upVote();
        } else {
            $this->mix->downVote();
        }
        $entityManager->flush();
    }
}
