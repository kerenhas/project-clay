<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Photo;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DiaporamaController extends AbstractController
{
    
    
    public $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @Route("/diaporama", name="diaporama")
     */
    public function index(Request $request)
    {


        $idUser=$this->session->get("id");

        if(!$idUser)
        {
            return $this->redirectToRoute('login');    
        }

        $images=[];

        if($request->get("submit"))
        {
            $album=$this->getDoctrine()->getRepository(Album::class)->find($request->get("album"));

           

            foreach($album->getPhoto() as $v)
            {
                $images[]=$v->getPath();
            }
            
        }

        $user=$this->getDoctrine()->getRepository(User::class)->find($idUser);
        return $this->render('diaporama/index.html.twig', [
            'albums' =>$user->getAlbums(),
            'images'=>$images
        ]);
    }
}
