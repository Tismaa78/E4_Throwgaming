<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user', methods: ['GET'])]
    public function info(Utilisateur $user): Response
    {
        return $this->render('user/fiche.html.twig', [
            'controller_name' => 'UserController',
            'utilisateur'=>$user,
        ]);
    }
}
