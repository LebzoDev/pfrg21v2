<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\Referentiel;
use App\Entity\CompetencesValides;
use App\Repository\NiveauRepository;
use App\Repository\ApprenantRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompetencesValidesRepository;
use App\Repository\ApprenantLivrablePartielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetencesAcquisesController extends AbstractController
{
    private $amanger;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    /**
     * @Route("formateurs/promo/{id}/referentiel/{referentielId}/competences", name="competences_acquises", methods={"GET"})
     */
    public function index(Promo $promo,$referentielId,ApprenantRepository $repoApprenant,ApprenantLivrablePartielRepository $repoApplivrablePartiel,CompetenceRepository $repoCompetence,NiveauRepository $repoNiveaux, CompetencesValidesRepository $repoComptVal)
    {
        //Mise à jour | Supprsion////////////
        $comptValides = $repoComptVal->findAll();
        foreach ($comptValides as $product) {
            $this->manager->remove($product);
        }
        $this->manager->flush();
        ////////////////////////////////////////

        $id=$promo->getId();
        //Selection de tous les apprenants
       $apprenants = $promo->getApprenants();
       //Mettre les apprenants dans un tableau
       foreach ($apprenants as $apprenant) {
         $tab[]=$apprenant;
       }
       //Recuperer tous les livrables partiels de chaque apprenant
       $app_livrable_partiel = $repoApplivrablePartiel->findAll();
       //Parcourir les livrables partiels et recuperer ceux valides
       foreach ($app_livrable_partiel as $alps) {
            if($alps->getValide()==true){
                $tab2[]=$alps;
            }
       }
       $tab3=array();
       $tab4=array();
       $tab5=array();
       //S'il en existe recuperer les librables valides
       if(!empty($tab2)){
           foreach ($tab2 as $alps1) {
               if (!in_array(($alps1->getLivrablePartiel()),$tab3)) {
                    $tab3[] = $alps1->getLivrablePartiel();
               }
           }
       }
       //Recuperer en retour les niveaux de chaque livrable
       if(!empty($tab3)){
        foreach ($tab3 as $alps2) {
        //Recuperer les niveaux
        $alps3 = $alps2->getNiveau();
        if (!in_array($alps3,$tab4)) {
            $tab4[]=$alps3;
        }
       //Les competences des niveaux
        $key=$alps3->getCompetence();
            if (!in_array($key,$tab5)) {
                $tab5[]=$key;
            }
        }
    }

    ///////////////////////////////////////////////////////
    $apprenants_ = $repoApprenant->findAll();
    foreach($apprenants_ as $apprenant){
        if (in_array($apprenant,$tab)) {
           foreach($tab2 as $applivrable){
             if ($apprenant===($applivrable->getApprenant())) {
                 if($applivrable->getValide()==true){
                    $comptValide = new CompetencesValides();
                    $livrablePartiel = $applivrable->getLivrablePartiel();
                    $niveau = $livrablePartiel->getNiveau();
                    $competence = $niveau->getCompetence();
                    $comptValide->setApprenant($apprenant);
                    $comptValide->setCompetence($competence);
                    if (($niveau->getLibelle())=="Niveau0") {
                        $comptValide->setNiveau1(true);
                        $comptValide->setNiveau2(false);
                        $comptValide->setNiveau3(false);
                    }elseif (($niveau->getLibelle())=="Niveau1") {
                        $comptValide->setNiveau1(false);
                        $comptValide->setNiveau2(true);
                        $comptValide->setNiveau3(false);
                    }else{
                        $comptValide->setNiveau1(false);
                        $comptValide->setNiveau2(false);
                        $comptValide->setNiveau3(true);
                    }
                    $apprenant->addCompetencesValide($comptValide);
                    $this->manager->persist($comptValide);
                 }
             }   
            
           }
        }
    }
   $this->manager->flush();
    return $this->json($apprenants_,200,[],['groups'=>'post:apprenant']);
    ////////////////////////////////////////////////////////////////////////
}
/**
     * @Route("apprenant/{apprenantId}/promo/{id}/referentiel/{referentielId}/competences", name="competences_acquises_apprenant", methods={"GET"})
     */
    public function index1($apprenantId,Promo $promo,$referentielId,ApprenantRepository $repoApprenant,ApprenantLivrablePartielRepository $repoApplivrablePartiel,CompetenceRepository $repoCompetence,NiveauRepository $repoNiveaux, CompetencesValidesRepository $repoComptVal)
    {
        $id=$promo->getId();
        //Selection de tous les apprenants
       $apprenants = $promo->getApprenants();
       //Mettre les apprenants dans un tableau
       foreach ($apprenants as $apprenant) {
         $tab[]=$apprenant;
       }
       //Recuperer tous les livrables partiels de chaque apprenant
       $app_livrable_partiel = $repoApplivrablePartiel->findAll();
       //Parcourir les livrables partiels et recuperer ceux valides
       foreach ($app_livrable_partiel as $alps) {
            if($alps->getValide()==true){
                $tab2[]=$alps;
            }
       }
       $tab3=array();
       $tab4=array();
       $tab5=array();
       //S'il en existe recuperer les librables valides
       if(!empty($tab2)){
           foreach ($tab2 as $alps1) {
               if (!in_array(($alps1->getLivrablePartiel()),$tab3)) {
                    $tab3[] = $alps1->getLivrablePartiel();
               }
           }
       }
       //Recuperer en retour les niveaux de chaque livrable
       if(!empty($tab3)){
        foreach ($tab3 as $alps2) {
        //Recuperer les niveaux
        $alps3 = $alps2->getNiveau();
        if (!in_array($alps3,$tab4)) {
            $tab4[]=$alps3;
        }
       //Les competences des niveaux
        $key=$alps3->getCompetence();
            if (!in_array($key,$tab5)) {
                $tab5[]=$key;
            }
        }
    }

    $apprenants_ = $repoApprenant->findAll();
    foreach ($apprenants_ as $apprenant) {
        if (($apprenant->getId())==$apprenantId) {
            $apprenant_ =  $apprenant;
        }
    }

    if (!empty($apprenant_))
    {
        return $this->json($apprenant_,200,[],['groups'=>'post:apprenant']);
    }
}
/**
 * @Route("formateurs/promo/{id}/referentiel/{referencielId}/statistiques/competences" , name="statistiques", methods={"GET"})
 */
public function statistique(){

}
}