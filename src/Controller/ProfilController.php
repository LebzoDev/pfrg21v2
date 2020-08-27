<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProfilRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
    $this->em=$em;
    }
   
    public function __invoke(Profil $data)
    {
        $profil_A_Archive = $data;
        $data = $profil_A_Archive->getArchive();
        if ($data==false) {
            $profil_A_Archive->setArchive(true);
        }else{
            $profil_A_Archive->setArchive(false);
        }
       
        $this->em->flush();
        dd($profil_A_Archive, $data);
    }
}
