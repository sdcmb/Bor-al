<?php

namespace App\Controller;

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
  public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
    $user = new  User();

    $form = $this->createForm(RegistrationType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hash = $encoder->encodePassword($user, $user->getPassword());

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
   * @Route("/boreal/connexion", name="security_login")
  */
  public function login() {
    return $this->render('security/login.html.twig');
  }

  /**
   * @Route("/boreal/deconnexion", name="security_logout")
  */
  public function logout() {}

  /**
   * @Route("/boreal/modifierCompte/{UserId}", name="security_update_account")
   * @Security("is_granted('ROLE_USER')")
  */
  public function modifierCompte(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, $UserId) {

    $user = $manager->getRepository(User::class)->findOneBy(['id'=> $UserId]);

    $form = $this->createForm(RegistrationType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $hash = $encoder->encodePassword($user, $user->getPassword());
      $user->setPassword($hash);
      $manager->flush();

      echo "<script>alert(\"Modifications enregistrées  ! \")</script>";
      return $this->redirectToRoute('security_login');
    }

    return $this->render('security/modifierCompte.html.twig', [
      'form' => $form->createView()
    ]);

  }

}
