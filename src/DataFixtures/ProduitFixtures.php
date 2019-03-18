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
        $produitArthurEtAston = new Produits();
        $produitArthurEtAston2 = new Produits();
        $produitJlFoures = new Produits();
        $produitRiter = new Produits();
        $produitDesigual3 = new Produits();
        $produitLancaster3 = new Produits();
        $produitDesigual4 = new Produits();
        $produitLancaster4 = new Produits();
        $produitArthurEtAston3 = new Produits();
        $produitTest1 = new Produits();
        $produitTest2 = new Produits();
        $produitTest3 = new Produits();
        $produitTest4 = new Produits();
        $produitTest5 = new Produits();

        $produitDesigual->setReference("19SAXPGF")
                ->setMarque("Desigual")
                ->setModele("Abby Siberia")
                ->setCategorie("femme")
                ->setCouleur("Cognac / Noir")
                ->setPrix("62.96")
                ->setPoids("0.7")
                ->setDimension("36cm x 24cm x 2cm")
                ->setMatiere("Cuir")
                ->setDescription("<p>Nous avons conçu ce sac en PU noir à bandoulière amovible en forme de demi-lune avec de discrets mandalas gravés ton sur ton.
                Une bande horizontale à boucle orne l'accessoire et inclut un charm Desigual qui lui apporte une note contrastante de couleur rouge.</p>")
                        ->setImage("/imagesProduits/desigual-bols-abby-siberia.jpg");

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
                        ->setImage("/imagesProduits/lancaster-cuir-parisienne-treasure.jpg");

        $produitDesigual2->setReference("19SAXPE0")
                ->setMarque("Desigual")
                ->setModele("Water Mandala Loverty")
                ->setCategorie("Femme")
                ->setCouleur("Blanc")
                ->setPrix("69.95")
                ->setPoids("0.7")
                ->setDimension("29cm x 24cm x 9cm")
                ->setMatiere("Simili cuir")
                ->setDescription("<p>Sac à main blanc à mandalas imprimés et taches de peinture. Son intérieur bleu à pochette supplémentaire se ferme à l'aide d'un zip à effet arc-en-ciel. Porte-le avec ses deux poignées ou avec sa longue bandoulière.</p>")
                ->setImage("/imagesProduits/desigual-bols-water-mandala-loverty.jpg");

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
                ->setImage("/imagesProduits/lancaster-basic-sport.jpg");

        $produitArthurEtAston->setReference("1613605")
                ->setMarque("Arthur et Aston")
                ->setModele("Ligne Victoria")
                ->setCategorie("Femme")
                ->setCouleur("Beige")
                ->setPrix("43.60")
                ->setPoids("0.6")
                ->setDimension("24cm x 23cm x 7cm")
                ->setMatiere("Cuir")
                ->setDescription("<p>Sac à main , porté travers , en croute de cuir de vachette et doublure polyester.
                Nouvelle collection été 2016.</p>")
                ->setImage("/imagesProduits/arthur-et-aston-ligne-victoria.jpg");

           $produitArthurEtAston2->setReference("1647-10")
                   ->setMarque("Arthur et Aston")
                   ->setModele("Cuir Dune")
                   ->setCategorie("Homme")
                   ->setCouleur("Noir")
                   ->setPrix("179.00")
                   ->setPoids("1.2")
                   ->setDimension("35cm x 27cm x 12cm")
                   ->setMatiere("Cuir")
                   ->setDescription("<p>À en juger par son apparence, cette GIBECIERE CUIR EPAIS – Huilé de la marque ARTHUR & ASTON a tout d'un sac solide depuis les détails les plus flagrants jusqu'aux moindres petits détails.
                   Entièrement confectionnée en cuir, le corps ainsi que la bandoulière témoignent parfaitement de sa solidité, faisant de ce sac un indispensable du quotidien.</p>")
                   ->setImage("/imagesProduits/arthur-et-aston-cuir-huile.jpg");


         $produitJlFoures->setReference("9247")
                ->setMarque("JL Foures")
                ->setModele("Cuir Baroudeur")
                ->setCategorie("Homme")
                ->setCouleur("Chataigne / Cognac")
                ->setPrix("36.00")
                ->setPoids("0.1")
                ->setDimension("10cm x 7cm x 2cm")
                ->setMatiere("Cuir")
                ->setDescription("<p>Porte monnaie cuvette , porte carte , JL FOURES , en cuir de vachette souple pleine fleur , au toucher gras et de fabrication française.</p>")
                ->setImage("/imagesProduits/jl-foures-cuir-baroudeur.jpg");



          $produitRiter->setReference("96712")
                   ->setMarque("Ritelle")
                   ->setModele("Cuir Vachette")
                   ->setCategorie("Homme")
                   ->setCouleur("Noir")
                   ->setPrix("139.00")
                   ->setPoids("0.8")
                   ->setDimension("24cm x 27cm x 11cm")
                   ->setMatiere("Cuir de vachette pleine fleur")
                   ->setDescription("<p>Sacoche homme , cuir vachette , finition grainée , et doublure polyester , de marque RITELLE.</p>")
                   ->setImage("/imagesProduits/ritelle-cuir-vachette.jpg");



         $produitDesigual3->setReference("19SAXPEQ")
                 ->setMarque("Desigual")
                 ->setModele("Confeti Black Seattle")
                 ->setCategorie("Femme")
                 ->setCouleur("Blanc")
                 ->setPrix("71.95")
                 ->setPoids("0.7")
                 ->setDimension("27cm x 20cm x 10cm")
                 ->setMatiere("Cuir de vachette pleine fleur")
                 ->setDescription("<p>A utiliser ensemble ou séparément, ce CABAS DESIGUAL et sa pochette coordonnée vous rendront de multiples services. Du bureau à la plage, vous ne pourrez plus vous en séparer !
                 Envie de changer de décor ? Pour un look plus ville votre cabas se retourne comme un gant et arbore une couleur unie très chic !</p>")
                 ->setImage("/imagesProduits/desigual-bols-confetti-black-seattle.jpg");





       $produitLancaster3->setReference("517-24")
               ->setMarque("Lancaster")
               ->setModele("Maya")
               ->setCategorie("Femme")
               ->setCouleur("Gris / Noir")
               ->setPrix("41.30")
               ->setPoids("0.8")
               ->setDimension("20cm x 17cm x 8cm")
               ->setMatiere("Cuir de vachette pleine fleur")
               ->setDescription("<p>Trotteur façon cuir de la ligne Maya de Lancaster. On craque pour sa petite poche colorée en forme d'enveloppe.
               L'intérieur, également grainé, dispose d'une poche zippée et vous trouverez une seconde poche à fermeture Eclair au dos.</p>")
               ->setImage("/imagesProduits/lancaster-maya.jpg");

     $produitDesigual4->setReference("19SAXPFT")
             ->setMarque("Desigual")
             ->setModele("Patch Mandala Cella")
             ->setCategorie("Femme")
             ->setCouleur("Bleu")
             ->setPrix("71.95")
             ->setPoids("0.5")
             ->setDimension("38cm x 11cm x 32cm")
             ->setMatiere("Cuir de vachette")
             ->setDescription("<pShopper avec des patchs en denim usé et des broderies en mandala de luxe ton sur ton et de paillettes argentées et bleues. Avec double compartiment interne et un grand soufflet pour obtenir une capacité maximale. Avec double poignée.</p>")
             ->setImage("/imagesProduits/desigual-bols-patch-mandala-cella.jpg");

   $produitLancaster4->setReference("430-13")
           ->setMarque("Lancaster")
           ->setModele("Nao")
           ->setCategorie("Femme")
           ->setCouleur("Rouge / Noir")
           ->setPrix("139.30")
           ->setPoids("0.8")
           ->setDimension("20cm x 17cm x 8cm")
           ->setMatiere("Cuir de vachette pleine fleur")
           ->setDescription("<p>Le grand sac cabas cuir Nao de Lancaster (430-13) vous comblera avec sa ligne originale et ses dimensions idéales. Sa forme structurée offre un sac racé avec des effets de matières chics et modernes.

On retrouve à l'extérieur une poche frontale simple ainsi qu'une poche arrière zippée. L'intérieur ouvre sur une poche intérieure simple et une poche intérieure zippée.

Les anses sont réglables pour un porté main ou un porté épaule en tout confort (hauteur de porté : 22 à 29 cm).</p>")
           ->setImage("/imagesProduits/lancaster-cuir-nao.jpg");

      $produitArthurEtAston3->setReference("1672-06")
             ->setMarque("Arthur et Aston")
             ->setModele("Cuir Dune")
             ->setCategorie("Femme")
             ->setCouleur("Gris")
             ->setPrix("54.10")
             ->setPoids("1.2")
             ->setDimension("35cm x 27cm x 12cm")
             ->setMatiere("Cuir")
             ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
             ->setImage("/imagesProduits/arthur-et-aston-ligne-cuir-kalinka.jpg");

   $produitTest1->setReference("1672-06")
          ->setMarque("Arthur et Aston")
          ->setModele("Cuir Dune")
          ->setCategorie("Femme")
          ->setCouleur("Gris")
          ->setPrix("54.10")
          ->setPoids("1.2")
          ->setDimension("35cm x 27cm x 12cm")
          ->setMatiere("Cuir")
          ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
          ->setImage("/imagesProduits/desigual-bols-apolo-piadena.jpg");


     $produitTest2->setReference("1672-06")
            ->setMarque("Arthur et Aston")
            ->setModele("Apolo Piedena")
            ->setCategorie("Femme")
            ->setCouleur("Gris")
            ->setPrix("54.10")
            ->setPoids("1.2")
            ->setDimension("35cm x 27cm x 12cm")
            ->setMatiere("Cuir")
            ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
            ->setImage("/imagesProduits/desigual-bols-torine-cella.jpg");

       $produitTest3->setReference("1672-06")
             ->setMarque("Arthur et Aston")
             ->setModele("Apolo Piedena")
             ->setCategorie("Femme")
             ->setCouleur("Gris")
             ->setPrix("54.10")
             ->setPoids("1.2")
             ->setDimension("35cm x 27cm x 12cm")
             ->setMatiere("Cuir")
             ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
             ->setImage("/imagesProduits/desigual-bols-mary-jackson-capri-zipper.jpg");

        $produitTest4->setReference("1672-06")
               ->setMarque("Arthur et Aston")
               ->setModele("Apolo Piedena")
               ->setCategorie("Femme")
               ->setCouleur("Gris")
               ->setPrix("54.10")
               ->setPoids("1.2")
               ->setDimension("35cm x 27cm x 12cm")
               ->setMatiere("Cuir")
               ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
               ->setImage("/imagesProduits/desigual-bols-winter-valkyria-redmond.jpg");

          $produitTest5->setReference("1672-06")
                 ->setMarque("Arthur et Aston")
                 ->setModele("Apolo Piedena")
                 ->setCategorie("Femme")
                 ->setCouleur("Gris")
                 ->setPrix("54.10")
                 ->setPoids("1.2")
                 ->setDimension("35cm x 27cm x 12cm")
                 ->setMatiere("Cuir")
                 ->setDescription("<p>Sac à main , en cuir de vachette destroy et doublure polyester. Avec son coté dynamique et fashion , il vous accompagnera dans tous vos déplacements. Il est pourvu d'un espace de rangement avec poche plate et emplacement téléphone. Fermeture pincipale à rabat et pression. Une poche zippée externe. Fantaisie à franges en cuir. Livré avec un certificat de garantie de 2 ans.</p>")
                 ->setImage("/imagesProduits/lancaster-cuir-saffiano-signature.jpg");



        $manager->persist($produitDesigual);
        $manager->persist($produitLancaster);
        $manager->persist($produitDesigual2);
        $manager->persist($produitLancaster2);
        $manager->persist($produitArthurEtAston);
        $manager->persist($produitArthurEtAston2);
        $manager->persist($produitJlFoures);
        $manager->persist($produitRiter);
        $manager->persist($produitDesigual3);
        $manager->persist($produitLancaster3);
        $manager->persist($produitDesigual4);
        $manager->persist($produitLancaster4);
        $manager->persist($produitArthurEtAston3);
        $manager->persist($produitTest1);
        $manager->persist($produitTest2);
        $manager->persist($produitTest3);
        $manager->persist($produitTest4);
        $manager->persist($produitTest5);



        $manager->flush();
    }
}
