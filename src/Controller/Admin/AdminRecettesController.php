<?php 

namespace App\Controller\Admin;

use App\Entity\Recettes;
use App\Form\RecettesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecettesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminRecettesController extends AbstractController {

    /**
     * @var RecettesRepository
     */
    private $repository;

    public function __construct(RecettesRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin", name="admin.recettes.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index () 
    {
        $recettes = $this->repository->findAll();
        return $this->render("admin/recettes/index.html.twig", compact("recettes"));
    }

    /**
     * @Route("/admin/{id}", name="admin.recettes.edit")
     * @param Recettes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Recettes $recette)
    {
        $form = $this->createForm(RecettesType::class, $recette);
        return $this->render("admin/recettes/edit.html.twig", [
            "recette" => $recette,
            "form" => $form->createView()    
        ]);
    }
}

?>