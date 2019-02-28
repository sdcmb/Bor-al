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
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use vendor\autoload;

class PaiementController extends AbstractController
{
    
    /**
      * @Route("/boreal/commander/{UserId}", name="payer")
      */
      public function payer($UserId)
      {
        $produits = array();

        $repo1 = $this->getDoctrine()->getRepository(Panier::class);
        $repo2 = $this->getDoctrine()->getRepository(Produits::class);

        $subTotal = 0;

        $paniers = $repo1->findBy(['UserId'=>$UserId]);
        foreach ($paniers as $panier) {
          $produit = $repo2->find($panier->getProduitId());
          $produits[] = [
            'reference' => $produit->getReference(),
            'prix' => $produit->getPrix(),
            'quantite' => $panier->getQuantite()
          ];
          $subTotal += $produit->getPrix() * $panier->getQuantite();
        }

        $fraisDePort = 2.00;
        $prixTotal = $subTotal + $fraisDePort;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        
        $liste = array();
        foreach ($produits as $produit) {
          $item = new Item();
          $item->setName($produit['reference'])
               ->setCurrency('EUR')
               ->setQuantity($produit['quantite'])
               ->setPrice($produit['prix']);
          $liste[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($liste);

        $details = new Details();
        $details->setShipping($fraisDePort)
                ->setSubtotal($subTotal);

        $amount = new Amount();
        $amount->setCurrency('EUR')
               ->setTotal($prixTotal)
               ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription('PayForSomething Payment')
                    ->setInvoiceNumber(uniqid());

        define ('SITE_URL','http://127.0.0.1:8000');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(SITE_URL.'/pay/'.$UserId.'?success=true')
                     ->setCancelUrl(SITE_URL.'/pay/'.$UserId.'?success=false');

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        $paypal = new \PayPal\Rest\ApiContext(
                  new \PayPal\Auth\OAuthTokenCredential(
                    'AQ84_WvSBCFRH9nyPZk2bDFXJSsT5JLWr0bl_AiW9sjQ0PInqZA4e2vCodXelZNRvhsZjMHYKzwqpj1V',
                    'EGhTF-hzi3chTI-naFF-H3X_LTwm-zt_yy9FICotLMgQ0sokHLcAF5f-dGjAIMGcMN1FWDL-W_1AmGj_'
                    )
                  );

        try{
          $payment->create($paypal);
        }catch (Exception $e){
          return $this->redirectToRoute('accueil', [
            'etatPaiement' => false
          ]);
        }

        $approvalUrl = $payment->getApprovalLink();

        return $this->redirect($approvalUrl);
      }

      /**
      * @Route("/pay/{UserId}", name="pay")
      */
      public function pay($UserId)
      {
        $success = $_GET['success'];
        if ($success == true) {

          $paymentId = $_GET['paymentId'];
          $payerID = $_GET['PayerID'];

          $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
              'AQ84_WvSBCFRH9nyPZk2bDFXJSsT5JLWr0bl_AiW9sjQ0PInqZA4e2vCodXelZNRvhsZjMHYKzwqpj1V',
              'EGhTF-hzi3chTI-naFF-H3X_LTwm-zt_yy9FICotLMgQ0sokHLcAF5f-dGjAIMGcMN1FWDL-W_1AmGj_'
              )
            );

          $payment=Payment::get($paymentId, $paypal);

          $execute = new PaymentExecution();
          $execute->setPayerId($payerID);

          try{
            $result = $payment->execute($execute, $paypal);
          }catch (Exception $e) {
            $data = json_decode($e->getData());
            var_dump(data);
            return $this->redirectToRoute('accueil', [
              'etatPaiement' => false
            ]);
          }

          // on retire du panier les produits achetés 
          $em = $this->getDoctrine()->getManager();
          $panier = $em->getRepository(Panier::class)->findBy(['UserId'=>$UserId]);
          foreach ($panier as $produit) {
            $em->remove($produit);
          }
          $em->flush();

          return $this->redirectToRoute('accueil', [
            'etatPaiement' => true
          ]);
        } else {
          return $this->redirectToRoute('accueil', [
            'etatPaiement' => false
          ]);
        }
      }
}
