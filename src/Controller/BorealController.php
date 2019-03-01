<?php

namespace App\Controller;

//imports
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Entity\User;
use App\Entity\Panier;
use App\Form\UserType;
use App\Form\ProduitType;
use App\Controller\GestionController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

class BorealController extends AbstractController
{
    /**
     * @Route("/boreal/femmes", name="boreal/femmes")
     */
    public function produitsFemme() //renvoie tous les produits
    {
        //sélectionne la table produits
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        //récupère tous les produits contenus dans la table
        $produits = $repo->findAll();

        return $this->render('boreal/produitsFemme.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/hommes", name="boreal/hommes")
     */
    public function produitsHomme() //renvoie tous les produits
    {
        //sélectionne la table produits
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        //récupère tous les produits contenus dans la table
        $produits = $repo->findAll();

        return $this->render('boreal/produitsHomme.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/accessoires", name="boreal/accessoires")
     */
    public function accessoires() //renvoie tous les produits
    {
        //sélectionne la table produits
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        //récupère tous les produits contenus dans la table
        $produits = $repo->findAll();

        return $this->render('boreal/accessoires.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/boreal/bagages", name="boreal/bagages")
     */
    public function bagages() //renvoie tous les produits
    {
        //sélectionne la table produits
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        //récupère tous les produits contenus dans la table
        $produits = $repo->findAll();

        return $this->render('boreal/bagages.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
    * @Route("/", name="accueil")
    */
    public function home() //renvoie à la page d'accueil
    {

      $gestionController = new GestionController();

      //récupère le slider actif
      $fichiers = $gestionController->getFichiersSliderActif();

      return $this->render('boreal/home.html.twig', [
        'fichiers' => $fichiers
      ]);
    }

    /**
    * @Route ("/boreal/femmes/produit?id={id}", name="produit_femmes")
    */
    public function show($id) //renvoie à l'affichage d'un produit en particulier
    {
      //sélectionne la table produits
      $repo = $this->getDoctrine()->getRepository(Produits::class);

      //récupère le produit ayant pour id $id
      $produit = $repo->find($id);

      return $this->render('boreal/show.html.twig', [
          'controller_name' => 'BorealController',
          'produit' => $produit
      ]);
    }

    /**
    * @Route("/boreal/femmes/produit/{ProduitId}?{UserId}", name="ajouterPanier")
    */
    public function ajouterPanier($ProduitId, $UserId) { //permet d'ajouter un produit au panier

      $em = $this->getDoctrine()->getManager();
      $panier = $em->getRepository(Panier::class)->findOneBy(['UserId' => $UserId, 'ProduitId' => $ProduitId]); //récupère le panier d'un utilisateur contenant un produit en particulier

      if (!$panier) { //si le panier de l'utilisateur ne contient pas ce produit on créer une nouvelle ligne dans la bd
        $panier = new Panier();

        $panier->setUserId($UserId)
               ->setProduitId($ProduitId)
               ->setQuantite(1);

        $em->persist($panier);
        $em->flush();
      }
      else { //sinon on augmente juste la quantité du produit
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
    public function afficherPanier($UserId) { //renvoie à l'affichage du panier d'un utilisateur

      $produits = array();

      $repo1 = $this->getDoctrine()->getRepository(Panier::class); //on séléctionne la table panier
      $repo2 = $this->getDoctrine()->getRepository(Produits::class); //on séléctionne la table produit

      $paniers = $repo1->findBy(['UserId'=>$UserId]); //on récupère le panier d'un utilisateur
      foreach ($paniers as $panier) { //pour chaque produit trouver dans le panier on le récupère de la table produit et on les mets dans un tableau
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
    public function supprimerPanier($UserId, $ProduitId) { //permet de retirer un produit du panier

      $em = $this->getDoctrine()->getManager();
      $panier = $em->getRepository(Panier::class)->findOneBy(['UserId' => $UserId, 'ProduitId' => $ProduitId]); //récupère le produit dans le panier

      $panier->setQuantite($panier->getQuantite() - 1); //retire un de la quantité du produit du panier
      if ($panier->getQuantite() <= 0) { //si le produit à une quantité de 0 on le supprime totalement du panier
        $em->remove($panier);
      }

      $em->flush();

      return $this->redirectToRoute('afficherPanier', ['UserId' => $UserId]);
    }

}
