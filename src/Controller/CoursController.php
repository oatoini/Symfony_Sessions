<?php

namespace App\Controller;

use App\Entity\Cours;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="app_cours")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $cours = $doctrine->getRepository(Cours::class)->findAll();

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }
}
