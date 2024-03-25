<?php

namespace App\Controller;

// repositories
use App\Repository\GenreRepository;
use App\Repository\JeuRepository;
use App\Repository\ConsoleRepository;
use App\Repository\EditeurRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(GenreRepository $gRep, JeuRepository $jRep, ConsoleRepository $cRep, EditeurRepository $eRep): Response
    {
        $genres   = $gRep->findAll();
        $cptJeux  = count($jRep->findAll());
        $cptCons  = count($cRep->findAll());
        $cptEdit  = count($eRep->findAll());

        $isAdmin = false;
        $u = $this->getUser();
        if ($u) {
            foreach ($u->getRoles() as $role) {
                if ($role == "ROLE_ADMIN") { $isAdmin = true; }
            }
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'genres' => $genres,
            'cptJeux' => $cptJeux,
            'cptCons' => $cptCons,
            'cptEdit' => $cptEdit,
        ]);
    }
}
