<?php

namespace App\Controller;

use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(RubriqueRepository $rubrique): Response
    {

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'menu' => $rubrique->findAll()
        ]);
    }
}
