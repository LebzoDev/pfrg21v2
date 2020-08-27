<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Entity\Competence;
use App\Entity\GroupCompetence;
use App\Repository\NiveauRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupCompetenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    /**
     * @Route("api/group_competences/{id}/addCompetence", name="addCompetence", methods={"POST"})
     */
    public function addCompetence(Request $request,GroupCompetence $groupCompetence,CompetenceRepository $repo){
        $data = $request->getContent();
        $idCompetence = (json_decode($data))->idCompetence;
        $competence = $repo->findOneBy(['id'=>$idCompetence]);
        try {
            if(isset($competence)){
                $groupCompetence->addCompetence($competence);
            }
            $this->em->flush();
            return $this->json(Response::HTTP_OK);
            } catch (Exception $e) {
                return $this->json(Response::HTTP_OK);
            }
    }
    /**
     * @Route("api/group_competences/{id}/removeCompetence", name="removeCompetence", methods={"POST"})
     */
    public function removeCompetence(Request $request,GroupCompetence $groupCompetence,CompetenceRepository $repo){
        $data = $request->getContent();
        $idCompetence = (json_decode($data))->idCompetence;
        $competence = $repo->findOneBy(['id'=>$idCompetence]);
        try {
        if(isset($competence)){
            $groupCompetence->removeCompetence($competence);
        }
        $this->em->flush();
        return Response($groupCompetence,200);
        } catch (Exception $e) {
            return Response($e->getMessage(),401);
        }
    }
    /**
     * @Route("api/competences/add", name="PostCompentence", methods={"POST"})
     */
    public function index(EntityManagerInterface $manager,Request $request,SerializerInterface $serialiser,GroupCompetenceRepository $repo)
    {
        $data = $request->getContent();
        $id= (json_decode($data))->id;
        $competence = $serialiser->deserialize($data,Competence::class,'json');
    
        for ($i=0; $i <=2 ; $i++) { 
            $niveau = new Niveau();
            $niveau->setlibelle("Libellé Niveau ".$i);
            $niveau->setCritereDeval("Critere Devaluation ".$i);
            $niveau->setGroupeDaction("Groupe dAction ".$i);
            $niveau->setCompetence($competence);

            $competence->addNiveau($niveau);
            $manager->persist($niveau);
        }
        $groupCompetence = $repo->findOneBy(['id'=>$id]);
        $competence->addGroupCompetence($groupCompetence);
        $manager->persist($competence);
        //$manager->flush();
        dd($id,$data,$competence,$groupCompetence);
    }

    /**
     * @Route("api/group_competences/add", name="PostGroupCompentence", methods={"POST"})
     */
    public function indexGroup(EntityManagerInterface $manager,Request $request,SerializerInterface $serialiser,CompetenceRepository $repo)
    {
        $data = $request->getContent();
        //Get ID of Competence which we will integrate in this group
        $id= (json_decode($data))->idCompetence;
        $groupCompetence = $serialiser->deserialize($data,GroupCompetence::class,'json');
        $competence = $repo->findOneBy(['id'=>$id]);
        $groupCompetence->addCompetence($competence);
        $manager->persist($groupCompetence);
        //$manager->flush();
        dd($data,$competence,$groupCompetence);
    }

    /**
     * @Route("api/competences/{id}/archive" , name="PutCompetenceArchive", methods={"PUT"})
     */
    public function __invoke(Competence $object)
    {
        $competence_A_Archive = $object;
        //Recuperer la valeur de l'attribut archive
        $data = $competence_A_Archive->getArchive();
        if ($data==false) {
            $competence_A_Archive->setArchive(true);
        }
        $this->em->flush();
        dd($competence_A_Archive, $data);
    }

    /**
     * @Route("api/competences/{id}/desarchive" , name="PutCompetenceDesarchive", methods={"PUT"})
     */
    public function DesarchiveCompetence(Competence $object)
    {
        $competence_A_Archive = $object;
        //Recuperer la valeur de l'attribut archive
        $data = $competence_A_Archive->getArchive();
        if ($data==true){
            $competence_A_Archive->setArchive(false);
        }
        $this->em->flush();
        dd($competence_A_Archive, $data);
    }

    /**
     * @Route("api/group_competences/{id}/archive" , name="PutGroupCompetenceArchive", methods={"PUT"})
     */
    public function ArchiveGroupCompetence(GroupCompetence $object)
    {
        $competence_A_Archive = $object;
        //Recuperer la valeur de l'attribut archive
        $data = $competence_A_Archive->getArchive();
        if ($data==false) {
            $competence_A_Archive->setArchive(true);
        }
        $this->em->flush();
        dd($competence_A_Archive, $data);
    }

    /**
     * @Route("api/group_competences/{id}/desarchive" , name="PutGroupCompetenceDesarchive", methods={"PUT"})
     */
    public function DesarchiveGroupCompetence(GroupCompetence $object)
    {
        $competence_A_Archive = $object;
        //Recuperer la valeur de l'attribut archive
        $data = $competence_A_Archive->getArchive();
        if ($data==true){
            $competence_A_Archive->setArchive(false);
        }
        $this->em->flush();
        dd($competence_A_Archive, $data);
    }

}
