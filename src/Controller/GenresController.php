<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    #[Route('/genres', name: 'app_genres')]
    public function index(GenreRepository $repo): Response
    {
        $genres = $repo->findAll();

        return $this->render('genres/listeGenre.html.twig', [
            'controller_name' => 'GenresController',
            'genres' => $genres,
        ]);
    }
}
