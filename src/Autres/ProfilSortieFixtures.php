<?php

namespace App\DataFixtures;

use App\Entity\ProfilSortie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilSortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <5 ; $i++) { 
            $profil = new ProfilSortie();
            if ($i==0) {
                $profil-> setLibelleProfilSortie('Frontend');
            }elseif ($i==1) {
                $profil-> setLibelleProfilSortie('Backend');
            }elseif ($i==2) {
                $profil-> setLibelleProfilSortie('Fullstack');
            }elseif ($i==3) {
                $profil-> setLibelleProfilSortie('Designer');
            }elseif ($i==4) {
                $profil-> setLibelleProfilSortie('Chef de Projet');
            }  
            $manager->persist($profil);
        }

        $manager->flush();
    }
}
