<?php

namespace App\Controller;

use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(VinylMixRepository $vinylMixRepository): Response
    {
        $mix = $vinylMixRepository->findLatest();

        return $this->redirectToRoute('app_mix_edit', [
            'slug' => $mix->getSlug()
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository, Request $request, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            9
        );

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'pager' => $pagerfanta,
        ]);
    }
}
