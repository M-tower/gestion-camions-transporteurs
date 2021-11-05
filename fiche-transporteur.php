<?php 
//include "config.php"; ?>
<div class="row" id="couleur_entete">

    <!-- Profile Info and Notifications -->
    <div class="col-md-6 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
            <?php
            $id = $_GET['id'];
            
            $soc = getTransporteurById($id);
//						$nom = $soc != '' ? $soc->nom : '';
//						$nomDuClient = $soc->nom;
//						$idDuClient = $soc->id;
//                                                logInConsole('le id = '. $currentId);
                                                
           // var_dump($soc);
            ?>
           
             <div class="btn-group">
                <a href="/?page=transporteurs">
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
            <?php
              if(!is_object($soc)){
                echo '<h1>AUCUN TRANSPORTEUR POUR CET IDENTIFIANT</h1>'
                . '<p>Soit l\'élément que vous recherchez n\'existe pas, soit il a été supprimé</p>';
                die();
              }
            ?>
            <div class="panel-heading" style="background-color:#303641;">
                <div class="panel-title">
                    <h3 style="color: white;">Fiche Transporteur</h3>
                </div>
                <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open" style="color:white;"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw" style="color:white;"></i></a>
                        <a href="/?page=transporteurs" class="back-link-btn"><i class="entypo-cancel" style="color:white;"></i></a>
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
                                $le_nom = $soc->MAISON_TRANSP();
                                $a = strpos($le_nom,' ');

                                if ($a != NULL){
                                    $i = $le_nom[0].substr($le_nom, $a+1, 1);
                                    echo $i;
                                } else {
                                    echo $le_nom[0];
                                }
//logInConsole('le id = '. $currentId);																		
//                                                
                              ?>
                            </h1>
                        </div>
                    </center>
                    </td>
                    <td>
                      <div class="profile-name col-md-12 col-xs-12">
                          <strong>
                              <h2>
                                <?php 
                                  echo stripslashes($soc->MAISON_TRANSP());
                                ?>
                              </h2>
                          </strong>

                      </div>
                    </td>
                  </tr></table>
                 <br>
                </div>
                <div class="col-md-3">
                  <div class="tile-stats tile-blue">
                    <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                    <div class="num" id="le_total<?php //echo $soc->id;?>">
                      <?php 
//                                                  echo format_nombre($total); 
                      echo '12'; 
                      ?>
                    </div>
                    <p>Total de camions</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="tile-stats tile-green">
                    <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                    <div class="num" id="le_ope<?php //echo $soc->id;?>">
                      <?php 
//                                                  echo format_nombre($total); 
                      echo '10'; 
                      ?>
                    </div>
                    <p>Opérationnels</p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                    <div class="num" id="le_maint<?php //echo $soc->id;?>">
                      <?php 
//                                                  echo format_nombre($total); 
                      echo '2'; 
                      ?>
                    </div>
                    <p>En maintenance</p>
                  </div>
                </div>
              </div>
                        
              <div style="margin:16px 0 16px 0;">
                <div class="row row_detail_client">
                  <div class="col-md-6 bloc_detail_client">

                   <ul class="details_client" style="font-size:14px; list-style-type: none;">	
                     <li>
                       <i class="entypo-location"></i>
                       Adresse : <?php echo $soc->ADRESSE_TRANSP()?>
                     </li>	
                     <li>
                       <i class="entypo-phone"></i>
                       Contacts : <?php echo $soc->CONTACTS_TRANSP() ?>
                     </li>
                     <li>
                       <i class="entypo-user"></i>
                       Dirigeant : <?php echo $soc->DIRIGEANT_TRANSP() ?>
                     </li>	
                     <li>
                       <i class="entypo-mail"></i>
                       Adresse mail : <?php echo $soc->MAIL_TRANSP() ?>
                     </li>	
                   </ul>

                  </div>
                  <div class="col-md-6">
                    <div class="profile-buttons">
                      <a href="/?page=edit-transporteur&id=<?php echo $soc->ID_TRANSP(); ?>" 
                         class="btn btn-default btn-icon icon-left" onclick="" >
                          Modifier
                          <i class="entypo-pencil" style="background-color: #a3a3a3;"></i>
                      </a >
                      <a class="btn btn-default btn-icon icon-left" style="color:red;" 
                         onclick="deleteTransporteur(<?php echo $soc->ID_TRANSP(); ?>,'<?php echo addslashes($soc->MAISON_TRANSP()); ?>')" >
                          Supprimer
                          <i class="fa fa-trash-o"></i>
                      </a >
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="titre_">
                        <table width="100%"><tr>
                            <td><h3 style="color: white;">A propos de <?php echo $soc->MAISON_TRANSP(); ?></h3></td><td></td>
                        </tr></table>
                    </div>
                    <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
                     <li class="active">
                         <a href="#camions" data-toggle="tab" onclick="">
                             <span class="visible-xs"><i class="entypo-user"></i></span>
                             <span class="hidden-xs">Liste des camions du transporteur</span>
                         </a>
                     </li>
                    </ul>

                    <div class="tab-content" id="porteurDetail">
                        <div class="tab-pane onglet2 active" id="camions">
                          <div class="btn-group">
                            <button type="button" class="btn btn-blue btn-icon icon-lef btn-lg"
                                    onclick="controleur('myModalEditCamion');showModal('myModalEditCamion');"
                                    style="margin-left: 15px; margin-bottom: 10px;">
                                Ajouter un camion
                                <i class="entypo-user-add"></i>
                            </button>
                          </div>
                            <div class="scrollable" data-height="400" style="height:400px">
                                <div class="col-md-12" id="blockDetail1_2">
                                    <div class="">
                                    <table class="simpleTab table-bordered table-camion" id="table-1">
                                        <thead>
                                          <tr>
                                            <th class="borderLeftTab" style="width:30%;">Immatriculation</th>
                                            <th class="borderLeftTab" style="width:50%;">Etat actuel</th>
                                            <th class="borderLeftTab" style="width:20%;">Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="text-align:center;width: 100%">
                        <a href="#tip1" id="goToBottom" onclick="ajustementScroll(1)"><i class="fa fa-chevron-circle-down"></i></a>
                    </div>
                </div>
              </div>
            </div>
<?php 
include "templates/modals/suppression.php";        
include "templates/modals/edit-camion.php"; 
?>
<script src="modules/datatables/initialisation.js"></script>
<script src="modules/datatables/scripts.js"></script>    
<script src="modules/transporteurs/scripts.js"></script>
<script src="modules/modals/scripts.js"></script>
<script src="modules/camions/scripts.js"></script>
<script src="neon/assets/js/jquery.inputmask.bundle.min.js"></script>
<script>
	
	var $ = jQuery;
		$(document).ready(function() {
      refreshListeCamions('<?php echo $soc->ID_TRANSP() ?>');
		} );
		function changeTip(a,onglet){
				$('#goToBottom').attr('href', '#tip'+a);
				$('#goToBottom').attr('onclick', 'ajustementScroll('+a+')');
					setTimeout(function () {
						if($('#blockDetail1_'+a).height() > 400 || $('#blockDetail2_'+a).height() > 400){
							$('#goToBottom').css('display', 'block');
						}else{
							$('#goToBottom').css('display', 'none');
						}
					}, 1000);
		}
		function ajustementScroll(a){
			var taille = $('.onglet'+a+' .slimScrollBar').height();
			$('.onglet'+a+' .slimScrollBar').css('top',400-taille);
				// console.log('la taille = '+taille);
		}

    
</script>

