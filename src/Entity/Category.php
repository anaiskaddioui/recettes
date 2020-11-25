<?php 

namespace App\Entity;

use App\Entity\Recettes;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Category extends AbstractController {

    private $entree = " Entrée";
    private $sale = "Salé";
    private $sucré = "Sucré";
    private $boisson = "Boisson";

    

}