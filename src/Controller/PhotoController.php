<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Photo;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class PhotoController extends AbstractController
{

    public $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @Route("/photo", name="photo")
     */
    public function index(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $idUser=$this->session->get("id");

        if(!$idUser)
        {
            return $this->redirectToRoute('login');    
        }

        if($request->get("submit"))
        {
            $album=$this->getDoctrine()->getRepository(Album::class)->find($request->get("album"));

            
            foreach ($_FILES["photo"]["name"] as $key => $error) {

                $tmp_name = $_FILES["photo"]["tmp_name"][$key];
                // basename() peut empêcher les attaques de système de fichiers;
                // la validation/assainissement supplémentaire du nom de fichier peut être approprié
                $name =str_replace(" ","-",iconv("UTF-8", "ASCII//TRANSLIT", $_FILES["photo"]["name"][$key]));
                if(!file_exists("upload/$name"))
                {
                    move_uploaded_file($tmp_name, "upload/$name");
                }

                $photo=new Photo();

                
                $photo->setPath("upload/$name");
            
                $entityManager->persist($photo);

                $album->addPhoto($photo);

            }

            $entityManager->flush();
        }

        $user=$this->getDoctrine()->getRepository(User::class)->find($idUser);
        


        return $this->render('photo/index.html.twig', [
            'albums' => $user->getAlbums(),
        ]);
    }
}
