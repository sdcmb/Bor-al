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
                        ->setImage("http://www.boreal-maroquinerie.com/2039-9158-thickbox/desigual-bols-abby-siberia.jpg");

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
                ->setImage("http://www.boreal-maroquinerie.com/1179-4981-thickbox/arthur-et-aston-ligne-victoria.jpg");

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
                   ->setImage("http://www.boreal-maroquinerie.com/1734-7685-thickbox/arthur-et-aston-cuir-huile.jpg");


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
                ->setImage("http://www.boreal-maroquinerie.com/2022-9057-thickbox/jl-foures-cuir-baroudeur.jpg");



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
                   ->setImage("http://www.boreal-maroquinerie.com/1858-8285-thickbox/ritelle-cuir-vachette.jpg");



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
                 ->setImage("http://www.boreal-maroquinerie.com/2034-9124-thickbox/desigual-bols-confetti-black-seattle.jpg");



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
               ->setImage("http://www.boreal-maroquinerie.com/1968-8766-thickbox/lancaster-maya.jpg");


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


        $manager->flush();
    }
}
