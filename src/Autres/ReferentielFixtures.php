<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Promo;
use App\Entity\GroupPromo;
use App\Entity\Referentiel;
use App\Repository\PromoRepository;
use App\Repository\ProfilRepository;
use App\Repository\ApprenantRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CompetenceRepository;
use App\Repository\ReferentielRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\GroupCompetenceRepository;

class ReferentielFixtures extends Fixture
{
    private $repoCompetence;
    private $repoPromo;
    private $repoReferentiel;
    private $repoApprenant;
    private $repoFormateur;
    private $repoProfil;
    public function __construct(ProfilRepository $repoProfil,GroupCompetenceRepository $repoCompetence,PromoRepository $repoPromo,ReferentielRepository $repoReferentiel, ApprenantRepository $repoApprenant,UtilisateurRepository $repoFormateur){
        $this->repoCompetence= $repoCompetence;
        $this->repoPromo = $repoPromo;
        $this->repoReferentiel = $repoReferentiel;
        $this->repoApprenant= $repoApprenant;
        $this->repoFormateur = $repoFormateur;
        $this->repoProfil = $repoProfil;
    }
    public function load(ObjectManager $manager)
    {
        //Creer un referentiel
        $referentiel = new Referentiel();
        $referentiel->setLibelle('libelle');
        $referentiel->setPresentation('Presentation');
        $referentiel->setProgramme('Programme');
        $referentiel->setCritereDev('Criteres d\'evaluations');
        $referentiel->setArchive(false);
         //Creer un groupe promo
         $groupPromo = new GroupPromo();
         $groupPromo->setNom("Nom");
         $groupPromo->setDateCreation(new DateTime('now'));
         //Inclure tous les apprenant
         $apprenants = $this->repoApprenant->findAll();
         foreach ($apprenants as $apprenant) {
             $groupPromo->addApprenant($apprenant);
         }
         $profil = $this->repoProfil->findOneBy(['libelle_Profil'=>"FORMATEUR"]);
         
         $formateur = $this->repoFormateur->findOneBy(["id"=>($profil->getId())]);
         $groupPromo->setFormateur($formateur);

         for ($i=0; $i<3; $i++){            
            $promo = new Promo();
            $promo->setLieu('Lieu');
            $promo->setReferenceAgate('Reference d\'agregation');
            $promo->setTitre('Titre'.$i);
            $promo->setDateDebut(\DateTime::createFromFormat('d-m-Y', "10-10-2020"));
            $promo->setDateFin(\DateTime::createFromFormat('d-m-Y', "12-10-2021"));
            $promo->setLangue('Français');
            $promo->setDescrpition('Description');
            $promo->setFabrique('Fabrique');
            //Associer nos promos à un referentiel
            $promo->setReferentiel($referentiel);
            $promo->addGroupPromo($groupPromo);
            $manager->persist($promo);
            $referentiel->addPromo($promo);
       }
       $manager->persist($groupPromo);

        //Ajout de toutes les competences sur cette referentiels
        $competences = $this->repoCompetence->findAll();    
            foreach ($competences as $competence){
                $referentiel->addCompetenceVisee($competence);
            }
            
            $manager->persist($referentiel);

        $manager->flush();
    }
}
