<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\User;
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
            return $this->redirectToRoute('login');    
        }

        
        
        $photo=$this->getDoctrine()
        ->getManager()
        ->createQueryBuilder()
        ->select('a')
        ->from(Albums::class, 'a')
        ->join('a.iduser','b')
        ->where('b.id = :user_id')
        ->setParameter('user_id', $idUser)
        ->getQuery()
        ->getResult();

        dump($photo);

        

        return $this->render('accueil/index.html.twig', [
            'img1' => '',
            'img2' => '',
            'img3' => '',
        ]);
    }

    protected function getUser()
    {
        
        if(!isset($_SESSION["id"]))
        {
            return false;
        }

        return $_SESSION["id"];
    }
}
