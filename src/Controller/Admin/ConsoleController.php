<?php

namespace App\Controller\Admin;

use App\Entity\Console;
use App\Form\ConsoleType;
use App\Repository\ConsoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsoleController extends AbstractController
{
    #[Route('/admin/consoles', name: 'app_admin_console')]
    public function index(ConsoleRepository $repo): Response
    {
        $consoles=$repo->findAll();
        $consoles=array_splice($consoles, 1);
        return $this->render('admin/console/listeAdmin.html.twig', [
            'controller_name' => 'ConsoleController',
            'lesConsoles' => $consoles
        ]);
    }

    #[Route('/admin/console/{id}', name: 'app_admin_console_edit', methods: ["GET", "POST"])]
    #[Route('/admin/console', name: 'app_admin_console_ajout', methods: ["GET", "POST"])]
    public function formulaire(?Console $console, Request $request, EntityManagerInterface $manager): Response
    {
        if ($console == null) {
            $console = new Console();
        }
        $form = $this->createForm(ConsoleType::class, $console);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($console);
            $manager->flush();
            return $this->redirectToRoute('app_admin_console');
        }
        return $this->render('admin/console/formConsole.html.twig', [
            'controller_name' => 'ConsoleController',
            'formConsole' => $form->createView(),
        ]);
    }

    #[Route('/admin/console/suppr/{id}', name: 'app_admin_console_suppr')]
    public function supprimer(Console $console, EntityManagerInterface $manager): Response
    {
        $manager->remove($console);
        $manager->flush();
        $this->addFlash("success", "la console à bien été supprimé");
        return $this->redirectToRoute('app_admin_console');
    }
}
