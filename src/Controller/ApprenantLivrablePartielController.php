<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApprenantLivrablePartielController extends AbstractController
{
    /**
     * @Route("/apprenant/livrable/partiel", name="apprenant_livrable_partiel")
     */
    public function index()
    {
        return $this->render('apprenant_livrable_partiel/index.html.twig', [
            'controller_name' => 'ApprenantLivrablePartielController',
        ]);
    }
}
