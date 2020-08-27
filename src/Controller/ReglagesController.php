<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReglagesController extends AbstractController
{
    /**
     * @Route("/reglages", name="reglages", methods={"PUT"})
     */
    public function index(EntityManagerInterface $manager,ApprenantRepository $repoApp,PromoRepository $repoPromo)
    {
      $promo1 = $repoPromo->findOneBy(['id'=>5]);
      $apprenants = $repoApp->findAll();
      
      foreach ($apprenants as $apprenant) {
          $status = $apprenant->getStatus();
          if ($status=="actif") {
            $promo1->addApprenant($apprenant);
            //$manager->persist($promo1);          
          }
      }
      $manager->flush();
      //dd($status,$promo1,$apprenants);
      return $this->json("success",200);
    }
}
