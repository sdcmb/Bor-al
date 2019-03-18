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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

class GestionController extends AbstractController
{

    /**
    * @Route("/gestion/produits", name="gestionProduits")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function gestionProduit(){
      // renvoit au menu concernant la gestion des produits
      return $this->render('gestion/produits.html.twig');
    }

    /**
    * @Route ("/gestion/produits/creation", name="creationProduit")
    * @Route ("/gestion/produits/{id}/edit", name="boreal_edit_produit")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function formCreationProduit(Produits $produit = null, Request $request, ObjectManager $manager){
      // permet la création d'un nouveau produit ou la modification d'un existant

      if (!$produit) {
        // si c'est une création
        $produit = new Produits();
      }

      // formulaire avec les champs concernant un produit
      $form = $this->createForm(ProduitType::class, $produit);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // contrôle sur ce qui a été saisi
        // si correct, on enregistre dans la base de données
        $manager->persist($produit);
        $manager->flush();

        return $this->redirectToRoute('accueil');
      }

      return $this->render('gestion/produits/creation_produit.html.twig', [
          'formCreationProduit' => $form->createView(),
          'editMode' => $produit->getId() !== null
      ]);
    }

    /**
    * @Route ("/gestion/clients/listeClients", name="listeClient")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function affichageClients(User $users = null, Request $request, ObjectManager $manager){
      //sélectionne la table user
      $repo = $this->getDoctrine()->getRepository(User::class);

      //récupère tous les users contenus dans la table
      $users = $repo->findAll();

      return $this->render('gestion/clients/liste_clients.html.twig', [
          'controller_name' => 'GestionController',
          'users' => $users
      ]);
    }

    public function getSliderActif() {
      // renvoit le slider qui doit être affiché sur le site
      if (file_exists('gestionSlider/defaultSlider.txt')) {
        // si le fichier existe on l'ouvre en lecture/ecriture
        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'r+');
      } else {
        // sinon on l'ouvre en écriture seulement
        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'w+');
      }

      if (filesize('gestionSlider/defaultSlider.txt') == 0) {
        // si le fichier est vide, on affichera toute les images (choix par défaut)
        fputs($fichierSlider, "gestionSlider/img");
        fseek($fichierSlider, 0);
      }

      // on lit le contenu du fichier
      $cheminSlider = fgets($fichierSlider);

      fclose($fichierSlider);

      return $cheminSlider;
    }

    public function getFichiersSliderActif() {
      //renvoit la liste des images appartenant au slider actif

      //on récupère le nom du slider actif
      $cheminSlider = $this->getSliderActif();
      $fichiers = array();

      $slider = fopen("$cheminSlider", 'r+');
      // on lit le contenu du fichier, que l'on met dans un tableau
      while(false !== ( $fichier = fgets($slider) )) {
        $fichiers[] = $fichier;
      }

      return $fichiers;

    }

    /**
    * @Route("/gestion", name="gestion")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function gestion() {
      // renvoit au menu concernant la gestion du site
      return $this->render('gestion/home.html.twig');
    }

    /**
    * @Route("/gestion/slider", name="gestionSlider")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function gestionSlider() {
      // renvoit au menu concernant la gestion du slider
      return $this->render('gestion/slider.html.twig');
    }

    /**
    * @Route("/gestion/clients", name="gestionClients")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function gestionClients() {
      // renvoit au menu concernant la gestion des clients
      return $this->render('gestion/clients.html.twig');
    }

    /**
    * @Route("/gestion/slider/creer", name="creerSlider")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function creerSlider(Request $req) {

      if ($req->request->count() > 0) {
        // si la requête n'est pas vide = 2e itéartion

        // le nom du fichier est leNomDuSlider.txt
        $cheminSlider = 'gestionSlider/sliders/'.$req->request->get('nomSlider').'.txt';
        $fichierSlider = fopen("$cheminSlider", 'w+');

        if($dossier = opendir('gestionSlider/img')){
          $index = 0;
          while(false !== ($fichier = readdir($dossier))){
            // on parcourt toutes les images disponibles
            if($fichier != '.' && $fichier != '..'
                    && !empty($req->request->get($index))) {
              // si l'image existe

              if ($req->request->get($index) == 'on'){
                // si l'image a été cochée, on l'insérer dans le fichier

                $src = 'gestionSlider/img/'.$fichier;
                fputs($fichierSlider, "$src\n");

              }
            }
            $index++;
          }
        }

        closedir($dossier);
        fclose($fichierSlider);

        // retour au menu de gestion du slider
        return $this->redirectToRoute('gestionSlider');
      }

      // 1e itération
      $fichiersAAfficher = $this->getFichiersSelection();

      return $this->render('gestion/slider/creer.html.twig', [
        'fichiersAAfficher' => $fichiersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/modifier", name="modifierSlider")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
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
          // si le nom du slider a été changé
          rename($ancienChemin, $nouveauChemin);

          $defaultSlider = $this->getSliderActif();
          if ($defaultSlider = $ancienChemin) {
            // si c'était le slider actif, on change le chemin du slider à afficher

            $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'w+');
            fputs($fichierSlider, $nouveauChemin);
            fclose($fichierSlider);
          }
        }

        // on ouvre le fichier en écriture seulement (suppression du contenu actuel)
        $fichierSlider = fopen("$nouveauChemin", 'w+');

        // comme lors de la création d'un slider, on parcourt la liste des images
        // disponibles et si elle est cochée on l'ajoute dans le fichier
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
      $slidersAAfficher = $this->getChoixSlider(/* suppression : */ false);

      return $this->render('gestion/slider/modifier.html.twig', [
        'slidersAAfficher' => $slidersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/supprimer", name="supprimerSlider")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function supprimerSlider(Request $req) {

      if ($req->request->count() > 0) {
        // 2e itération : suppression du slider choisi
        $nomSliderChoisi = $req->request->get('cheminSlider');
        $cheminSlider = 'gestionSlider/sliders/'.$nomSliderChoisi.'.txt';
        unlink($cheminSlider);

        return $this->redirectToRoute('gestionSlider');
      }

      // 1e itération : choix du slider à supprimer
      $slidersAAfficher = $this->getChoixSlider(/* suppression : */ true);

      return $this->render('gestion/slider/supprimer.html.twig', [
        'slidersAAfficher' => $slidersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/supprimerImage", name="supprimerImage")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function supprimerImage(Request $req) {

      if ($req->request->count() > 0) {
        // 2e itération : suppression

        $nomImageChoisie = $req->request->get('cheminImage');
        $cheminImageChoisie = 'gestionSlider/img/'.$nomImageChoisie;
        // dump($nomImageChoisi);
        // dump($cheminImage);
        unlink($cheminImageChoisie);

        // on supprime la photos de tous les sliders dans lesquels elle est
        // pour ne pas créer d'erreur lors de l'affichage
        if($dossier = opendir('gestionSlider/sliders')) {
          while (false !== ($nomSlider = readdir($dossier))) {
            // on parcourt tous les slider existants
            if ($nomSlider != '.' && $nomSlider != '..') {
              $cheminSlider = 'gestionSlider/sliders/'.$nomSlider;
              $slider = fopen($cheminSlider, 'r+');
              $estDedans = false;
              while ((!($estDedans) && false !== ( $cheminImage = fgets($slider) ))) {
                // on parcourt le contenu du slider
                if ($cheminImageChoisie."\n" == $cheminImage) {
                  $estDedans = true;
                }
              }
              fseek($slider, 0);
              //dump($estDedans);
              if ($estDedans) {
                // on la retire du slider si l'image en fait parti
                $cheminTemporaire = 'gestionSlider/sliders/tempo.txt';
                $tempo = fopen($cheminTemporaire, 'w+');

                while (false !== ($cheminImage = fgets($slider))) {
                  // on recopie le contenu du slider dans un fichier txt temporaire
                  fputs($tempo, "$cheminImage");
                }

                fclose($slider);
                // réouverture du fichier du slider en écriture seulement (supprimant le contenu)
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
        // retour au menu de gestion du slider
        return $this->redirectToRoute('gestionSlider');
      }

      //1e itération : choix de l'image à supprimer
      $fichiersAAfficher = $this->getFichiersSelection();

      return $this->render('gestion/slider/supprimerImage.html.twig', [
        'fichiersAAfficher' => $fichiersAAfficher
      ]);
    }

    /**
    * @Route("/gestion/slider/choisir", name="choisirSlider")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function choisirSlider(Request $req) {
      // choix du slider à afficher sur le site

      if ($req->request->count() > 0) {
        // 2e itération
        $nomSliderChoisi = $req->request->get('cheminSlider');
        $cheminSlider = 'gestionSlider/sliders/'.$nomSliderChoisi.'.txt';

        $fichierSlider = fopen('gestionSlider/defaultSlider.txt', 'w+');
        fputs($fichierSlider, $cheminSlider);
        fclose($fichierSlider);

        // retour au menu de gestion du slider
        return $this->redirectToRoute('gestionSlider');
      }

      // 1e itération : choix du slider
      $slidersAAfficher = $this->getChoixSlider(/* suppression : */ false);
      $defaultSlider = basename($this->getSliderActif(), '.txt');

      return $this->render('gestion/slider/choisir.html.twig', [
        'slidersAAfficher' => $slidersAAfficher,
        'defaultSlider' => $defaultSlider
      ]);
    }

    /**
    * @Route("/gestion/slider/ajouterImages", name="ajouterImages")
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function ajouterImagesSlider(Request $req) {

      // si c'est la 1e itération, la variable réponse vaudra :
      $reponse = '';

      //dump($_FILES);
      //dump($req->files);
      //dump($req);

      if (($req->request->count() > 0) || ($req->files->count() > 0)) {
        // qqc a été transmis
        if ($req->files->count() > 0) {
          // il s'agit bien d'un fichier

          //dump(sys_get_temp_dir());
          if($dossierFichierTempo = opendir(sys_get_temp_dir())){
            if($dossierImage = opendir('gestionSlider/img')){

              //dump($req->request->get('fichier'));
              $fichier = $_FILES['fichier'];

              //dump($req->files->get('fichier'));
              if(strpos($fichier['type'], 'image') !== false){
                // le fichier transmis est une image

                // l'image est temporairement enregistrée dans le dossier
                // temporaire du système, on va la récupérer avec son nom temporaire
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
    * @Security("is_granted('ROLE_ADMIN')") //accessible uniquement par un utilisateur connecté ayant pour rôle admin
    */
    public function changerVitesseSlider(Request $req) {

      if ($req->request->count() > 0) {
        // 2e itération
        $vitesseSlider = $req->request->get('vitesse') * 1000; // passage en ms

        $fichierVitesse = fopen('gestionSlider/defaultSpeed.txt', 'w+');
        fputs($fichierVitesse, $vitesseSlider);
        fclose($fichierVitesse);

        // retour au menu de gestion du slider
        return $this->redirectToRoute('gestionSlider');
      }

      // 1e itération

      // on lit dans le fichier la vitesse actuelle (en ms)
      $fichierVitesse = fopen('gestionSlider/defaultSpeed.txt', 'r+');
      $vitesseActuelle = fgets($fichierVitesse) / 1000; // passage en seconde
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
      //dump($cheminSlider);

      $fichiersAModifier = array();

      // on parcours la liste des images à afficher
      // on assignera un booléen à chaque image pour
      // savoir s'il fait déjà parti du slider ou non
      //
      // solution pas optimisée du tout !!
      if($dossier = opendir('gestionSlider/img')) {
        $slider = fopen("$cheminSlider", 'r+');
        $index = 0;
        while(false !== ($fichier = readdir($dossier))){
          if($fichier != '.' && $fichier != '..'){

            $dejaDedans = false;
            while ((!$dejaDedans) && (false !== ( $cheminImage = fgets($slider) ))) {
              $imageSlider = basename($cheminImage, "\n");
              // dump($imageSlider);
              // dump($fichier);
              if ($imageSlider == $fichier."\r") {
                $dejaDedans = true;
              }
              // dump($dejaDedans);
            }
            // dump($dejaDedans);
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

      // dump($fichiersAModifier);

      return $fichiersAModifier;
    }
}
