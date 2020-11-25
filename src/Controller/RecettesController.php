<?php 

namespace App\Controller;

use App\Entity\Recettes;
use App\Entity\User;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class RecettesController extends AbstractController {
    
    /**
     * @var RecettesRepository
     */
    private $repository;
        
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(RecettesRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    
    }
    /**
     * @Route ("/recettes", name="recettes.index")
     * @return Response
     */
    public function index () : Response
    {
        $recette = $this->repository->findRecettes(); //construite dans RecettesRepository et appelée ici

        $this->em->flush();
    
        return $this->render("recettes/index.html.twig");
    }

    /**
     * @Route ("/recettes/{slug}-{id}", name="recettes.show", requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Recettes $recette, string $slug) : Response
    {
        $userName = $recette->getAuteur();

        if ($userName) {
            $userName = $userName->getUsername();
        }else {
            $userName = "Inconnu";
        }


        if ($recette->getSlug() !== $slug)
        {
            return $this->redirectToRoute("recettes.show", [
                "id" => $recette->getId(),
                "slug" =>$recette->getSlug()
            ], 301); //301 = redirection permanente. Le redirectToRoute est très important pour le SEO
        }
        return $this->render("recettes/show.html.twig", [
            "recette" => $recette,
            "current_menu" => "recettes",
            "user" => $userName
        
        ]);
    }

}