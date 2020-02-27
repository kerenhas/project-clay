<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        $error="";
        
        if($request->get("submit"))
        {
            $res=$this->getDoctrine()->getRepository(User::class)->findBy([
                "mail"=>$request->get("mail"),
                "pwd"=>$request->get("pwd")
            ]);
            if($res)
            {
                $_SESSION["id"]=$res->getId();
                header("location:/");
            }else
            {
                $error="mauvais identifiants";
            }
        }
        

        return $this->render('login/index.html.twig', [
                'error' => $error,
            ]);
        
        
    }

    
}
