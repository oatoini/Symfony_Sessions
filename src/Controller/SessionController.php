<?php

namespace App\Controller;
use App\Entity\Session;
use App\Form\SessionType;
use App\Form\ProgrammeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }


    /**
     * @Route("/session/add", name="add_session")
     *  @Route("/session/update/{id}", name="update_session")
     */

    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response {

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/add.html.twig', [
            'formSession' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/program", name="program_session")
     */

    public function register(ManagerRegistry $doctrine, Session $session = null, Request $request): Response {

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ProgrammeType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $program = $form->getData();
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/program.html.twig', [
            'formProg' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(Session $session): Response{
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/session/delete/{id}", name="delete_session")
     */
    public function delete(ManagerRegistry $doctrine, Session $session){
        $entityManager = $doctrine->getManager();
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute("app_session");
    }
}
