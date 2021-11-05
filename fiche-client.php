<?php 
//include "config.php"; ?>
<div class="row" id="couleur_entete">

    <!-- Profile Info and Notifications -->
    <div class="col-md-6 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <?php
            $id = $_GET['id'];
//            $id = 1;
            $currentId = $id;
            
            $soc = '';
            $soc = getClientById($currentId);
						$nom = $soc != '' ? $soc->RAISON_SOC_CLIENT() : '';
//                                                logInConsole('le id = '. $currentId);
                                                
           // var_dump($soc);
            ?>
           
             <div class="btn-group">
                <a href="/?page=clients">
                    <button type="button" class="btn btn-blue btn-icon icon-lef btn-lg back-link-btn">
                        RETOUR
                        <i class="entypo-reply"></i>
                    </button>
                </a>
            </div>

    </div>


    <?php // include('neon/info-bar.php'); logInConsole('le id = '. $currentId); ?>	
</div>
<style>
	.profile-buttons a, .details_client a{
		font-size: 14px;
		width: 250px;
		margin-bottom: 7px;
	}
	.profile-buttons i{
		color:#303641;
	}
	.details_client a:hover{
		background-color: #fff;
	}
	.profile-buttons i{
		font-size: 17px !important;
		width: 36px;
	}
	.details_client li{
		margin-top: 7px
	}
	.bloc_detail_client{
		border-right: 2px dotted #dbdbdd;
		background-color: #dbdbdd;
    border-radius: 2px;
		padding: 16px 0;
	}
	.row_detail_client{
		margin-left: -7px;
    margin-right: -7px;
	}
	#goToBottom{
		font-size: 40px;
    margin: -34px 24px 0px 0;
		display:none;
	}
  #table-1{
    width:100%;
  }
  #table-1 th, #table-1 td{
    padding: 4px;
  }
</style>
<div class="container" style="margin-top: 32px;">
	<br>
        <div class="panel panel-primary" data-collapsed="0">
            
            <div class="panel-heading" style="background-color:#303641;">
                <div class="panel-title">
                    <h3 style="color: white;">Fiche Client</h3>
                </div>
                <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open" style="color:white;"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw" style="color:white;"></i></a>
                        <a href="/?page=clients" class="back-link-btn"><i class="entypo-cancel" style="color:white;"></i></a>
                </div>
            </div>
            
            <div class="panel-body">
              <div class="profile-env row">

                <div class="col-md-3">
                  <table><tr>
                    <td>
                    <center>
                        <div style="width:90px; height:90px; background:#43C0F2; -moz-border-radius:50px; -webkit-border-radius:50px; border-radius:50px;">
                            <h1 style="color:white;line-height:90px; text-align:center;"> 
                                <?php 
                                  $a = strpos($nom,' ');

                                  if ($a != NULL){
                                      $i = $nom[0].substr($nom, $a+1, 1);
                                      echo $i;
                                  } else {
                                      echo $nom[0];
                                  }
//						logInConsole('le id = '. $currentId);																		
//                                                
                                ?>
                            </h1>
                        </div>
                    </center>
                </td>
                <td>
                        <div class="profile-name col-md-12 col-xs-12">
                            <strong>
                                <h2><?php 
                                      echo $soc != '' ? stripslashes($nom) : ''; 
//                                echo 'CIMFASO'; 
                                ?></h2>
                            </strong>

                        </div>
                    </td>
                  </tr></table>
                 <br>
                </div>
                    <div class="col-md-3">
                      <div class="tile-stats tile-green">
                        <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                        <div class="num" id="">
                          <?php
                            echo $soc->NBRE_LIVRE(); 
                          ?>
                        </div>
                        <p>Livraisons au total</p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                  </div>
                        
          <div style="margin:16px 0 16px 0;">
            <div class="row row_detail_client">
              <div class="col-md-6 bloc_detail_client">

               <ul class="details_client" style="font-size:14px; list-style-type: none;">	
                 <li>
                   <i class="entypo-location"></i>
                   Adresse : <?php echo $soc != '' ? stripslashes($soc->ADRESSE_CLIENT()) : ''; ?>
                 </li>	
                 <li>
                   <i class="entypo-phone"></i>
                   Contacts : <?php echo $soc != '' ? stripslashes($soc->CONTACTS_CLIENT()) : ''; ?>
                 </li>	
                 <li>
                   <i class="entypo-flag"></i>
                   Pays : <?php echo $soc != '' ? stripslashes($soc->PAYS_CLIENT()) : ''; ?>
                 </li>	
               </ul>

              </div>
              <div class="col-md-6">
                <div class="profile-buttons">
                  <a href="/?page=edit-client&id=<?php echo $currentId; ?>" 
                     class="btn btn-default btn-icon icon-left" onclick="" >
                      Modifier
                      <i class="entypo-pencil" style="background-color: #a3a3a3;"></i>
                  </a >
                  <a class="btn btn-default btn-icon icon-left" style="color:red;" 
                     onclick="deleteClient(<?php echo $soc->ID_CLIENT();?>, '<?php echo $soc->RAISON_SOC_CLIENT();?>')" >
                      Supprimer
                      <i class="fa fa-trash-o"></i>
                  </a >
                </div>
              </div>
            </div>


</div>
</div>
<?php
  include "templates/modals/suppression.php"; ?>
<script src="modules/clients/scripts.js"></script>
<script src="modules/modals/scripts.js"></script>
<script>
	
	var $ = jQuery;
		$(document).ready(function() {
			
		} );
</script>

