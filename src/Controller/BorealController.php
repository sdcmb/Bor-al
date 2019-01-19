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
    public function modifierSlider(Request $req) {

      if ($req->request->get('cheminSlider') != null) {
        //2e itération : choix des images

        //dump($req->request->get('cheminSlider'));
        $cheminSlider = 'gestionSlider/sliders/'.$req->request->get('cheminSlider').'.txt';
        //dump($cheminSlider);
        $fichiersAAfficher = $this->getFichierAModifier($cheminSlider);

        $_SESSION["ancienChemin"] = $cheminSlider;

        return $this->render('gestion/slider/modifier.html.twig', [
          'fichiersAAfficher' => $fichiersAAfficher,
          'nomSlider' => $req->request->get('cheminSlider')
        ]);
      }

      if ($req->request->get('nomSlider') != null) {
        //3e itération : modification du fichier

        $ancienChemin = $_SESSION["ancienChemin"];
        $nouveauChemin = 'gestionSlider/sliders/'.$req->request->get('nomSlider').'.txt';

        if ($ancienChemin != $nouveauChemin) {
          rename($ancienChemin, $nouveauChemin);

          $defaultSlider = $this->getSliderActif();
          if ($defaultSlider = $ancienChemin) {

            $fichierSlider = fopen('gestionSlider/defaultSlide.txt', 'w+');
            fputs($fichierSlider, $nouveauChemin);
            fclose($fichierSlider);
          }
        }

        $fichierSlider = fopen("$nouveauChemin", 'w+');

        if($dossier = opendir('gestionSlider/img')){
          $index = 0;
          while(false !== ($fichier = readdir($dossier))){
            if($fichier != '.' && $fichier != '..'
                    && !empty($_POST["$index"])) {

              if ($_POST["$index"] == 'on'){

                $src = 'gestionSlider/img/'.$fichier;
                fputs($fichierSlider, "$src\n");

              }
            }
            $index++;
          }
        }

        return $this->redirectToRoute('gestionSlider');
      }

      //1e itération : choix du slider
      $slidersAAfficher = $this->getChoixSlider(false);

      return $this->render('gestion/slider/modifier.html.twig', [
        'slidersAAfficher' => $slidersAAfficher
      ]);
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
    * @Route("/gestion/slider/supprimerImage", name="supprimerImage")
    * @Security("is_granted('ROLE_ADMIN')")
    */
    public function supprimerImage(Request $req) {

      if ($req->request->count() > 0) {
        $nomImageChoisie = $req->request->get('cheminImage');
        $cheminImageChoisie = 'gestionSlider/img/'.$nomImageChoisie;
        // dump($nomImageChoisi);
        // dump($cheminImage);
        unlink($cheminImageChoisie);

        //on supprime la photos de tous les sliders dans lesquels elle est
        if($dossier = opendir('gestionSlider/sliders')) {
          while (false !== ($nomSlider = readdir($dossier))) {
            if ($nomSlider != '.' && $nomSlider != '..') {
              $cheminSlider = 'gestionSlider/sliders/'.$nomSlider;
              $slider = fopen($cheminSlider, 'r+');
              $estDedans = false;
              while ((!($estDedans) && false !== ( $cheminImage = fgets($slider) ))) {
                if ($cheminImageChoisie."\n" == $cheminImage) {
                  $estDedans = true;
                }
              }
              fseek($slider, 0);
              //dump($estDedans);
              if ($estDedans) {
                $cheminTemporaire = 'gestionSlider/sliders/tempo.txt';
                $tempo = fopen($cheminTemporaire, 'w+');

                while (false !== ($cheminImage = fgets($slider))) {
                  fputs($tempo, "$cheminImage");
                }

                fclose($slider);
                // réouverture du fichier du slider en supprimant le contenu
                $slider = fopen($cheminSlider, 'w+');
                fseek($tempo, 0);

                // on remet le contenu sans l'image supprimée
                //dump($cheminImageChoisie);
                while (false !== ($cheminImage = fgets($tempo))) {
                  //dump($cheminImage);
                  if ($cheminImage != $cheminImageChoisie."\n") {
                    fputs($slider, "$cheminImage");
                  }
                }
                fclose($tempo);
                unlink($cheminTemporaire);
              }
              fclose($slider);
            }
          }
        }
        return $this->redirectToRoute('gestionSlider');
      }

      $fichiersAAfficher = $this->getFichiersSelection();

      return $this->render('gestion/slider/supprimerImage.html.twig', [
        'fichiersAAfficher' => $fichiersAAfficher
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

      //dump($_FILES);
      //dump($req->files);
      //dump($req);

      if (($req->request->count() > 0) || ($req->files->count() > 0)) {
        if ($req->files->count() > 0) {
          //dump(sys_get_temp_dir());
          if($dossierFichierTempo = opendir(sys_get_temp_dir())){
            if($dossierImage = opendir('gestionSlider/img')){

              //dump($req->request->get('fichier'));
              $fichier = $_FILES['fichier'];

              //dump($req->files->get('fichier'));
              if(strpos($fichier['type'], 'image') !== false){

                $fichierTemporaire = $fichier["tmp_name"];
                $src = realpath(dirname($fichierTemporaire)).'\\'.basename($fichierTemporaire);

                $dst = 'gestionSlider/img/'.$fichier["name"];

                $result = copy($src, $dst);

                if ($result == true){
                  $reponse = 'ok';
                } else {
                  $reponse = 'echec';
                }
              } else {
                $reponse = 'image';
              }
            } else {
              $reponse = 'dosImg';
            }
          } else {
            $reponse = 'dosTemp';
          }

          closedir($dossierImage);
          closedir($dossierFichierTempo);

        } else {
          $reponse = 'erreur';
        }
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

      $fichierVitesse = fopen('gestionSlider/defaultSpeed.txt', 'r+');
      $vitesseActuelle = fgets($fichierVitesse) / 1000;
      fclose($fichierVitesse);

      return $this->render('gestion/slider/vitesse.html.twig', [
        'vitesseActuelle' => $vitesseActuelle
      ]);
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

            $fichiersAAfficher[] = [
              'fichier' => $fichier,
              'index' => $index
            ];
          }
          $index++;
        }
      }
      return $fichiersAAfficher;
    }

    public function getFichierAModifier($cheminSlider) {
      dump($cheminSlider);

      $fichiersAModifier = array();

      // on parcours la liste des images à afficher
      // on assignera un booléen à chaque image pour
      // savoir s'il fait déjà parti du slider ou non
      if($dossier = opendir('gestionSlider/img')) {
        $slider = fopen("$cheminSlider", 'r+');
        $index = 0;
        while(false !== ($fichier = readdir($dossier))){
          if($fichier != '.' && $fichier != '..'){

            $dejaDedans = false;
            while ((!$dejaDedans) && (false !== ( $cheminImage = fgets($slider) ))) {
              $imageSlider = basename($cheminImage, "\n");
              dump($imageSlider);
              dump($fichier);
              if ($imageSlider == $fichier) {
                $dejaDedans = true;
              }
              dump($dejaDedans);
            }
            dump($dejaDedans);
            $fichiersAModifier[] = [
              'fichier' => $fichier,
              'index' => $index,
              'dejaDedans' => $dejaDedans
            ];
            fseek($slider, 0);
          }
          $index++;
        }
      }

      dump($fichiersAModifier);

      return $fichiersAModifier;
    }

}
