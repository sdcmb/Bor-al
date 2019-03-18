
$(document).ready(function(){
  $(".load").slice(0, 15).show(); //Permet d'afficher les 15 premiers produits
  $("#loadmore").on("click", function(e){ //Fontion appeler lors du click sur le bouton "Afficher plus"
    e.preventDefault();
    $(".load:hidden").slice(0, 15).slideDown();//Permet d'afficher les 15 produits suivants
    if($(".load:hidden").length == 0) {
      $("#loadmore").text("Aucun autre produit").addClass("noContent"); //Change le texte du bouton si il n'y à pas d'autre Produits
    }
  });

})
