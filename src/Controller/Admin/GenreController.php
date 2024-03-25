<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Form\GenreType;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class GenreController extends AbstractController
{
    #[Route('/admin/genres', name: 'app_admin_genres')]
    public function liste(GenreRepository $repo, PaginatorInterface $p, Request $r): Response
    {
        $genres = $p->paginate(
            $repo->listePagine(),
            $r->query->getInt('page', 1),
            6
        );
        return $this->render('admin/genre/listeGenre.html.twig', [
            'controller_name' => 'GenreController',
            'genres' => $genres,
        ]);
    }

    #[Route('/admin/genre', name: 'app_admin_genre_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/genre/{id}', name: 'app_admin_genre_edit', methods: ['GET', 'POST'])]
    public function formulaire(?Genre $genre, Request $request, EntityManagerInterface $manager): Response
    {
        if ($genre == null) {
            $genre = new genre();
            // valeurs par défaut
            $genre->setCouleur('slate');
        }
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($genre);
            $manager->flush();
            return $this->redirectToRoute('app_admin_genres');
        }
        return $this->render('admin/genre/formGenre.html.twig', [
            'controller_name' => 'GenreController',
            'formGenre' => $form->createView(),
        ]);
    }

    #[Route('/admin/genre/suppr/{id}', name: 'app_admin_genre_suppr')]
    public function supprimer(Genre $genre, EntityManagerInterface $manager): Response
    {
        $manager->remove($genre);
        $manager->flush();
        $this->addFlash("success", "le genre à bien été supprimé");
        return $this->redirectToRoute('app_admin_genres');
    }
}
