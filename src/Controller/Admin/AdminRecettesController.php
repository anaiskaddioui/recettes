<?php 

namespace App\Controller\Admin;

use App\Entity\Recettes;
use App\Form\RecettesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminRecettesController extends AbstractController {

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
     * @Route("/admin", name="admin.recettes.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index () : Response
    {
        $recettes = $this->repository->findAll();
        return $this->render("admin/recettes/index.html.twig", compact("recettes"));
    }

    /**
     * @param Recettes $recette
     * @param Request $request
     * @Route("/admin/recettes/create", name="admin.recettes.new")
     */
    public function new (Request $request)
    {
        $recette = new Recettes();

        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($recette);
            $this->em->flush();
            $this->addFlash('success', 'Recette ajoutée avec succès');
            return $this->redirectToRoute("admin.recettes.index", [], 301);
        }

        return $this->render("admin/recettes/new.html.twig", [
            "recette" => $recette,
            "form" => $form->createView()    
        ]);
    }

    /**
     * @Route("/admin/recettes/{id}", name="admin.recettes.edit", methods="GET|POST")
     * @param Recettes $recette
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Recettes $recette, Request $request)
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Recette modifiée avec succès');
            return $this->redirectToRoute('admin.recettes.index');
        }

        return $this->render("admin/recettes/edit.html.twig", [
            "recette" => $recette,
            "form" => $form->createView()    
        ]);
    }

    /**
     * @Route("/admin/recettes/{id}", name="admin.recettes.delete", methods="DELETE")
     * @param Recettes $recette
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (Recettes $recette, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->get('_token')))
        {
            $this->em->remove($recette);
            $this->em->flush();
            $this->addFlash('success', 'Recette supprimée avec succès');
        }
        
        return $this->redirectToRoute("admin.recettes.index", [], 301);
    }
}

?>