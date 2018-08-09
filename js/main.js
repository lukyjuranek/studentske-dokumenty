$(document).ready(function(){
  //filtr souborů
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  //zapne toolptip
  $('[data-toggle="tooltip"]').tooltip(); 
  
  //Odstraní #nav_link_divider když je navbar collapsed
  $(".navbar-toggler").click(function(){
    $("#nav_link_divider").hide();
  });

  //Zmenší tabulku na menších displejích
  if($(document).width() < 769){
    $('.table').addClass('table-sm');
  };
  
});
  
  