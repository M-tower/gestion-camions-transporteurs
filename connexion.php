<?php 
session_start();
if (isset($_SESSION['header'])){
  echo '<meta http-equiv="refresh" content="0;URL=/">';
  die();
}
//include('core/fonctions-old.php');
//echo phpinfo();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//echo $_SESSION['header'] . '++++';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="syntract-transport Admin Panel" />
    <meta name="author" content="ARTHEMYS TECHNOLOGY" />
    <title>Connexion | SY.NA.TRA.C.T - Transport</title>
    <link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="/neon/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/neon/assets/css/neon-core.css">
    <link rel="stylesheet" href="/neon/assets/css/neon-theme.css">
    <link rel="stylesheet" href="/neon/assets/css/neon-forms.css">
    <link rel="stylesheet" href="/neon/assets/css/custom.css">
    <link rel="icon" href="img/favicon_synatract.PNG" sizes="32x32" />
    <link rel="icon" href="img/favicon_synatract.PNG" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="img/favicon_synatract.PNG" />
    <meta name="msapplication-TileImage" content="img/favicon_synatract.PNG" />
    <!--[if lt IE 9]><script src="/neon/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="neon/css/fond-sombre.css">
</head>
<body class="page-body login-page login-form-fall" id="log">
<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var baseurl = '';
</script>
<style type="text/css">
  #login{
      margin-top:35%;
  }
  #log{
      background: none;
      background-image:url(img/background_syntract.jpg);
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      background-attachment: fixed;

  }
  .input-group{
      border: none !important;
  }
  .titre_con{
    text-align: center;
    font-weight: 700;
    color: #fff;
  }

</style>
<?php
$ndb = 'null';
$ndbGet = '' . filter_input(INPUT_GET, 'ndb');
if (strlen($ndbGet) > 0) {
    $ndb = $ndbGet;
}
?>
<div class="login-container" style="">
    <div class="login-progressbar">
        <div></div>
    </div>
    <div class="login-form">
        <div class="login-content">
            <div id="couleur-login">
                <form id="login">
                    <div id="wait"></div>
                    <div id="erreur"></div>
                    <center>
                      <a href="/">
                        <img style="margin-top:-64px;margin-bottom:12px;background-color: #fff;border-radius: 7px;" 
                             src="/img/logo_new.PNG" width="100%">
                      </a>
                    </center>
                    <h2 class="titre_con">Espace Administration</h2>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-user"></i>
                            </div>
                            <input type="mail" class="form-control mail submitable-field" name="mail" id="mail" 
                                   placeholder="Email ou Pseudo" autocomplete="on"
                                   value="" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-key"></i>
                            </div>
                            <input type="password" class="form-control pwd submitable-field" name="pwd" id="pwd" placeholder="Mot de passe" autocomplete="on"
                                   value="" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="submit btn btn-success btn-block btn-logn" style="padding:16px" 
                                id="btn-couleur" onclick="show_loading_bar(100);return connexion();">
                            <i class="entypo-login"></i>
                            CONNEXION
                        </button>
                    </div>
                </form>
                
                <span style="color: #fff;text-shadow: 1px 1px 2px #000">
                 Mot de passe oublié?
                </span>
                <a href="javascript:;" onclick="jQuery('#modal-1').modal('show');" style="font-size:14px;color:#58bafc">Cliquez ici</a>
                <br> <br>
<!--                <span style="color: #fff;text-shadow: 1px 1px 2px #000">
                Vous n'avez pas de compte ?
                </span>
                <a href="/inscription.php" class="link" style="font-size:14px;color:#58bafc">Créer un compte</b></a>-->

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Remplissez ce formulaire</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-md-12 col-xs-12 control-label"></label>
                        <div class="col-md-12 col-xs-12 input-group">
                         <span class="input-group-addon">Email *</span>
                         <input type="text" name="mail1" id="mail1" class="form-control input-lg submitable-field" value="" required="required" placeholder="Exemple : xxxxxxxx@gmail.com"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-info" onclick="askChangeMDP()">Envoyer</button>
            </div>
        </div>
    </div>
</div>
<!-- Bottom scripts (common) -->
<!--<script type="text/javascript" src="core/connexion/jquery.js"></script>
<script type="text/javascript" src="core/connexion/ajax.js"></script>-->
<script src="/neon/assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>
<script src="/neon/assets/js/gsap/main-gsap.js"></script>
<script src="/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="/neon/assets/js/bootstrap.js"></script>
<script src="/neon/assets/js/joinable.js"></script>
<script src="/neon/assets/js/resizeable.js"></script>
<script src="/neon/assets/js/neon-api.js"></script>
<script src="/neon/assets/js/jquery.validate.min.js"></script>
<script src="/neon/assets/js/neon-login.js"></script>
<script src="neon/assets/js/toastr.js"></script>
<!-- JavaScripts initializations and stuff -->
<!--<script src="/neon/assets/js/neon-custom.js"></script>-->
<!-- Demo Settings -->
<script src="/neon/assets/js/neon-demo.js"></script>
<script src="/neon/assets/js/neon-chat.js"></script>
<script src="/neon/assets/js/neon-custom.js"></script>
<script>
 var $ = jQuery;


 var submitableBtns = $(".submitable-field");

 submitableBtns.on("keyup",(event)=>{
     if(event.keyCode === 13){
         connexion()
     }
 });
    var optsNo = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-full-width",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    function connexion() {
      var mail = $('#mail').val();
      var pwd = $('#pwd').val();
//        var ndb = $('#ndb').val();
      $.post('core/login-traitement.php',
          'action=connexion&mail=' + mail + '&pwd=' + pwd,
          function (ret) {
            console.log('ret ' + ret);
            if(ret=='ok'){
                document.location.href = "/";
            }else{
                toastr.error('Email ou mot de passe invalide : '+ret, 'Connexion impossible', optsNo);
                console.log(ret);
            }
          });
      return false;
    }
 function askChangeMDP(){
  var mail = $('#mail1').val();
  $.post('core/ajax.php',
  'action=askChangeMDP'
  +'&mail='+mail,
  function(e){
   if(e == 'non'){
    toastr.error('Oups! Revérifiez les informations du formulaire. Aucune référence à cet adresse mail');
    return;
   }else{
    toastr.info(e);
    console.log(e);
//    document.location.href = "/";
    setTimeout(function () {
        document.location.href = "/";
    }, 10 * 500);
   }
  })
 }
</script>
</body>
</html>
