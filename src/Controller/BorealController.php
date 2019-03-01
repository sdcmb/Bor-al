<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Entity\User;
use App\Entity\Panier;
use App\Form\UserType;
use App\Form\ProduitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\GestionController;

class BorealController extends AbstractController
{
    /**
     * @Route("/boreal/femmes", name="boreal/femmes")
     */
    public function produitsFemme()
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        $produits = $repo->findAll();

        return $this->render('boreal/produitsFemme.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/hommes", name="boreal/hommes")
     */
    public function produitsHomme()
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        $produits = $repo->findAll();

        return $this->render('boreal/produitsHomme.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/accessoires", name="boreal/accessoires")
     */
    public function accessoires()
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        $produits = $repo->findAll();

        return $this->render('boreal/accessoires.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/bagages", name="boreal/bagages")
     */
    public function bagages()
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        $produits = $repo->findAll();

        return $this->render('boreal/bagages.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
    * @Route("/", name="accueil")
    */
    public function home(){

      $gestionController = new GestionController();

      $fichiers = $gestionController->getFichiersSliderActif();

      return $this->render('boreal/home.html.twig', [
        'fichiers' => $fichiers
      ]);
    }

    /**
    * @Route ("/boreal/femmes/produit?id={id}", name="produit_femmes")
    */
    public function show($id){
      $repo = $this->getDoctrine()->getRepository(Produits::class);

      $produit = $repo->find($id);

      return $this->render('boreal/show.html.twig', [
          'controller_name' => 'BorealController',
          'produit' => $produit
      ]);
    }

    /**
    * @Route("/boreal/femmes/produit/{ProduitId}?{UserId}", name="ajouterPanier")
    */
    public function ajouterPanier($ProduitId, $UserId) {

      $em = $this->getDoctrine()->getManager();
      $panier = $em->getRepository(Panier::class)->findOneBy(['UserId' => $UserId, 'ProduitId' => $ProduitId]);

      if (!$panier) {
        $panier = new Panier();

        $panier->setUserId($UserId)
               ->setProduitId($ProduitId)
               ->setQuantite(1);

        $em->persist($panier);
        $em->flush();
      }
      else {
        $panier->setQuantite($panier->getQuantite() + 1);
        $em->flush();
      }

      return $this->redirectToRoute('produit_femmes', [
        'id' => $ProduitId,
      ]);
    }

    /**
    * @Route("/boreal/panier/{UserId}", name="afficherPanier")
    */
    public function afficherPanier($UserId) {

      $produits = array();

      $repo1 = $this->getDoctrine()->getRepository(Panier::class);
      $repo2 = $this->getDoctrine()->getRepository(Produits::class);

      $paniers = $repo1->findBy(['UserId'=>$UserId]);
      foreach ($paniers as $panier) {
        $produit = $repo2->find($panier->getProduitId());
        $produits[] = ['produit' => $produit, 'quantite' => $panier->getQuantite()];
      }

      return $this->render('boreal/panier.html.twig', [
        'controller_name' => 'BorealController',
        'produits' => $produits,
      ]);
    }

    /**
    * @Route("/boreal/panier/{UserId}/{ProduitId}", name="supprimerPanier")
    */
    public function supprimerPanier($UserId, $ProduitId) {

      $em = $this->getDoctrine()->getManager();
      $panier = $em->getRepository(Panier::class)->findOneBy(['UserId' => $UserId, 'ProduitId' => $ProduitId]);

      $panier->setQuantite($panier->getQuantite() - 1);
      if ($panier->getQuantite() <= 0) {
        $em->remove($panier);
      }

      $em->flush();

      return $this->redirectToRoute('afficherPanier', ['UserId' => $UserId]);
    }

    //Ajouter date d'ajout au panier (postedAt de type DateTime)
    //Créer une procédure dans la base de données vérifiant la date d'ajout et supprimant du panier si la date est supérieur à 2 jours

    //Changer affichage des produits avec une seule fonction pour afficher la liste des produits et une autre pour afficher le détail
    //En rajoutant le nom de la catégorie dans la bd et en le passant en parametre de la route

}
