<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    public $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {

        $idUser=$this->session->get("id");

        if(!$idUser)
        {
            return $this->redirectToRoute('login');    
        }

        //on recupere le bon objet de user
        $user=$this->getDoctrine()->getRepository(User::class)->find($idUser);
        
        //on recupere une collection albums
        $album=$user->getAlbums();

        $image0="../img1.jpg";
        $image1="../img2.jfif";
        $image2="../img3.jfif";

        if(count($album))
        {
            //On recupere les photos du premier album pour les afficher dns la premiere page
            $photo=$album[0]->getPhoto();

            if(count($photo))
            {
                $image0=$photo[0]?$photo[0]->getPath():$image0;
                $image1=$photo[1]?$photo[1]->getPath():$image1;
                $image2=$photo[1]?$photo[1]->getPath():$image2;
            }
        }


        return $this->render('accueil/index.html.twig', [
            'img1' => $image0,
            'img2' => $image1,
            'img3' => $image2,
        ]);
    }

    
}
