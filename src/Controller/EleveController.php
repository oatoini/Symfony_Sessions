<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Session;
use App\Form\EleveType;
use App\Form\InscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController
{
    /**
     * @Route("/eleve", name="app_eleve")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $eleves = $doctrine->getRepository(Eleve::class)->findAll();

        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }


    /**
     * @Route("/eleve/add", name="add_eleve")
     */

    public function add(ManagerRegistry $doctrine, Eleve $eleve = null, Request $request): Response {

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $eleve = $form->getData();
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('app_eleve');
        }

        return $this->render('eleve/add.html.twig', [
            'formEleve' => $form->createView()
        ]);
    }


    /**
     * @Route("/eleve/register", name="register_eleve")
     */

    public function register(ManagerRegistry $doctrine, Eleve $eleve = null, Session $session = null, Request $request): Response {

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $eleve = $form->getData();
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('app_eleve');
        }

        return $this->render('eleve/register.html.twig', [
            'formInscrip' => $form->createView()
        ]);
    }


    /**
     * @Route("/eleve/{id}", name="show_eleve")
     */
    public function show(Eleve $eleve): Response{
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve
        ]);
    }
}
