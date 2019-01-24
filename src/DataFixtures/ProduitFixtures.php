<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Produits;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $produitDesigual = new Produits();
        $produitLancaster = new Produits();
        $produitDesigual2 = new Produits();
        $produitLancaster2 = new Produits();
        $produitLancaster3 = new Produits();
        $produitLancaster4 = new Produits();
        $produitLancaster5 = new Produits();
        $produitLancaster6 = new Produits();
        $produitLancaster7 = new Produits();
        $produitLancaster8 = new Produits();
        $produitLancaster9 = new Produits();
        $produitLancaster10 = new Produits();
        $produitLancaster11 = new Produits();
        $produitLancaster12 = new Produits();

        $produitDesigual->setReference("18WAXP90")
                ->setMarque("Desigual")
                ->setModele("Ares Varsovia")
                ->setCategorie("Femme")
                ->setCouleur("Bordeaux / Noir")
                ->setPrix("69.95")
                ->setPoids("0.7")
                ->setDimension("24cm x 21cm x 6cm")
                ->setMatiere("Textile / Synthétique")
                ->setDescription("<p>On craque sans aucun doute pour ce joli modèle présentant de jolies teintes métallisées sur un effet patchwork.
                Ce sac comporte une bandoulière fixe et réglable, un rabat aimanté sur le devant avec poche plaquée dessous et une poche zippée à l'arrière.
                La partie intérieure comprend une poche zippée et une poche plaquée avec surpoche zippée sur une doublure textile bordeaux assortie.</p>")
                        ->setImage("http://www.boreal-maroquinerie.com/1948-8662-large/desigual-bols-ares-varsovia.jpg");

        $produitLancaster->setReference("571-28")
                ->setMarque("Lancaster")
                ->setModele("Cuir Parisienne Treasure")
                ->setCategorie("Femme")
                ->setCouleur("Cognac / Noir / Rouge")
                ->setPrix("159.00")
                ->setPoids("0.9")
                ->setDimension("20cm x 21cm x 11cm")
                ->setMatiere("Cuir de vachette pleine fleur")
                ->setDescription("<p>Le petit sac seau cognac de la nouvelle collection en cuir Parisienne Pur Treasure par Lancaster.
                Un sac seau à bandoulière pour femme très chic et tendance, fabriqué en cuir de vachette souple.
                Ce petit sac seau Lancaster cognac se ferme par un lacet en cuir
                Ce petit sac seau Pur Treasure cognac par Lancaster comporte une petite poche fermée et une poche simple.
                La bandoulière en chainette argentée est réglable à la longueur souhaitée.</p>")
                        ->setImage("http://www.boreal-maroquinerie.com/1929-8573-large/lancaster-cuir-parisienne-treasure.jpg");

        $produitDesigual2->setReference("18WAXF35")
                ->setMarque("Desigual")
                ->setModele("Blue Painter Rotterdam")
                ->setCategorie("Femme")
                ->setCouleur("Bleu")
                ->setPrix("79.95")
                ->setPoids("0.7")
                ->setDimension("45cm x 28cm x 16cm")
                ->setMatiere("Textile / Synthétique")
                ->setDescription("<p>A la recherche d'un sac qui vous ressemble ?
                Si vous vous arrêtez sur cette création Desigual, c'est qu'elle est forcément faite pour vous !
                Une couleur violette pour un air contemporain et un format idéal pour emporter tout ce dont nous avons besoin : voilà ses atouts.
                On aime tout de ce produit : son design, sa forme et son panache.
                Il viendra compléter une tenue avec brio.
                Grand espace de rangement avec poches internes et emplacement téléphone, fermeture principale à glissière, poches externes avec zip, 2 anses ajustables et une bandoulière réglable et amovible</p>")
                ->setImage("http://www.boreal-maroquinerie.com/1939-8627-large/desigual-bols-blue-painter-rotterdam.jpg");

        $produitLancaster2->setReference("110-27")
                ->setMarque("Lancaster")
                ->setModele("Basic Sport")
                ->setCategorie("Femme")
                ->setCouleur("Bleu-Marron")
                ->setPrix("59.00")
                ->setPoids("0.2")
                ->setDimension("20cm x 12cm x 3cm")
                ->setMatiere("Textile / Synthétique")
                ->setDescription("<p>Tout-en-un Lancaster, compatible avec un chéquier et à assortir avec les sacs 'Basic & Sport'.
                Il est muni de 16 emplacements pour cartes bancaires, d'une poche pour votre chéquier (talon en haut), d'une autre poche pour la carte grise, le permis de conduire et la carte d'identité et d'une poche à billets.
                Au dos, un porte-monnaie à deux soufflets et entièrement zippé.</p>")
                ->setImage("http://www.boreal-maroquinerie.com/1962-8730-large/lancaster-basic-sport.jpg");

        $produitLancaster3->setReference("129-16")
                ->setMarque("Lancaster")
                ->setModele("Cuir Dune")
                ->setCategorie("Femme")
                ->setCouleur("Bordeaux / Noir")
                ->setPrix("110.00")
                ->setPoids("0.1")
                ->setDimension("19cm x 12cm x 3cm")
                ->setMatiere("Cuir de vachette pleine fleur")
                ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
                A associer avec un sac Dune  pour un total look tendance !
                Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                 Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
                ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");

           $produitLancaster4->setReference("229-16")
                   ->setMarque("Lancaster")
                   ->setModele("Cuir Dune")
                   ->setCategorie("Femme")
                   ->setCouleur("Bordeaux / Noir")
                   ->setPrix("110.00")
                   ->setPoids("0.1")
                   ->setDimension("19cm x 12cm x 3cm")
                   ->setMatiere("Cuir de vachette pleine fleur")
                   ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
                   A associer avec un sac Dune  pour un total look tendance !
                   Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                    Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
                   ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");


         $produitLancaster5->setReference("329-16")
                ->setMarque("Lancaster")
                ->setModele("Cuir Dune")
                ->setCategorie("Femme")
                ->setCouleur("Bordeaux / Noir")
                ->setPrix("110.00")
                ->setPoids("0.1")
                ->setDimension("19cm x 12cm x 3cm")
                ->setMatiere("Cuir de vachette pleine fleur")
                ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
                A associer avec un sac Dune  pour un total look tendance !
                Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                 Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
                ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");



          $produitLancaster6->setReference("429-16")
                   ->setMarque("Lancaster")
                   ->setModele("Cuir Dune")
                   ->setCategorie("Femme")
                   ->setCouleur("Bordeaux / Noir")
                   ->setPrix("110.00")
                   ->setPoids("0.1")
                   ->setDimension("19cm x 12cm x 3cm")
                   ->setMatiere("Cuir de vachette pleine fleur")
                   ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
                   A associer avec un sac Dune  pour un total look tendance !
                   Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                    Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
                   ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");



         $produitLancaster7->setReference("529-16")
                 ->setMarque("Lancaster")
                 ->setModele("Cuir Dune")
                 ->setCategorie("Femme")
                 ->setCouleur("Bordeaux / Noir")
                 ->setPrix("110.00")
                 ->setPoids("0.1")
                 ->setDimension("19cm x 12cm x 3cm")
                 ->setMatiere("Cuir de vachette pleine fleur")
                 ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
                 A associer avec un sac Dune  pour un total look tendance !
                 Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                  Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
                 ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");



       $produitLancaster8->setReference("629-16")
               ->setMarque("Lancaster")
               ->setModele("Cuir Dune")
               ->setCategorie("Femme")
               ->setCouleur("Bordeaux / Noir")
               ->setPrix("110.00")
               ->setPoids("0.1")
               ->setDimension("19cm x 12cm x 3cm")
               ->setMatiere("Cuir de vachette pleine fleur")
               ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
               A associer avec un sac Dune  pour un total look tendance !
               Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
                Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
               ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");

     $produitLancaster9->setReference("629-16")
             ->setMarque("Lancaster")
             ->setModele("Cuir Dune")
             ->setCategorie("Femme")
             ->setCouleur("Bordeaux / Noir")
             ->setPrix("110.00")
             ->setPoids("0.1")
             ->setDimension("19cm x 12cm x 3cm")
             ->setMatiere("Cuir de vachette pleine fleur")
             ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
             A associer avec un sac Dune  pour un total look tendance !
             Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
              Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
             ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");

   $produitLancaster10->setReference("629-16")
          ->setMarque("Lancaster")
          ->setModele("Cuir Dune")
          ->setCategorie("Femme")
          ->setCouleur("Bordeaux / Noir")
          ->setPrix("110.00")
          ->setPoids("0.1")
          ->setDimension("19cm x 12cm x 3cm")
          ->setMatiere("Cuir de vachette pleine fleur")
          ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
          A associer avec un sac Dune  pour un total look tendance !
          Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
           Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
          ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");

     $produitLancaster11->setReference("629-16")
             ->setMarque("Lancaster")
             ->setModele("Cuir Dune")
             ->setCategorie("Femme")
             ->setCouleur("Bordeaux / Noir")
             ->setPrix("110.00")
             ->setPoids("0.1")
             ->setDimension("19cm x 12cm x 3cm")
             ->setMatiere("Cuir de vachette pleine fleur")
             ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
             A associer avec un sac Dune  pour un total look tendance !
             Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
              Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
             ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");

   $produitLancaster12->setReference("629-16")
           ->setMarque("Lancaster")
           ->setModele("Cuir Dune")
           ->setCategorie("Femme")
           ->setCouleur("Bordeaux / Noir")
           ->setPrix("110.00")
           ->setPoids("0.1")
           ->setDimension("19cm x 12cm x 3cm")
           ->setMatiere("Cuir de vachette pleine fleur")
           ->setDescription("<p>Réalisé en cuir de vachette pleine fleur grainé, ce portefeuille Dune Lancaster pour femme vous apportera totale satisfaction.
           A associer avec un sac Dune  pour un total look tendance !
           Chic et féminin avec sa bride décorative et son rabat, ce grand portefeuille Dune en cuir  signé Lancaster est aussi pratique que beau avec ses 16 fentes pour cartes, ses emplacements pour billets et son grand porte-monnaie zippé.
            Son grand volume permet également de ranger un chéquier à l'intérieur.</p>")
           ->setImage("http://www.boreal-maroquinerie.com/2017-9031-large/lancaster-cuir-dune.jpg");


        $manager->persist($produitDesigual);
        $manager->persist($produitLancaster);
        $manager->persist($produitDesigual2);
        $manager->persist($produitLancaster2);
        $manager->persist($produitLancaster3);
        $manager->persist($produitLancaster4);
        $manager->persist($produitLancaster5);
        $manager->persist($produitLancaster6);
        $manager->persist($produitLancaster7);
        $manager->persist($produitLancaster8);
        $manager->persist($produitLancaster9);
        $manager->persist($produitLancaster10);
        $manager->persist($produitLancaster11);
        $manager->persist($produitLancaster12);


        $manager->flush();
    }
}
