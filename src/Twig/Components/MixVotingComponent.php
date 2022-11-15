<?php

namespace App\Twig\Components;

use App\Entity\VinylMix;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('mix_voting')]
final class MixVotingComponent
{
    use DefaultActionTrait;

    public VinylMix $mix;
}
