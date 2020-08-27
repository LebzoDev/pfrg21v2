<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Niveau;
use App\Entity\Competence;
use App\Entity\GroupCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompetenceFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager)
    {
         //Build a new GroupCompetence Object
         $groupCompetence = new GroupCompetence();
         $groupCompetence->setLibelle("Libellé Groupe Competence 1");
         $groupCompetence->setDescriptif("Descriptif Groupe Competence 1");
         $groupCompetence->setArchive(false);
        

        $faker = Factory::create();
        for ($i = 0; $i <= 2; $i++) {
            //Buil a new Competence Object
            $competence = new Competence();
            $competence->setLibelle("Libellé Competence ".$i);
            $competence->setDescriptif("Descriptif Competence ".$i);
            for ($j=0; $j <3 ; $j++) { 
                 //Built a new Niveau Object
                    $niveau = new Niveau();
                    $niveau->setlibelle("Niveau".$j);
                    $niveau->setCritereDeval("Critere Devaluation ".$j);
                    $niveau->setGroupeDaction("Groupe dAction ".$j);
                    $niveau->setCompetence($competence);
                    $manager->persist($niveau);
            }
           
            $groupCompetence->addCompetence($competence);
            $manager->persist($competence);
        }
        $manager->persist($groupCompetence);
        $manager->flush();
    }
}
