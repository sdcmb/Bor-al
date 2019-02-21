<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Entity\User;
use App\Entity\Panier;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require 'paiement/start.php';

class PaiementController extends AbstractController
{
    
    /**
      * @Route("/boreal/panier/{UserId}", name="payer")
      */
      public function payer($UserId)
      {
        $produits = array();
        $prix = 0.00;

        $repo1 = $this->getDoctrine()->getRepository(Panier::class);
        $repo2 = $this->getDoctrine()->getRepository(Produits::class);

        $paniers = $repo1->findBy(['UserId'=>$UserId]);
        foreach ($paniers as $panier) {
          $produit = $repo2->find($panier->getProduitId());
          $prix += $produit.prix;
          $produits[] = ['produit' => $produit, 'quantite' => $panier->getQuantite()];
        }

        $fraisDePort = 2.00;
        $prixTTC = $prix + $fraisDePort;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($product)
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setShipping($shipping)
                ->setSubtotal($price);

        $amount = new Amount();
        $amount->setCurrency('EUR')
                ->setTotal($total)
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction ->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription('PayForSomething Payment')
                    ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(SITE_URL, '/pay/true')
                    ->setCancelUrl(SITE_URL, '/pay/false');

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);


        try{
          $payment->create($paypal);
        }catch (Exception $e){
          die($e);
        }

        $approvalUrl = $payment->getApprovalLink();

        return $this->render($approvalUrl);
      }

      /**
      * @Route("/pay/true", name="payTrue")
      */
      public function payTrue()
      {
        $paymentId = $_GET['paymentId'];
        $payerID = $_GET['PayerID'];

        $payment=Payment::get($paymentId, $paypal);

        $execute = new PaymentExecution();
        $execute->setPayerId($payerID);

        try{
          $result = $payment->execute($execute, $paypal);
        }catch (Exception $e) {
          $data = json_decode($e->getData());
          var_dump(data);
          die();
        }

        return $this->redirectToRoute('accueil', [
          'etatPaiement' => true
        ]);
      }

      /**
      * @Route("/pay/false", name="payFalse")
      */
      public function payFalse()
      {
        return $this->redirectToRoute('accueil', [
          'etatPaiement' => false
        ]);
      }
}
