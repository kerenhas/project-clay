<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\LoginFormType;
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

        $user=new User();

        $form = $this->createForm(LoginFormType::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $user = $form->getData();
    
            $res=$this->getDoctrine()->getRepository(User::class)->findOneBy([
                "mail"=>$user->getMail(),
                "mdp"=>$user->getMdp()
            ]);

            if($res)
            {
                $_SESSION["id"]=$res->getId();
                return $this->redirectToRoute('/');
                exit;
            }else
            {
                $error="mauvais identifiants";
            }
           
        }
        return $this->render('login/index.html.twig', [
                'error' => $error,
                'form' => $form->createView()
            ]);
        
        
    }

    
}
