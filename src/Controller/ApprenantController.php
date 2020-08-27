<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\UtilisateurController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $validator;
    private $decorated;
    public function __construct(UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator,NormalizerInterface $decorated)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->decorated=$decorated;
    }
    /**
     * @Route(
     *     name="addApprenant",
     *     path="/api/addApprenant",
     *     methods={"POST"},
     *     defaults={
     *          "controller"="App\Controller\ApprenantController::addApprenant",
     *          "__api_resource_class"=Apprenant::class,
     *          "__api_collection_operation_name"="add_apprenant"
     *     }
     * )
     */
    public function addApprenant(Request $request)
    {
        //Recuperation des données
        $array = $request->request->all();
        //dd($arpprenant);

        $photo = $request->files->get("photo");
        //dd($photo);

        $apprenant = new Apprenant();
        $apprenant->setPrenom($array['prenom']);
        $apprenant->setNom($array['nom']);
        $apprenant->setLogin($array['Login']);
        $apprenant->setPassword($array['password']);
        $apprenant->setStatus($array['status']);
        $apprenant->setMail($array['mail']); 

        //$apprenant = $this->decorated->denormalize($user,Utilisateur::class,true);
        $photo = fopen($photo->getRealPath(),"rb");
        //$user->setPhoto($photo);
        $apprenant->setPhoto($photo);
        
        /*$errors = $this->validator->validate($apprenant);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }*/
        $password = $apprenant->getPassword();
        //dd($apprenant);
        $apprenant->setPassword($this->encoder->encodePassword($apprenant,$password));

        $em = $this->getDoctrine()->getManager();
        $em->persist($apprenant);
        $em->flush();
        fclose($photo);
       
        
        return $this->json("success",201);
    }
}