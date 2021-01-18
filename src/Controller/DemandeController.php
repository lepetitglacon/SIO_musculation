<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Form\RepondreDemandeType;
use App\Repository\DemandeRepository;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    const NE_PAS_REPONDRE = 'nepasrepondre@sio2-gagneur.siopergaud.fr';
    const CONTACT_CLIENT = 'contact-client@sio2-gagneur.siopergaud.fr';

    /**
     * @Route("/demande", name="demande", methods={"GET","POST"})
     */
    public function show(Request $request, Swift_Mailer $mailer): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();


            $message = (new \Swift_Message('Hello Email'))
                ->setFrom(self::NE_PAS_REPONDRE)
                ->setTo($demande->getMail())
                ->setBody(
                    $this->renderView('mail/demande.html.twig', [
                            'demande' => $demande
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash(
                'info',
                'Le mail a bien été envoyé'
            );
            return $this->redirectToRoute('app_accueil');
        }



        return $this->render('demande/Front/demande.html.twig',[
            'demandes' => $demande,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/demande/", name="demande_index", methods={"GET"})
     */
    public function indexAdmin(DemandeRepository $demandeRepository): Response
    {
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/demande/repondre/{id}", name="demande_repondre", methods={"GET","POST"})
     */
    public function repondre(Request $request, Swift_Mailer $mailer, $id, DemandeRepository $repo): Response
    {
        $demande = $repo->findOneBy(["id" => $id]);
        $form = $this->createForm(RepondreDemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom(self::NE_PAS_REPONDRE)
                ->setTo($demande->getMail())
                ->setBody(
                    $this->renderView('mail/demande.html.twig', [
                            'demande' => $demande
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash(
                'info',
                'Le mail a bien été envoyé'
            );
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('demande/repondre.html.twig',[
            'demande' => $demande,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/demande/new", name="demande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('demande_index');
        }

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/demande/{id}", name="demande_show", methods={"GET"})
     */
    public function showAdmin(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    /**
     * @Route("/admin/demande/{id}/edit", name="demande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Demande $demande): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_index');
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/demande/{id}", name="demande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_index');
    }
}
