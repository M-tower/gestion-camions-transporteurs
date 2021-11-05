<?php

 session_start();


 if (isset($_SESSION['header']) || !isset($_GET['page'])) {
    include('neon/header.php');
//     if (!checkAuth()){
//         echo '<meta http-equiv="refresh" content="0;URL=/connexion.php?ndb=' . $_SESSION['ndb'] . '">';
//         die();
//     }


    $page = '';
    if (isset($_SERVER['REQUEST_URI'])) {
        $params = '';
        if (isset($_SERVER['QUERY_STRING'])) {
            $params = $_SERVER['QUERY_STRING'];
        }
        $page = $_SERVER['REQUEST_URI'];
        if ('/' == substr($page, 0, 1)) {
            $page = substr($page, 1);
        }
        if (strlen($params) > 0) {
            $page = substr($page, 0, strlen($page) - strlen($params) - 1);
        }
    }
    if (strlen($page) < 1) {
        $page = filter_input(INPUT_GET, 'page');
    }
    if (strlen($page) < 1) {
        $page = 'accueil';
    }
//    echo '<!-- $_SERVER=' . print_r($_SERVER, true) . ' -->';
    echo '<!-- page=' . $page . ' -->';
    if(file_exists($page . ".php")){
      if (!isset($_SESSION['header']) && $page != 'accueil'){
        echo '<meta http-equiv="refresh" content="0;URL=/connexion.php">';
        die();
      }else if($page == 'connexion'){
        echo '<meta http-equiv="refresh" content="0;URL=/">';
        die();
      }else{
        include($page . ".php");
      }
    }else{
     echo ''
             . '<div class="page-error-404">
         <div class="error-symbol">
             <i class="entypo-attention"></i>
         </div>

         <div class="error-text">
             <h2>404</h2>
             <p>Page non trouvée!</p>
         </div>

         <hr />

         <div class="error-text">

             <a href="/">Retourner à l\'accueil</a>

             <br />
             <br />
         </div>
     </div>';
    }
    include('neon/footer.php');

 } else {
     echo '<meta http-equiv="refresh" content="0;URL=/connexion.php">';
 }
?>
