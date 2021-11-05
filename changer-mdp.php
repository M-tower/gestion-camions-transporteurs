<?php

/* 
 * Interface de changement de mot de passe
 */

include "core/functions.php";
//session_start();

//if (!isset($_SESSION['header'])){
//    echo '<meta http-equiv="refresh" content="0;URL=/">';
//    die();
//}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="syntract-transport Admin Panel" />
  <meta name="author" content="ARTHEMYS TECHNOLOGY" />
  <title>Changer mot de passe | SY.N.TRA.C.T. - Transport</title>
  <link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
  <link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
  <link rel="stylesheet" href="/neon/assets/css/bootstrap.css">
  <link rel="stylesheet" href="/neon/assets/css/neon-core.css">
  <link rel="stylesheet" href="/neon/assets/css/neon-theme.css">
  <link rel="stylesheet" href="/neon/assets/css/neon-forms.css">
  <link rel="stylesheet" href="/neon/assets/css/custom.css">
  <link rel="icon" href="img/favicon-s.png" sizes="32x32" />
  <link rel="icon" href="img/favicon-s.png" sizes="192x192" />
  <link rel="apple-touch-icon-precomposed" href="img/favicon-s.png" />
  <meta name="msapplication-TileImage" content="img/favicon-s.png" />

  <link rel="stylesheet" href="neon/assets/css/font-icons/font-awesome/css/font-awesome.min.css">

  <script src="neon/assets/js/jquery-1.11.0.min.js"></script>
  <script>$.noConflict();</script>

  <!--[if lt IE 9]>
  <script src="neon/assets/js/ie8-responsive-file-warning.js"></script>
  <![endif]--> <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --> <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="page-body login-page login-form-fall" >
 <style>
  .login-page .login-header{
   padding: 30px 0;
  }
 </style>
<script type="text/javascript">
    var baseurl = '/';
</script>
<?php
 /* connexion pour tester la validité des infos de POST dans l'url */
 $e = 0;
 if(isset($_GET['mail']) && isset($_GET['oldpass'])){
  $e= loginUser($_GET['mail'], $_GET['oldpass']);
//  logInConsole($_GET['mail'].' '.$_GET['oldpass'].' '.$_GET['ndb']);
  $desc = 'Remplissez le formulaire ci-dessous pour changer votre mot de passe.';
 }
 if ($e!=1) {
  $desc = 'Humm! les informations présentes dans l\'url ne sont pas valables. '
    . 'Vous pouvez toujours contater le service technique sur le +228 90046098';
 }
?>
<div class="login-container">
    <div class="login-header login-caret">
        <div class="login-content">
            <a href="/">
              <img style="margin-top:-64px;margin-bottom:12px;" src="/img/logo_camion.PNG" width="100%">
            </a>
            <p class="description"><?php echo $desc; ?></p>
            <!-- progress bar indicator -->
            <div class="login-progressbar-indicator">
                <h3>43%</h3>
                <span>logging in...</span>
            </div>
        </div>
    </div>
    <div class="login-progressbar">
        <div></div>
    </div>
    <div class="login-form">
        <div class="login-content">
            <form method="post" role="form" id="form_register">
                <div class="form-register-success">
                    <i class="entypo-check"></i>
                    <h3>You have been successfully registered.</h3>
                    <p>We have emailed you the confirmation link for your account.</p>
                </div>
             <?php 
              if($e==1){
              ?>
                <div class="form-steps">
                    <div class="step current" id="step-1">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-lock"></i>
                                </div>

                                <input type="password" class="form-control" name="password" id="password" placeholder="Nouveau mot de passe" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-lock"></i>
                                </div>

                                <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmez le mot de passe" autocomplete="off" onkeyup="verifMdp()"
                                       data-toggle="tooltip" data-placement="top" title="" data-original-title=""/>
                            </div>
                        </div>
                        <div class="form-group">
                         <button type="button" id="send-btn" class="btn btn-success btn-block btn-login" disabled="true" onclick="changeMDP();">
                                <i class="entypo-right-open-mini"></i>
                                Valider
                            </button>
                        </div>
                    </div>
                </div>
              <?php 
              }
              ?>
            </form>
            <div class="login-bottom-links">
                <a href="/connexion.php" class="link">
                    <i class="entypo-lock"></i>
                    Retour à la page de connexion
                </a>
            </div>
        </div>
    </div>
</div>


<script src="neon/assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
<script src="neon/assets/js/gsap/main-gsap.js"></script>
<script src="neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="neon/assets/js/bootstrap.js" id="script-resource-3"></script>
<script src="neon/assets/js/joinable.js" id="script-resource-4"></script>
<script src="neon/assets/js/resizeable.js" id="script-resource-5"></script>
<script src="neon/assets/js/neon-api.js" id="script-resource-6"></script>
<script src="neon/assets/js/cookies.min.js" id="script-resource-7"></script>
<script src="neon/assets/js/jquery.validate.min.js" id="script-resource-8"></script>
<script src="neon/assets/js/neon-register.js" id="script-resource-9"></script>
<script src="neon/assets/js/jquery.inputmask.bundle.min.js" id="script-resource-10"></script>
<!-- JavaScripts initializations and stuff -->
<!--<script src="neon/assets/js/neon-custom.js" id="script-resource-11"></script>-->
<!-- Demo Settings -->

<script src="neon/assets/js/neon-skins.js" id="script-resource-13"></script>
<script src="neon/assets/js/neon-custom.js" id="script-resource-11"></script>
<script src="neon/assets/js/neon-demo.js" id="script-resource-12"></script>
<script src="neon/assets/js/toastr.js"></script>
<script src="modules/modals/scripts.js"></script>


<script type="text/javascript">
    var $ = jQuery;
    var opts = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-left",
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
    function changeMDP(){ /*  */
        var pwd = $('#password').val();
        var mail = '<?php echo $_GET['mail']; ?>';
        $.post('core/ajax.php',
            'action=changeMDP'
            + '&mail=' + mail
            + '&pwd=' + pwd,
            function (returnedData) {
             if(returnedData == 'non'){
              toastr.error('Un problème s\'est produit.')
             }else{
              console.log(returnedData);
              toastr.success('Opération réussie! Votre mot de passe a été changé avec succès.');
              setTimeout(function () {
                  document.location.href = "/connexion.php";
              }, 6 * 500);
             }
            });
    }
    function verifMdp(){
        var mdp = $('#password').val();
        var mdp2 = $('#password2').val();
        if(mdp != mdp2){ // non compatible
            $('#password2').closest('div').css('border','1px solid #cd5c5c');
            $('#password2').attr('data-original-title', 'Les mots de passe ne sont pas les mêmes');
            tooltip_script(); /*activation des tooltip (boite de dialogue) */
            $('#send-btn').attr('disabled','true');
        }else{
            $('#password2').closest('div').css('border','1px solid #2b9411');
            $('#password2').attr('data-original-title', '');
            $('#send-btn').removeAttr('disabled');
            return false;
        }
    }
</script>
</body>
</html>
