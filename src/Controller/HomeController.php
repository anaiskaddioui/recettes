<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    //Affichera la page d'accueil 

    /**
     * @Route ("/", name= "home")
     */
    public function index () 
    {
        return $this->render("pages/home.html.twig");
    }

}