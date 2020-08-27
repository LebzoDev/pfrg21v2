<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\LivrablePartiel;
use App\Repository\NiveauRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LivrablePartielFixtures extends Fixture
{
    private $repoNiveau;
    public function __construct(NiveauRepository $repoNiveau){
        $this->repoNiveau = $repoNiveau;
    }
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<10; $i++){
            $livrablePartiel = new LivrablePartiel();
            $livrablePartiel->setLibelle('libellé '.$i);
            $livrablePartiel->setDelai(\DateTime::createFromFormat('d-m-Y', "12-10-2021"));
            $livrablePartiel->setDescription('libellé '.$i);
            $livrablePartiel->setType('individuel');
            $livrablePartiel->setNombreRendu(0);
            $livrablePartiel->setNombreCorrige(0);
                $rang = rand(32,40);
                $niveau = $this->repoNiveau->findOneBy(['id'=>$rang]);
                $livrablePartiel->setNiveau($niveau);
            $manager->persist($livrablePartiel);

        }
        $manager->flush();
    }
}
