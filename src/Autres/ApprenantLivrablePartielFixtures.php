<?php

namespace App\DataFixtures;

use DateTime;
use App\Repository\ApprenantRepository;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApprenantLivrablePartiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\LivrablePartielRepository;

class ApprenantLivrablePartielFixtures extends Fixture
{
    private $apprenant,$livPartiel;
    public function __construct(ApprenantRepository $apprenant, LivrablePartielRepository $livPartiel){
        $this->apprenant= $apprenant;
        $this->livPartiel = $livPartiel;
    }

    public function load(ObjectManager $manager)
    {
        $apprenants = $this->apprenant->findAll();
        $livPartiels = $this->livPartiel->findAll();
        foreach ($apprenants as $value) {
            $tabApprenants[]=$value;
        }
        foreach ($livPartiels as $key) {
            $tabLivPartiels[]=$key;
        }
        for($i=0; $i<10;$i++){
            $applivrable = new ApprenantLivrablePartiel();
            $applivrable->setDateSoumission(\DateTime::createFromFormat('d-m-Y', "12-10-2021"));
            $applivrable->setAffecte(true);
            $applivrable->setRendu(true);
            $applivrable->setARefaire(false);
            if($i==5 || $i==7){
                $applivrable->setValide(false);
            }else{
                $applivrable->setValide(true);
            }
            shuffle($tabApprenants);
            shuffle($tabLivPartiels);
            $applivrable->setApprenant($tabApprenants[0]);
            $applivrable->setLivrablePartiel($tabLivPartiels[0]);
            $manager->persist($applivrable);
        }

        $manager->flush();
    }
}
