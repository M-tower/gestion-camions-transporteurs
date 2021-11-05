<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="syntract-transport Admin Panel" />
    <meta name="author" content="ARTHEMYS TECHNOLOGY" />
    <title>LISTE | SY.NA.TRA.C.T - Transport</title>
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
<body>
  <script src="neon/assets/js/jquery-1.11.0.min.js"></script>
  <script src="neon/librairies/jspdf.min.js"></script>
  <script type="text/javascript">
    function setPDF() {
//    cursorProgress(true);
    var cycle = <?php echo $_GET['id_cycle']; ?>;
    var jour = <?php echo $_GET['num_jour']; ?>;
    var with_name = <?php echo (isset($_GET['with_name']))? $_GET['with_name'] : '0'; ?>;
    console.log(with_name + '----->');
    urlPDF='id_cycle='+cycle+'&num_jour='+jour+'&with_name='+with_name;
    jQuery.ajax({
        type: "POST",
        url: "/imprimables/convertor.php",
        data: urlPDF,
        dataType: "html",
        success: function (data) {
                console.log('envoi = ok '+data);
            if(data != ''){
              if(with_name == 1){
                $('#pdfVue object').attr('data', '../imprimables/fichiers-pdf/liste_jour_'+jour+'_cycle_'+cycle+'_avecNoms.pdf');
              }else{
                $('#pdfVue object').attr('data', '../imprimables/fichiers-pdf/liste_jour_'+jour+'_cycle_'+cycle+'.pdf');
              }
            }
//            cursorProgress(false);
        }
    });
      var lienPDF = 'factures/produit.pdf';
      $('#framePDF').attr('src', '');
      $('#framePDF').attr('src', 'https://docs.google.com/viewer?url=' + lienPDF + '&embedded=true');
      return true;
    }
    window.onload = function(){
      setPDF();
    };
  </script>
  <div class="tab-pane" id="pdfVue">
      <object data="" type="application/pdf" style="width:100%;height:1200px;">
          <div id="framePDF" name="printf" style="min-width: 480px"></div>
      </object>
  </div>
</body>
</html>