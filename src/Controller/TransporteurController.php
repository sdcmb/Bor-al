<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Emc\Quotation;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class TransporteurController extends AbstractController
{
    /**
     * @Route("/transporteur/infoCotation", name="infoCotation")
     */
    public function infoCotation()
    {
        return $this->render('transporteur/infoCotation.html.twig', [
            'controller_name' => 'TransporteurController',
        ]);
    }

    /**
     * @Route("/transporteur/cotation", name="cotation")*
     */
    public function cotation(Request $request)
    {

        if($request->request->count()>0) {
            $cotation = new Session();
            
            $cotation->set('country',$request->request->get('country'));//création de variable de session pour conserver les informations saisie dans le formulaire info livraison
            $cotation->set('zipcode',$request->request->get('zipcode'));
            $cotation->set('city',$request->request->get('city'));
            $cotation->set('adress',$request->request->get('adress'));
            $cotation->set('collection_date',$request->request->get('collection_date'));
            $cotation->set('colis_valeur',$request->request->get('colis_valeur'));
            $cotation->set('colis_poids',$request->request->get('colis_poids'));
    
        }
      require_once(EMC_PARENT_DIR.'config/autoload.php');
      
      
      $from = array(
        'country' => $cotation->get('country'), // must be an ISO code, set get_country example on how to get codes
        // "state" => "", if required, state must be an ISO code as well
        'zipcode' => $cotation->get('zipcode'), //zipcode prend comme valeur, la valeur de la variable de session zipcode entré précédemment dans le formulaire info livraison
        'city' => $cotation->get('city'),//même chose que pour le champs précédent
        'address' => $cotation->get('adress'),//même chose que pour le champs précédent
        'type' => 'company' // accepted values are "company" or "individual"
    );
    
    $dest =  isset($_GET['dest']) ? $_GET['dest'] : null;
    switch ($dest) {
        case 'Sydney':
            $to = array(
                "country" => "AU", // must be an ISO code, set get_country example on how to get codes
                // "state" => "", if required, state must be an ISO code as well
                "zipcode" => "2000",
                "city" => "Sydney",
                "address" => "King Street",
                "type" => "individual" // accepted values are "company" or "individual"
             );
            break;
        default:
            $to = array(
                'country' => 'FR', // must be an ISO code, set get_country example on how to get codes
                // "state" => "", if required, state must be an ISO code as well
                'zipcode' => '33000',
                'city' => 'Bordeaux',
                'address' => '24, rue des Ayres',
                'type' => 'individual' // accepted values are "company" or "individual"
            );
            break;
    }
    
    
    /*
     * $additionalParams contains all additional parameters for your request, it includes filters or offer's options
     * A list of all possible parameters is available here: http://ecommerce.envoimoinscher.com/api/documentation/commandes/
     */
    $additionalParams = array(
        'collection_date' => $cotation->get('collection_date'),
        'delay' => 'aucun',
        'content_code' => 10120, // List of the available codes at samples/get_categories.php > List of contents
        'colis.valeur' => $cotation->get('colis_valeur') //colis.valeur prend comme valeur, la valeur colis_valeur entré dans le formulaire info livraison
    );
    
    
    /* Optionally you can define which carriers you want to quote if you don't want to quote all carriers
    $additionalParams['offers'] = array(
        0 => 'MONRCpourToi',
        1 => 'SOGPRelaisColis',
        2 => 'POFRColissimoAccess',
        3 => 'CHRPChrono13',
        4 => 'UPSEExpressSaver',
        5 => 'DHLEExpressWorldwide'
    );
    */
    /* Parcels informations */
    $parcels = array(
        'type' => 'colis', // your shipment type: "encombrant" (bulky parcel), "colis" (parcel), "palette" (pallet), "pli" (envelope)
        'dimensions' => array(
            1 => array(
                'poids' => $cotation->get('colis_poids'), // parcel weight
                'longueur' => 15, // parcel length
                'largeur' => 16, // parcel width
                'hauteur' => 8 // parcel height
            )
        )
    );
    
    $currency = array('EUR' => '&#8364;', 'USD'=>'&#36;');
    
    // Prepare and execute the request
    $lib = new Quotation();
    $lib->getQuotation($from, $to, $parcels, $additionalParams);
        
        return $this->render('transporteur/cotation.html.twig', [
            'controller_name' => 'TransporteurController',
            'cotations' => $lib->offers,
            'curl_error' => $lib->curl_error,
            'resp_error' => $lib->resp_error
        ]);
    }
}