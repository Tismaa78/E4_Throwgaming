<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Repository\JeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class JeuController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeu')]
    public function listeJeu(JeuRepository $repo, PaginatorInterface $p, Request $r): Response
    {
        $jeux = $p->paginate(
            $repo->listePagine(),
            $r->query->getInt('page', 1),
            6
        );
        return $this->render('jeu/listeJeu.html.twig', [
            'controller_name' => 'JeuController',
            'jeux' => $jeux,
        ]);
    }

    #[Route('/jeu/{genre}', name: 'app_jeu_filtre')]
    public function listeJeuFiltre(JeuRepository $repo, PaginatorInterface $p, Request $r, string $genre): Response
    {
        $jeux = $p->paginate(
            $repo->findByGenreP($genre),
            $r->query->getInt('page', 1),
            6
        );
        dump($repo->findByGenreP($genre)->getSQL());
        return $this->render('jeu/listeJeu.html.twig', [
            'controller_name' => 'JeuController',
            'jeux' => $jeux,
        ]);
    }

    #[Route('/ficheJeu/{id}', name: 'app_ficheJeu')]
    public function ficheJeu(Jeu $jeu): Response
    {        
        $u = $this->getUser();
        $hasGame = false;
        // si l'utilisateur dispose déjà du jeu dans sa bibli ou son panier
        // alors il ne pourra pas en rajouter
        if ($u) {
            $l = $u->getLibrairie()->getJeux();
            $p = $u->getPanier();
            foreach($l as $jl) {
                if ($jl == $jeu) {$hasGame = true;}
            }
            
            foreach($p as $jp) {
                if ($jp == $jeu) {$hasGame = true;}
            }
        }
        return $this->render('jeu/ficheJeu.html.twig', [
            'controller_name' => 'JeuController',
            'jeu' => $jeu,
            'hasGame' => $hasGame,
        ]);
    }
    
    // logique panier

    #[Route('/panier', name: 'app_panier')]
    public function showPanier(): Response
    {
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null) { return $this->redirectToRoute('app_jeu'); }
        return $this->render('jeu/panier/listePanier.html.twig', [
            'controller_name' => 'JeuController',
            'panier' => $u->getPanier(),
        ]);
    }
    
    #[Route('/panier/ajouter/{id}', name: 'app_panier_add')]
    public function addJeu(Jeu $jeu, EntityManagerInterface $manager): Response
    {
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null) { return $this->redirectToRoute('app_jeu'); }
        foreach ($u->getPanier() as $j) {
            // le jeu est déjà dans le panier
            if ($j == $jeu) { return $this->redirectToRoute('app_jeu'); }
        }
        $u->addPanier($jeu);
        $manager->persist($u);
        $manager->flush();
        return $this->redirectToRoute('app_jeu');
    }
    
    #[Route('/panier/retirer/{id}', name: 'app_panier_rem')]
    public function remJeu(Jeu $jeu, EntityManagerInterface $manager): Response
    {
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null) { return $this->redirectToRoute('app_jeu'); }
        // foreach ($u->getPanier() as $j) {
        //     // le jeu est déjà dans le panier
        //     if ($j == $jeu) { return $this->redirectToRoute('app_jeu'); }
        // }
        $u->removePanier($jeu);
        $manager->persist($u);
        $manager->flush();
        return $this->redirectToRoute('app_panier');
    }
    
    #[Route('/panier/confirmer', name: 'app_panier_validate')]
    public function validPanier(EntityManagerInterface $manager): Response
    {
        //** @todo implémenter la librairie de l'utilisateur */
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null) { return $this->redirectToRoute('app_jeu'); }

        // récup le panier et la librairie
        $p = $u->getPanier();

        // dump le panier dans la librairie
        foreach($p as $jp) {
            $u->addLibrairie($jp);
        }

        // vide le panier
        $u->clearPanier();

        $manager->persist($u);
        $manager->flush();

        return $this->redirectToRoute('app_librairie');
    }
    
    #[Route('/panier/vider', name: 'app_panier_clear')]
    public function clearPanier(EntityManagerInterface $manager): Response
    {
        //** @todo implémenter la librairie de l'utilisateur */
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null || empty($u->getpanier())) { return $this->redirectToRoute('app_jeu'); }

        // vide le panier
        $u->clearPanier();

        $manager->persist($u);
        $manager->flush();

        return $this->redirectToRoute('app_panier');
    }
    
    // logique bibliothèque

    #[Route('/librairie', name: 'app_librairie')]
    public function showLibrairie(): Response
    {
        //** @todo implémenter la librairie de l'utilisateur */
        $u = $this->getUser();
        // il faut être connecté pour ajouter un jeu à son panier
        if ($u == null) { return $this->redirectToRoute('app_jeu'); }
        dump($u->getLibrairie());

        return $this->render('jeu/librairie/listeLibrairie.html.twig', [
            'controller_name' => 'JeuController',
            'librairie' => $u->showLibrairie(),
        ]);
    }
}
