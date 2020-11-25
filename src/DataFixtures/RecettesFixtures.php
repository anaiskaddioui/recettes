<?php

namespace App\DataFixtures;

use App\Entity\Recettes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Type;
use App\Entity\User;

class RecettesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $entree = (new Type())->setNom('Entrée');
        $plat = (new Type())->setNom('Plat');
        $dessert = (new Type())->setNom('Dessert');

        $manager->persist($entree);
        $manager->persist($plat);
        $manager->persist($dessert);
        $manager->flush();


        $recette = new Recettes();
        $recette
            ->setTitle('titre 1')
            ->setDescription('description 1')
            ->setPreparation('preparation 1')
            ->setPersonnes(1)
            ->setTime('30 min')
            ->settype($entree);

        $manager->persist($recette);

        $manager->flush();
        
    }
}
