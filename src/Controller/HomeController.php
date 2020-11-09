<?php 

namespace App\Controller;

use App\Repository\RecettesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {

    //Affichera la page d'accueil 

    /**
     * @Route ("/", name= "home")
     * @param RecettesRepository $repository
     * @return Response
     */
    public function index (RecettesRepository $repository) : Response
    {
        $recettes = $repository->findLatest();
        return $this->render("pages/home.html.twig" , [
                    "recettes" => $recettes
        ]);
    }

}