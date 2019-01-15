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
      return $this->render('boreal/home.html.twig');
    }


    /**
    * @Route ("/boreal/femmes/produit{id}", name="produit_femmes")
    **/
    public function show($id){
      $repo=$this->getDoctrine()->getRepository(Produit::class);

      $produit = $repo->find($id);

      return $this->render('boreal/show.html.twig', [
          'controller_name' => 'BorealController',
          'produit' => $produit
      ]);
    }

    /**
    * @Route("/boreal/gestion-produits", name="gestionProduit")
    **/
    public function gestionProduit(){
      return $this->render('boreal/produits.html.twig');
    }

    /**
    * @Route ("/boreal/creation-produit", name="creationProduit")
    * @Route ("/boreal/gestion-produits/{id}/edit", name="boreal_edit_produit")
    **/
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

      return $this->render('boreal/creation_produit.html.twig', [
          'formCreationProduit' => $form->createView(),
          'editMode' => $produit->getId() !== null
      ]);
    }

}
