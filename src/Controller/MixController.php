<?php

namespace App\Controller;

use App\Entity\VinylMix;
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
}
