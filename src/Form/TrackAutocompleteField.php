<?php

namespace App\Form;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class TrackAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Track::class,
            'placeholder' => 'Choose a song',
            'choice_label' => function(Track $track) {
                return sprintf('%s (by %s)', $track->getSongTitle(), $track->getArtistName());
            },

            'query_builder' => function(TrackRepository $trackRepository) {
                return $trackRepository->createQueryBuilder('track');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
