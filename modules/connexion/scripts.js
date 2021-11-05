function deconnexion(d) {
  var mailLogout = $('#mailLogout').val();
  $.post('/core/login-traitement.php',
          'action=deconnexion&mailLogout=' + mailLogout,
          function (ret) { 
            console.log(ret);
              if(d){
               document.location.href = "/connexion.php?d=1";
              }else{
               document.location.href = "/connexion.php";
              }

          });
  return false;
}