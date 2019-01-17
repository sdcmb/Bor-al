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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

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
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function gestionProduit(){
      return $this->render('gestion/produits.html.twig');
    }

    /**
    * @Route ("/gestion/produits/creation", name="creationProduit")
    * @Route ("/gestion/produits/{id}/edit", name="boreal_edit_produit")
    * @Security("is_granted('ROLE_ADMIN')")
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
    * @Route("/gestion", name="gestion")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function gestion() {
      return $this->render('gestion/home.html.twig');
    }

    /**
    * @Route("/gestion/slider", name="gestionSlider")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function gestionSlider() {
      return $this->render('gestion/slider.html.twig');
    }

    /**
    * @Route("/gestion/clients", name="gestionClients")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function gestionClients() {
      return $this->render('gestion/clients.html.twig');
    }

    /**
    * @Route("/gestion/slider/creer", name="creerSlider")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function creerSlider(Request $req) {

      if ($req->request->count() > 0) {
        $cheminSlider = 'gestionSlider/sliders/'.$req->request->get('nomSlider').'.txt';
        $fichierSlider = fopen("$cheminSlider", 'w+');

        if($dossier = opendir('gestionSlider/img')){
          $index = 0;
          while(false !== ($fichier = readdir($dossier))){
            if($fichier != '.' && $fichier != '..'
                    && !empty($req->request->get($index))) {

              if ($req->request->get($index) == 'on'){

                $src = 'gestionSlider/img/'.$fichier;
                fputs($fichierSlider, "$src\n");

              }
            }
            $index++;
          }
        }

        closedir($dossier);
        fclose($fichierSlider);

        return $this->redirectToRoute('gestionSlider');
      }

      $fichiersAAfficher = $this->getFichiersSelection();

      return $this->render('gestion/slider/creer.html.twig', [
        'fichiersAAfficher' => $fichiersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/modifier", name="modifierSlider")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function modifierSlider() {
      return $this->render('gestion/slider/modifier.html.twig');
    }

    /**
    * @Route("/gestion/slider/supprimer", name="supprimerSlider")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function supprimerSlider(Request $req) {

      if ($req->request->count() > 0) {
        $nomSliderChoisi = $req->request->get('cheminSlider');
        $cheminSlider = 'gestionSlider/sliders/'.$nomSliderChoisi.'.txt';
        unlink($cheminSlider);

        return $this->redirectToRoute('gestionSlider');
      }

      $slidersAAfficher = $this->getChoixSlider(true);

      return $this->render('gestion/slider/supprimer.html.twig', [
        'slidersAAfficher' => $slidersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/choisir", name="choisirSlider")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function choisirSlider(Request $req) {

      if ($req->request->count() > 0) {
        $nomSliderChoisi = $req->request->get('cheminSlider');
        $cheminSlider = 'gestionSlider/sliders/'.$nomSliderChoisi.'.txt';

        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'w+');
        fputs($fichierSlider, $cheminSlider);
        fclose($fichierSlider);

        return $this->redirectToRoute('gestionSlider');
      }

      $slidersAAfficher = $this->getChoixSlider(false);
      $defaultSlider = basename($this->getSliderActif(), '.txt');

      return $this->render('gestion/slider/choisir.html.twig', [
        'slidersAAfficher' => $slidersAAfficher,
        'defaultSlider' => $defaultSlider
      ]);
    }

    /**
    * @Route("/gestion/slider/ajouterImages", name="ajouterImages")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function ajouterImagesSlider(Request $req) {

      $reponse = '';

      if ($req->request->count() > 0) {

        //dump(sys_get_temp_dir());
        if($dossierFichierTempo = opendir(sys_get_temp_dir())){
          if($dossierImage = opendir('gestionSlider/img')){

            //dump($req->request->get('fichier'));
            $fichier = $req->request->get('fichier');

            //dump($req->files->get('fichier'));
            //dump(mime_content_type($fichier));
            //if(strpos(mime_content_type($fichier), 'image') !== false){

              //$fichierTemporaire = $fichier["tmp_name"];
              //$src = realpath(dirname($fichierTemporaire)).'\\'.basename($fichierTemporaire);

              //$dst = 'gestionSlider/img/'.$fichier["name"];

              $result = false;//copy($src, $dst);

              if ($result == true){
                $reponse = 'ok';
              } else {
                $reponse = 'echec';
              }
            //} else {
              //$reponse = 'image';
            //}
          } else {
            $reponse = 'dosImg';
          }
        } else {
          $reponse = 'dosTemp';
        }

        closedir($dossierImage);
        closedir($dossierFichierTempo);

      }

      return $this->render('gestion/slider/ajouterImages.html.twig', [
        'reponse' => $reponse
      ]);
    }

    /**
    * @Route("/gestion/slider/vitesse", name="changerVitesse")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function changerVitesseSlider(Request $req) {

      if ($req->request->count() > 0) {
        $vitesseSlider = $req->request->get('vitesse') * 1000;

        $fichierVitesse = fopen('gestionSlider/defaultSpeed.txt', 'w+');
        fputs($fichierVitesse, $vitesseSlider);
        fclose($fichierVitesse);

        return $this->redirectToRoute('gestionSlider');
      }

      return $this->render('gestion/slider/vitesse.html.twig');
    }

    public function getChoixSlider($supp) {
      //s'il s'agit d'une suppression (supp == true),
      //on n'affiche pas le slider actif, sinon on l'affiche

      $slidersAAfficher = array();

      $cheminSlider = $this->getSliderActif();
      $defaultSlider = basename($cheminSlider, '.txt');

      if($dossier = opendir('gestionSlider/sliders')){
        while(false !== ($fichier = readdir($dossier))){
          if($fichier != '.' && $fichier != '..'){

            $nomFichier = basename($fichier, '.txt');
            //dump($nomFichier);

            if (!$supp || $nomFichier != $defaultSlider) {
              // soit ce n'est pas la page supprimer, soit ce n'est pas le defaultSlider
              $slidersAAfficher[] = $nomFichier;
              //dump($slidersAAfficher);
            }
          }
        }
      }

      return $slidersAAfficher;
    }

    public function getFichiersSelection() {

      $fichiersAAfficher = array();

      if($dossier = opendir('gestionSlider/img')){
        $index = 0;
        while(false !== ($fichier = readdir($dossier))){
          if($fichier != '.' && $fichier != '..'){

            $fichiersAAfficher[] = [$fichier, $index];

          }
          $index++;
        }
      }
      return $fichiersAAfficher;
    }

}
