<?php

namespace App\Twig\Components;

use App\Entity\VinylMix;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('mix_voting')]
final class MixVotingComponent
{
    use DefaultActionTrait;

    public VinylMix $mix;

    #[LiveProp(writable: true)]
    public string $firstName = 'Ryan';
}
