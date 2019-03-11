<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Emc\Quotation;
use \Emc\ListPoints;
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
    public function cotation(Request $request)//renvoit une cotation (prix de l'envoi d'un colis) en fonction des paramètres 
    //country, zipcode, city, adress, collection_date, colis_valeur, colis_poids
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
      
      $from = array(//tableau contenant l'adresse de départ du colis
        'country' => 'FR', // must be an ISO code, set get_country example on how to get codes
        // "state" => "", if required, state must be an ISO code as well
        'zipcode' => '87300', //zipcode prend comme valeur, la valeur de la variable de session zipcode entré précédemment dans le formulaire info livraison
        'city' => 'Bellac',//même chose que pour le champs précédent
        'address' => 'Route du Dorat',//même chose que pour le champs précédent
        'type' => 'company' // accepted values are "company" or "individual"
    );
    
    $dest =  isset($_GET['dest']) ? $_GET['dest'] : 'client1';
    switch ($dest) {
        case 'client1':
            $to = array(//tableau contenant l'adresse de réception du colis
                "country" => $cotation->get('country'), // must be an ISO code, set get_country example on how to get codes
                // "state" => "", if required, state must be an ISO code as well
                "zipcode" => $cotation->get('zipcode'),
                "city" => $cotation->get('city'),
                "address" => $cotation->get('adress'),
                "type" => "individual" // accepted values are "company" or "individual"
             );
            break;
        default:
            $to = array(//adresse de réception par défaut
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
    $additionalParams = array(//paramètre supplémentaire du colis
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
    $parcels = array(//dimension, poids du colis
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


    /**
     * @Route("/transporteur/listePointRelais", name="pointRelais")
     */
    public function pointRelais(Request $request)//renvoit des point relais en fonction des paramètres transporteurName, country, zpidcode, city
    {
             
        $session = new Session();

        $session->set('transporteurName',$request->request->get('transporteur'));//on créer la variable de session transporteurName qui 
        //va contenir le transporteur sélectionné dans le form cotation(lors du clique "voir points relais")
        
        $lib = new ListPoints();
        
        $params = array(
            'collecte'=> 'exp', // whether it's for dropping ("exp") or picking up ("dest") a parcel, required for some operators
            'pays' => $session->get('country'), // country ISO code
            'cp' => $session->get('zipcode'), // zipcode
            'ville' => $session->get('city') // city
        );
        

        $lib->getListPoints(array($session->get('transporteurName')), $params);//on récupère les points relais du tranporteur sélectionné 

        $week_days = array( 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');//jour de la semaine sélectionné pour la requête
        

        return $this->render('transporteur/listePointRelais.html.twig', [
            'controller_name' => 'TransporteurController',
            'carriers' => $lib->list_points,
            'curl_error' => $lib->curl_error,
            'resp_error' => $lib->resp_error
            

        ]);

        
    }
}