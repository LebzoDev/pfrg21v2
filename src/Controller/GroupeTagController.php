<?php

namespace App\Controller;

use App\Entity\GroupeTag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeTagController extends AbstractController
{
 /**
     * @Route("api/admin/groupe_tags/add", name="GroupeTag_add", methods={"POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, TagRepository $repo)
    {
        $data = $request->getContent();
        //dd($data);
       $groupeTag = $serializer->deserialize($data, GroupeTag::class, 'json');
        $tag = $repo-> findOneBy(['id'=>2]);
         $groupeTag->addTag($tag);
         $em->persist($groupeTag);
         $em->flush();
         return $this->json(Response::HTTP_OK,);
    }


    /**
     * @Route("api/admin/groupe_tags/{id}/removeTag",name="GroupeTag_remove_tag", methods={"POST"})
     */

     public function removeTag(GroupeTag $groupeTag, Request $request, TagRepository $repo, EntityManagerInterface $em){
        $data = $request->getContent();
        //dd($data);
        $tab=json_decode($data);
        //dd($tab->id);
        $tag=$repo->findOneBy(["id"=>($tab->id)]);
        $groupeTag->removeTag($tag);
        $em->flush();
        return $this->json(Response::HTTP_OK);
     }
     
    /**
     * @Route("api/admin/groupe_tags/{id}/addTag", name="GroupeTag_add_tag", methods={"POST"})
     */
     
     public function addTag(GroupeTag $groupeTag, Request $request, TagRepository $repo, EntityManagerInterface $em){
        $data = $request->getContent();
        $tab=json_decode($data);
        $tag=$repo->findOneBy(["id"=>($tab->id)]);
        $groupeTag->addTag($tag);
        $em->flush();
        return $this->json(Response::HTTP_OK); 
     }
}
