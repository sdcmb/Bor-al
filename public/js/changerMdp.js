var elem = document.getElementById('saisieNouveauMdp');
elem.style.opacity = 0.4;
var nouveau = document.getElementById('nvMdp');
var confirm = document.getElementById('confMdp');
nouveau.style.cursor = "not-allowed";
confirm.style.cursor = "not-allowed";
      
function verifMdp(value) {
    //<?php
        //$encoder = new UserPasswordEncoderInterface();
        //$encoded = $encoder->encodePassword(app.user, value);
    //?>
    // if (<?php echo $encoded ?> == app.user.password) { 
    if (value == "test") {
        var elem = document.getElementById('saisieNouveauMdp');
        elem.style.opacity = 1;
        var nouveau = document.getElementById('nvMdp');
        var confirm = document.getElementById('confMdp');
        nouveau.style.cursor = "auto";
        confirm.style.cursor = "auto";
    } else {
        var elem = document.getElementById('saisieNouveauMdp');
        elem.style.opacity = 0.4;
        var nouveau = document.getElementById('nvMdp');
        var confirm = document.getElementById('confMdp');
        nouveau.style.cursor = "not-allowed";
        confirm.style.cursor = "not-allowed";
    }
}