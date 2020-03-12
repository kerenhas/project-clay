<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {

        $idUser=$this->getUser();

        if(!$idUser)
        {
            return $this->redirectToRoute('/login');
        }
        
        $user=$this->getDoctrine()->getRepository(User::class)->find($idUser);

        $photo=$this->getDoctrine()->getRepository(Albums::class)->findBy([
            "iduser"=>$user
        ]);

        

        return $this->render('accueil/index.html.twig', [
            'img1' => '',
            'img2' => '',
            'img3' => '',
        ]);
    }

    private function getUser()
    {
        session_start();
        if(!isset($_SESSION["id"]))
        {
            return false;
        }

        return $_SESSION["id"];
    }
}
