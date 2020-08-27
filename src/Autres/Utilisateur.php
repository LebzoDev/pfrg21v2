<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Profil;
use App\Entity\Utilisateur as User;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Utilisateur extends Fixture
{
    protected $faker;
    private $encoder;
    private $repoProfil;
    public function __construct(UserPasswordEncoderInterface $encoder, ProfilRepository $repoProfil){
        $this->encoder=$encoder;
        $this->repoProfil = $repoProfil;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // on créé 10 personnes
        for ($i = 0; $i <= 2; $i++) {
            $user = new User();
            $user->setLogin($faker->userName);
            $password =$this->encoder->encodePassword($user,"passer");
            $user->setPassword($password);
            $user->setPrenom($faker->firstNameMale);
            $user->setNom($faker->lastName);
            //Un objet de type profil         
            if ($i==0) {
                $profil = $this->repoProfil->findOneBy(['libelle_Profil'=>"ADMIN"]); 
            }elseif ($i==1) {
                $profil = $this->repoProfil->findOneBy(['libelle_Profil'=>"FORMATEUR"]); 
            }else {
                $profil = $this->repoProfil->findOneBy(['libelle_Profil'=>"CM"]); 
            }
            $user->setProfil($profil);
            $user->setMail($faker->email);
            $user->setArchive(false);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
