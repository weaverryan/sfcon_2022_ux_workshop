<?php

namespace App\Controller;

use App\Entity\Track;
use App\Entity\VinylMix;
use App\Form\TrackFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/edit/{slug}', name: 'app_mix_edit')]
    public function edit(VinylMix $mix): Response
    {
        return $this->render('mix/edit.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/edit/{slug}/add-song', name: 'app_mix_edit_add_song')]
    public function editAddSong(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $track = new Track();
        $mix->addTrack($track);
        $form = $this->createForm(TrackFormType::class, $track);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $track->setTrackNumber($mix->getNextTrackNumber());

            $entityManager->persist($track);
            $entityManager->flush();

            return $this->redirectToRoute('app_mix_edit', [
                'slug' => $mix->getSlug(),
            ]);
        }

        return $this->render('mix/addSong.html.twig', [
            'mix' => $mix,
            'form' => $form,
        ]);
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction', 'up');
        if ($direction === 'up') {
            $mix->upVote();
        } else {
            $mix->downVote();
        }

        $entityManager->flush();
        $this->addFlash('success', 'Vote counted!');

        return $this->redirectToRoute('app_mix_show', [
            'slug' => $mix->getSlug(),
        ]);
    }

    #[Route('/mix/edit/{id}/remove-song', name: 'app_mix_edit_remove_track')]
    public function editRemoveSong(Track $track, EntityManagerInterface $entityManager): Response
    {
        $mix = $track->getMix();
        $entityManager->remove($track);
        $entityManager->flush();

        $this->addFlash('success', 'Track removed!');

        return $this->redirectToRoute('app_mix_edit', [
            'slug' => $mix->getSlug(),
        ]);
    }
}
