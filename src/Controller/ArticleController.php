<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Utilisateur;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/Front/index.html.twig', [
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/Front/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/article", name="admin_article_index", methods={"GET"})
     */
    public function indexAdmin(): Response
    {
        return $this->render('article/Back/index.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/article/new", name="admin_article_new", methods={"GET","POST"})
     */
    public function newAdmin(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('article/Back/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}", name="admin_article_show", methods={"GET"})
     */
    public function showAdmin(Article $article): Response
    {
        return $this->render('article/Back/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function editAdmin(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('article/Back/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}", name="admin_article_delete", methods={"DELETE"})
     */
    public function deleteAdmin(Request $request, Article $article): Response
    {
        /*
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token')) && ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        */
        $this->addFlash(
            'danger',
            'Vous ne pouvez supprimer cet article'
        );
        return $this->redirectToRoute('article_index');
    }
}
