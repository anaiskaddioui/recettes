<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecettesController extends AbstractController {

    /**
     * @Route ("/recettes", name="recettes.index")
     * 
     */
    public function index () 
    {
        return $this->render("recettes/index.html.twig");
    }

}