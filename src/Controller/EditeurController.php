<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Repository\EditeurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EditeurController extends AbstractController
{
    #[Route('/editeur', name: 'app_editeur')]
    public function listeEditeur(EditeurRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $editeurs = $paginator->paginate(
            $repo->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            12 /* limit per page */
        );

        return $this->render('editeur/listeEditeur.html.twig', [
            'controller_name' => 'EditeurController',
            'lesEditeurs' => $editeurs
        ]);
    }

    #[Route('/editeur/{id}', name: 'fiche_editeur')]
    public function ficheEditeur(Editeur $editeur): Response
    {
        return $this->render('editeur/ficheEditeur.html.twig', [
            'controller_name' => 'EditeurController',
            'leEditeur' => $editeur
        ]);
    }
}