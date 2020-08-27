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

class UtilisateurController extends AbstractController
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
     *     name="addUser",
     *     path="/api/addUser",
     *     methods={"POST"},
     *     defaults={
     *          "controller"="App\Controller\UtilisateurController::add",
     *          "__api_resource_class"=Utilisateur::class,
     *          "__api_collection_operation_name"="add_user"
     *     }
     * )
     */
    public function add(Request $request)
    {
        //Recuperation des données
        $array = $request->request->all();
        $photo = $request->files->get("photo");
        //dd($photo);

        $utilisateur = new User();
        $utilisateur->setPrenom($array['prenom']);
        $utilisateur->setNom($array['nom']);
        $utilisateur->setLogin($array['Login']);
        $utilisateur->setPassword($array['password']);
        $utilisateur->setMail($array['mail']); 

        //$apprenant = $this->decorated->denormalize($user,Utilisateur::class,true);
        $photo = fopen($photo->getRealPath(),"rb");
        //$user->setPhoto($photo);
        $utilisateur->setPhoto($photo);
        
        $password = $utilisateur->getPassword();
        //dd($apprenant);
        $utilisateur->setPassword($this->encoder->encodePassword($utilisateur,$password));

        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();
        fclose($photo);
       
        
        return $this->json("success",201);
    }
}