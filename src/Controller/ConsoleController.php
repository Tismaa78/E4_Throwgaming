<?php

namespace App\Controller;

use App\Entity\Console;
use App\Repository\ConsoleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsoleController extends AbstractController
{
    #[Route('/console', name: 'app_console')]
    public function listeConsole(ConsoleRepository $repo): Response
    {
        $consoles=$repo->findAll();
        $consoles=array_splice($consoles, 1);
        return $this->render('console/listeConsole.html.twig', [
            'controller_name' => 'ConsoleController',
            'lesConsoles' => $consoles
        ]);
    }

    #[Route('/console/{id}', name: 'app_ficheConsole')]
    public function ficheConsole(Console $console): Response
    {
        return $this->render('console/ficheConsole.html.twig', [
            'controller_name' => 'ConsoleController',
            'console'=>$console
        ]);
    }
}
