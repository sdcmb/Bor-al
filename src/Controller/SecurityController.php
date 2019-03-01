<?php

namespace App\Controller;

//imports
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Panier;
use App\Form\UpdateAccountType;
use App\ Form\RegistrationType;
use App\ Form\UpdateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
  /**
   * @Route("/boreal/inscription", name="security_registration")
  */
  public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) { //renvoie à l'inscription d'un utilisateur
    $user = new  User();

    $form = $this->createForm(RegistrationType::class, $user); //creation d'un formulaire à partir de la classe Form/RegistrationType contenant les champs et leurs types

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) { //contrôle ce qui a été saisi, si c'est bon on enregistre l'utilisateur

      $hash = $encoder->encodePassword($user, $user->getPassword()); //encode le mot de passe avec le cryptage choisis dans le config/packages/security.yaml
      $user->setPassword($hash);

      $manager->persist($user);
      $manager->flush();

      return $this->redirectToRoute('security_login');
    }
    return $this->render('security/registration.html.twig', [
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/boreal/connexion", name="security_login") //l'appel de cette route renverra au config/packages/security.yaml et symfony gèrera la connexion tout seul
  */
  public function login() { //renvoie à la connexion
    return $this->render('security/login.html.twig');
  }

  /**
   * @Route("/boreal/deconnexion", name="security_logout") //l'appel de cette route renverra au config/packages/security.yaml et symfony gèrera la déconnexion tout seul
  */
  public function logout() {} //renvoie à la déconnexion

  /**
   * @Route("/boreal/modifierCompte/{UserId}", name="security_update_account")
   * @Security("is_granted('ROLE_USER')") //accessible si la personne est connecté
  */
  public function modifierCompte(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, $UserId) { //revnoie à la modification d'un compte

    $user = $manager->getRepository(User::class)->findOneBy(['id'=> $UserId]); //récupère un utilisateur en partculier de la table user

    $form = $this->createForm(RegistrationType::class, $user); //créer un formulaire d'inscription à partir de la classe Form/RegistrationType
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) { //contrôle ce qui a été saisi, si c'est bon on enregistre l'utilisateur

      $hash = $encoder->encodePassword($user, $user->getPassword()); //encode le mot de passe avec le cryptage choisis dans le config/packages/security.yaml
      $user->setPassword($hash);
      $manager->flush();

      return $this->redirectToRoute('security_login'); //redirige vers la page de connexion
    }

    return $this->render('security/modifierCompte.html.twig', [
      'form' => $form->createView()
    ]);

  }

}
