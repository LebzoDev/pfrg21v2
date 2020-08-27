<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{

    /**
     * @Route("admin/referentiels", name="list_referentiels", methods={"GET"})
     */
    public function listReferentiels(ReferentielRepository $repo){
        $referentiels = $repo->findAll();
        return $this->json($referentiels,200,[]);
    }

    /**
     * @Route("admin/referentiels/id/competences", name="list_competences_referentiel", methods={"GET"})
     */
    public function listCompetencesReferentiel(Referentiel $referentiel,CompetenceRepository $repo){
        $competences = $referentiel->getCompetenceVisees();
        return $this->json($competences,200,[]);
    }

    /**
     * @Route("admin/referentiel/{id}/addCompetence", name="referentiel_addCompetences", methods={"POST"})
     */
    public function index(Referentiel $referentiel, EntityManagerInterface $em, Request $request, CompetenceRepository $repo)
    {
        $data=$request->getContent();
        $tab=json_decode($data);
        $competence=$repo->findOneBy(["id"=>($tab->idCompetence)]);
        $referentiel->addCompetenceVisee($competence);
        $em->flush();
        return $this->json(Response::HTTP_OK); 
    }

    /**
     * @Route("admin/referentiel/{id}/removeCompetence",name="Referentiel_removeCompetence", methods={"POST"})
     */
    public function removeCompetences(Referentiel $referentiel, Request $request, CompetenceRepository $repo, EntityManagerInterface $em){
        $data = $request->getContent();
        $tab=json_decode($data);
        $competence=$repo->findOneBy(["id"=>($tab->idCompetence)]);
        $referentiel->removeCompetenceVisee($competence);
        $em->flush();
        return $this->json(Response::HTTP_OK);
     }

     /**
     * @Route("admin/referentiel/{id}/archive" , name="PutReferentielArchive", methods={"PUT"})
     */
    public function __invoke(Referentiel $object)
    {
        $referentiel_A_Archive = $object;
        $data = $referentiel_A_Archive->getArchive();
        if ($data==false) {
            $referentiel_A_Archive->setArchive(true);
        }
        $this->em->flush();
    }

    /**
     * @Route("admin/referentiel/{id}/desarchive" , name="PutReferentielDesarchive", methods={"PUT"})
     */
    public function DesarchiveReferentiel(Referentiel $object)
    {
        $referentiel_A_Archive = $object;
        $data = $referentiel_A_Archive->getArchive();
        if ($data==true){
            $referentiel_A_Archive->setArchive(false);
        }
        $this->em->flush();
       
    }
     

}
