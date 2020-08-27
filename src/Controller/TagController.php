<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\GroupeTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("api/admin/tags/add", name="api_tags_PostTag_collection", methods={"POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, GroupeTagRepository $repo)
    {
        $data = $request->getContent();
        $tag = $serializer->deserialize($data, Tag::class, 'json');
        $groupeTag = $repo-> findOneBy(['id'=>2]);
        $tag->addGroupeTag($groupeTag);
        $em->persist($tag);
        $em->flush();
        return $this->json(Response::HTTP_OK,);
    }

    
}
