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

        $user=$this->getDoctrine()->getRepository(User::class)->find($idUser);
        
        $album=$user->getAlbums();

        $image0="https://bhmlib.org/wp-content/themes/cosimo-pro/images/no-image-box.png";
        $image1="https://bhmlib.org/wp-content/themes/cosimo-pro/images/no-image-box.png";
        $image2="https://bhmlib.org/wp-content/themes/cosimo-pro/images/no-image-box.png";

        if(count($album))
        {
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
