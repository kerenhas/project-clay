<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{

    public $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


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
            
            //on recupere les valeurs saisies dans notre formulaire
            $user = $form->getData();
    //recherche dans la bdd
            $res=$this->getDoctrine()->getRepository(User::class)->findOneBy([
                "mail"=>$user->getMail(),
                "mdp"=>$user->getMdp()
            ]);
//si il y a un resultat c'est que la connexion est bonne
            if($res)
            {
                
                $this->session->set("id",$res->getId());
                return $this->redirectToRoute('accueil');
            }else
            {
                $error="Mauvais identifiants";
            }
           
        }
        return $this->render('login/index.html.twig', [
                'error' => $error,
                'form' => $form->createView()
            ]);
        
        
    }

    
}
