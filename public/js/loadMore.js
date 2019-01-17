
$(document).ready(function(){
  $(".load").slice(0, 6).show();
  $("#loadmore").on("click", function(e){
    e.preventDefault();
    $(".load:hidden").slice(0, 6).slideDown();
    if($(".load:hidden").length == 0) {
      $("#loadmore").text("Aucun autre produit").addClass("noContent");
    }
  });

})
