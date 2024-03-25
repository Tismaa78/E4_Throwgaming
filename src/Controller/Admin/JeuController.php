<?php

namespace App\Controller\Admin;

use App\Repository\JeuRepository;
use App\Entity\Jeu;
use App\Form\JeuType;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class JeuController extends AbstractController
{
    #[Route('/admin/jeux', name: 'app_admin_jeux')]
    public function liste(JeuRepository $repo, PaginatorInterface $p, Request $r): Response
    {
        $jeux = $p->paginate(
            $repo->listePagine(),
            $r->query->getInt('page', 1),
            6
        );
        return $this->render('admin/jeu/index.html.twig', [
            'controller_name' => 'JeuController',
            'jeux' => $jeux,
        ]);
    }

    #[Route('/admin/jeu/{id}', name: 'app_admin_jeu_edit', methods: ["GET", "POST"])]
    #[Route('/admin/jeu', name: 'app_admin_jeu_ajout', methods: ["GET", "POST"])]
    public function formulaire(?Jeu $jeu, Request $request, EntityManagerInterface $manager): Response
    {
        if ($jeu == null) {
            $jeu = new Jeu();
            // valeurs par défaut
            $jeu->setVentes(0);
        }
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($jeu);
            $manager->flush();
            return $this->redirectToRoute('app_admin_jeux');
        }
        return $this->render('admin/jeu/form.html.twig', [
            'controller_name' => 'JeuController',
            'formJeu' => $form->createView(),
        ]);
    }

    #[Route('/admin/jeu/suppr/{id}', name: 'app_admin_jeu_suppr')]
    public function supprimer(Jeu $jeu, EntityManagerInterface $manager): Response
    {
        $manager->remove($jeu);
        $manager->flush();
        $this->addFlash("success", "le jeu à bien été supprimé");
        return $this->redirectToRoute('app_admin_jeux');
    }
}
