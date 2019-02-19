var elem = document.getElementById('saisieNouveauMdp');
elem.style.opacity = 0.4;
var nouveau = document.getElementById('nvMdp');
var confirm = document.getElementById('confMdp');
var bouton = document.getElementById('btnMdp');
nouveau.style.cursor = "not-allowed";
confirm.style.cursor = "not-allowed";
bouton.style.cursor = "not-allowed";
nouveau.disabled = true;
confirm.disabled = true;
bouton.disabled = true;
      
function verifMdp(value) {
    //<?php
        //$encoder = new UserPasswordEncoderInterface();
        //$encoded = $encoder->encodePassword(user, value);
    //?>
    //if (<?php echo $encoded ?> == mdpActuel) { 
    if (value == "mdpActuel") {
        var elem = document.getElementById('saisieNouveauMdp');
        elem.style.opacity = 1;
        var nouveau = document.getElementById('nvMdp');
        var confirm = document.getElementById('confMdp');
        nouveau.style.cursor = "auto";
        confirm.style.cursor = "auto";
        bouton.style.cursor = "auto";
        nouveau.disabled = false;
        confirm.disabled = false;
        bouton.disabled = false;
    } else {
        var elem = document.getElementById('saisieNouveauMdp');
        elem.style.opacity = 0.4;
        var nouveau = document.getElementById('nvMdp');
        var confirm = document.getElementById('confMdp');
        nouveau.style.cursor = "not-allowed";
        confirm.style.cursor = "not-allowed";
        bouton.style.cursor = "not-allowed";
        nouveau.disabled = true;
        confirm.disabled = true;
        bouton.disabled = true;
        alert('Mot de passe incorrect')
    }
}