<?php

namespace App\Controller\Admin;

use App\Entity\Editeur;
use App\Repository\EditeurRepository;
use App\Form\EditeurType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class EditeurController extends AbstractController
{
    #[Route('/admin/editeurs', name: 'app_admin_editeurs')]
    public function liste(EditeurRepository $repo): Response
    {
        $editeurs = $repo->findAll();
        return $this->render('admin/editeur/listeEditeurs.html.twig', [
            'controller_name' => 'EditeurController',
            'editeurs' => $editeurs,
        ]);
    }

    #[Route('/admin/editeur', name: 'app_admin_editeur_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/editeur/{id}', name: 'app_admin_editeur_edit', methods: ['GET', 'POST'])]
    public function formulaire(?Editeur $editeur, Request $request, EntityManagerInterface $manager): Response
    {
        if ($editeur == null) {
            $editeur = new editeur();
            // valeurs par défaut
        }
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($editeur);
            $manager->flush();
            return $this->redirectToRoute('app_admin_editeurs');
        }
        return $this->render('admin/editeur/formEditeurs.html.twig', [
            'controller_name' => 'EditeurController',
            'formEditeur' => $form->createView(),
        ]);
    }

    #[Route('/admin/editeur/suppr/{id}', name: 'app_admin_editeur_suppr')]
    public function supprimer(Editeur $editeur, EntityManagerInterface $manager): Response
    {
        $manager->remove($editeur);
        $manager->flush();
        $this->addFlash("success", "l'editeur à bien été supprimé");
        return $this->redirectToRoute('app_admin_editeurs');
    }
}
