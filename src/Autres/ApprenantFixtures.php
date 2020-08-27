<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Profil;
use App\Entity\Apprenant;
use App\Repository\PromoRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CompetenceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\ApprenantRepository as Rep;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture
{
   
    protected $faker;
    private $encoder;
    private $repoPromo;
    private $repoCompe;
    public function __construct(CompetenceRepository $repoCompe,UserPasswordEncoderInterface $encoder, PromoRepository $repoPromo){     
        $this->encoder=$encoder;
        $this->repoPromo = $repoPromo;
        $this->repoCompe = $repoCompe;
    }
    public function load(ObjectManager $manager)
    {
        $promo1 = $this->repoPromo->findOneBy(['id'=>1]);
        $promo2 = $this->repoPromo->findOneBy(['id'=>2]);

        $profil = new Profil();
        $profil->setLibelleProfil('APPRENANT');
        $profil->setArchive(false);  
       $faker = Factory::create();
        // on créé 10 personnes
        for ($i = 0; $i <= 9; $i++) {
            $user = new Apprenant();
            $user->setLogin($faker->userName);
            $password =$this->encoder->encodePassword($user,"passer");
            $user->setPassword($password);
            $user->setPrenom($faker->firstNameMale);
            $user->setNom($faker->lastName);
            $user->setStatus("actif");
            $user->setProfil($profil);
            $user->setArchive(false);
            if ($i%2==0) {
                $user->setPromo($promo2);
            }else{
                $user->setPromo($promo1);
            }
            
            $user->setMail($faker->email);
            $manager->persist($user);
        }
        $manager->persist($profil);
        $manager->flush();
    }
}
