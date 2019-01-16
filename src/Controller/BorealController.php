<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ProductType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class BorealController extends AbstractController
{
    /**
     * @Route("/boreal/femmes", name="boreal/femmes")
     */
    public function index()
    {
        $repo=$this->getDoctrine()->getRepository(Produit::class);

        $produits = $repo->findAll();

        return $this->render('boreal/index.html.twig', [
            'controller_name' => 'BorealController',
            'produits' => $produits
        ]);
    }

    /**
    * @Route("/", name="accueil")
    */
    public function home(){

      $fichiers = $this->getFichiersSliderActif();

      return $this->render('boreal/home.html.twig', [
        'fichiers' => $fichiers
      ]);
    }


    /**
    * @Route ("/boreal/femmes/produit{id}", name="produit_femmes")
    */
    public function show($id){
      $repo=$this->getDoctrine()->getRepository(Produit::class);

      $produit = $repo->find($id);

      return $this->render('boreal/show.html.twig', [
          'controller_name' => 'BorealController',
          'produit' => $produit
      ]);
    }

    /**
    * @Route("/gestion/produits", name="gestionProduits")
    */
    public function gestionProduit(){
      return $this->render('gestion/produits.html.twig');
    }

    /**
    * @Route ("/gestion/produits/creation", name="creationProduit")
    * @Route ("/gestion/produits/{id}/edit", name="boreal_edit_produit")
    */
    public function formCreationProduit(Produit $produit = null, Request $request, ObjectManager $manager){

      if (!$produit) {
        $produit = new Produit();
      }

      $form = $this->createForm(ProductType::class, $produit);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($produit);
        $manager->flush();

        return $this->redirectToRoute('accueil');
      }

      return $this->render('gestion/produits/creation_produit.html.twig', [
          'formCreationProduit' => $form->createView(),
          'editMode' => $produit->getId() !== null
      ]);
    }

    public function getSliderActif() {
      if (file_exists('gestionSlider/defaultSlider.txt')) {
        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'r+');
      } else {
        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'w+');
      }

      if (filesize('gestionSlider/defaultSlider.txt') == 0) {
        fputs($fichierSlider, "gestionSlider/img");
        fseek($fichierSlider, 0);
      }

      $cheminSlider = fgets($fichierSlider);

      fclose($fichierSlider);

      return $cheminSlider;
    }

    public function getFichiersSliderActif() {
      $cheminSlider = $this->getSliderActif();
      $fichiers = array();

      $slider = fopen("$cheminSlider", 'r+');

      while(false !== ( $fichier = fgets($slider) )) {
        $fichiers[] = $fichier;
      }

      return $fichiers;

    }

    /**
    *   @Route("/gestion", name="gestion")
    */
    public function gestion() {
      return $this->render('gestion/home.html.twig');
    }

    /**
    *   @Route("/gestion/slider", name="gestionSlider")
    */
    public function gestionSlider() {
      return $this->render('gestion/slider.html.twig');
    }

    /**
    *   @Route("/gestion/clients", name="gestionClients")
    */
    public function gestionClients() {
      return $this->render('gestion/clients.html.twig');
    }

    /**
    *   @Route("/gestion/slider/creer", name="creerSlider")
    */
    public function creerSlider() {
      return $this->render('gestion/slider/creer.html.twig');
    }

    /**
    *   @Route("/gestion/slider/modifier", name="modifierSlider")
    */
    public function modifierSlider() {
      return $this->render('gestion/slider/modifier.html.twig');
    }

    /**
    *   @Route("/gestion/slider/supprimer", name="supprimerSlider")
    */
    public function supprimerSlider() {
      return $this->render('gestion/slider/supprimer.html.twig');
    }

    /**
    *   @Route("/gestion/slider/choisir", name="choisirSlider")
    */
    public function choisirSlider() {
      return $this->render('gestion/slider/choisir.html.twig');
    }

    /**
    *   @Route("/gestion/slider/ajouterImages", name="ajouterImages")
    */
    public function ajouterImagesSlider() {
      return $this->render('gestion/slider/ajouterImages.html.twig');
    }

    /**
    *   @Route("/gestion/slider/vitesse", name="changerVitesse")
    */
    public function changerVitesseSlider() {
      return $this->render('gestion/slider/vitesse.html.twig');
    }

}
