<?php

namespace App\DataFixtures;

// entités du catalogue
use App\Entity\Jeu;
use App\Entity\Genre;
use App\Entity\Console;
use App\Entity\Editeur;
// utils
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Catalogue extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // charge les fichiers csv
        function loadCsv(String $nom): array {
            $f = fopen(__DIR__."/Database/".$nom.".csv", 'r');
            while (!feof($f)) { $data[] = fgetcsv($f); }
            fclose($f);
            // on exclue la ligne de header
            return $data;
        }

        // instance de faker traduit en FR
        $faker = Factory::create("fr-FR");

        // chargement des consoles
        $consoles = loadCsv("Consoles");
        // lecture des données
        foreach ($consoles as $ligne) {
            $console = new Console();
            $console->setNom($ligne[1]);
            // on enregistre l'entité console crée
            $manager->persist($console);
            $this->addReference("console".$ligne[0], $console);
        }

        // chargement des éditeurs
        $editeurs = loadCsv("Editeurs");
        // lecture des données
        foreach ($editeurs as $ligne) {
            $editeur = new Editeur();
            $editeur->setNom($ligne[1]);
            // on enregistre l'entité éditeur crée
            $manager->persist($editeur);
            $this->addReference("editeur".$ligne[0], $editeur);
        }

        // chargement des genres
        $genres = loadCsv("Genres");
        // lecture des données
        foreach ($genres as $ligne) {
            $genre = new Genre();
            $genre->setLibelle($ligne[1]);
            // on enregistre l'entité genre crée
            $manager->persist($genre);
            $this->addReference("genre".$ligne[0], $genre);
        }

        // chargement des jeux
        $jeux = loadCsv("Jeux");
        // lecture des données
        foreach ($jeux as $ligne) {
            $jeu = new Jeu();
            $jeu->setTitre($ligne[1])
                ->addConsole($this->getReference("console".$ligne[2]))
                ->setGenre($this->getReference("genre".$ligne[4]))
                ->setEditeur($this->getReference("editeur".$ligne[5]))
                ->setDate(intval($ligne[3]))
                ->setPrix(0.0)
                ->setVentes(floatval($ligne[6]));
            // on enregistre l'entité jeu crée
            $manager->persist($jeu);
        }

        $manager->flush();
    }
}
