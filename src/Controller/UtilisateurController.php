<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurAdminType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TheSeer\Tokenizer\Exception;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="utilisateur_profile", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('utilisateur/Front/show.html.twig', [
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_profile');
        }

        return $this->render('utilisateur/Front/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin", name="admin_utilisateur_index", methods={"GET"})
     */
    public function indexAdmin(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/Back/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="admin_utilisateur_new", methods={"GET","POST"})
     */
    public function newAdmin(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/Back/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin_utilisateur_show", methods={"GET"})
     */
    public function showAdmin(UtilisateurRepository $utilisateur, $id): Response
    {
        return $this->render('utilisateur/Back/show.html.twig', [
            'utilisateur' => $utilisateur->findOneBy(['id' => $id]),
        ]);
    }


    /**
     * @Route("/admin/{id}/edit", name="admin_utilisateur_edit", methods={"GET","POST"})
     */
    public function editAdmin(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurAdminType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_utilisateur_index');
        }

        return $this->render('utilisateur/Back/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin_utilisateur_delete", methods={"DELETE"})
     */
    public function deleteAdmin(Request $request, Utilisateur $utilisateur): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($utilisateur);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Utilisateur supprimé'
                );
            }
        } catch (\Doctrine\DBAL\Exception $e){
            $this->addFlash(
                'danger',
                'Utilisateur ne peut etre supprimé'
            );
        }




        return $this->redirectToRoute('admin_utilisateur_index');
    }
}
