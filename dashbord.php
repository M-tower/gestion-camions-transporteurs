<style>
  .tb_distribution{
    display: flex;
  }
  .tb_distribution table{
    float: left;
    text-align: center;
    border-spacing: 4px;
    border-collapse: separate;
    border: 2px solid transparent;
    /*width: 152px;*/
  }
  .tb_distribution table.actif{
    border-color: #0073b7;
    border-radius: 4px;
  }
  .tb_distribution table:hover{
    border-color: #bababa;
    border-radius: 4px;
  }
  .tb_distribution table.actif .tb_date, .tb_distribution table.actif h4{
    background-color: #0073b7;
    color: #fff;
    border-radius: 4px;
  }
  .tb_distribution .tb_lib h4{
    font-weight: 800;
    color: #0073b7;
  }
  .tb_distribution .tb_lib{
    cursor: pointer;
  }
  .tb_distribution .tb_content{
    background-color: #eee;
    padding: 7px;
    border-radius: 4px;
  }
  .tb_distribution .tb_content .label-primary{
    background-color: #676a6f;
  }
  .tb_distribution .tb_content p{
    margin-top: 7px;
    margin-bottom: 0;
    font-weight: 700;
    color: #303641;
    font-size: 17px;
  }
  .tb_distribution .fa-check-circle{
    color: #00a651;
    font-size: 16px;
    cursor: pointer;
  }
  .tb_distribution .fa-times-circle{
    color: #ec2c58;
    font-size: 16px;
    cursor: pointer;
  }
  .tb_distribution .fleche_box{
    /*display: none;*/
  }
  .tb_distribution .fleche{
    font-size: 23px;
    margin: 0 3px;
    font-weight: 800;
    color: #0073b7;
    cursor: pointer;
  }
  .tb_distribution .fleche:hover{
    font-size: 23px;
    margin: 0 3px;
    font-weight: 800;
    color: #676a6f;
  }
  .tb_distribution .tb_content:hover .fleche_box{
    display: block;
  }
  
  .tb_distribution .immat{
    cursor: pointer;
  }
  .select-col td{
    box-shadow: 1px 1px 11px #4093c3;
  }
  .disabled-button, .disabled i, .disabled h4{
    color: #adadad !important;
  }
  .disabled .label.label-primary{
    background-color: #c5c5c5 !important;
  }
  .navig{
    font-size: 72px;
    cursor: pointer;
    margin-top: 132px;
  }
  .panel-heading > .panel-options{
    padding: 10px 15px;
  }
</style>
<div class="container">
			<div class="row">
				<div class="col-md-12">
		
		
<script type="text/javascript">
jQuery(document).ready(function($)
{
//	remplirParDefaut();
});

function getRandomInt(min, max)
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>
<?php 
  $all_transporteurs = sizeof(getAllTransporteurs());
  $all_camionsMain = 0;
  $all_clients = sizeof(getAllClients());
  
/*  traitement du tableau */
  $num_cycle = (is_array(getActifCycle()))? getActifCycle()['ID_CYCLE'] : getLastIdCycle() + 1;
  $Cycle_is_exist = getIfElementExist('ID_CYCLE', $num_cycle, 'cycles');
  $actif_jour = ($Cycle_is_exist != 0)? getActifsJoursByCycle($num_cycle)[0]['NUM_JOUR'] : 1;
  $all_camions = ($Cycle_is_exist != 0)? sizeof(getAllByCycleForTableau($num_cycle)) : sizeof(getAllCamions());
  $all_camionsOpe = $all_camions;
  
//  print_r($jour);
?>

<div class="row">
	<div class="col-sm-3 col-xs-6">

		<div class="tile-stats tile-red">
			<div class="icon"><i class="entypo-users"></i></div>
			<div class="num" data-start="0" data-end="<?php echo $all_transporteurs; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>

			<h3>Transporteurs</h3>
			<p>...</p>
		</div>

	</div>

	<div class="col-sm-3 col-xs-6">

		<div class="tile-stats tile-green">
			<div class="icon"><i class="entypo-rocket"></i></div>
			<div class="num all_cam" data-start="0" data-end="<?php echo $all_camionsOpe; ?>" data-postfix="" data-duration="1500" data-delay="600">0</div>

			<h3>Camion(s) en service</h3>
			<p>...</p>
		</div>

	</div>

	<div class="col-sm-3 col-xs-6">

		<div class="tile-stats tile-aqua">
			<div class="icon"><i class="entypo-tools"></i></div>
			<div class="num nb_jour" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="1200">0</div>

			<h3>Nombre de jours</h3>
			<p>...</p>
		</div>

	</div>

	<div class="col-sm-3 col-xs-6">

		<div class="tile-stats tile-blue all_clients">
			<div class="icon"><i class="entypo-rss"></i></div>
			<div class="num" data-start="0" data-end="<?php echo $all_clients; ?>" data-postfix="" data-duration="1500" data-delay="1800">0</div>

			<h3>Client(s) à fournir</h3>
			<p>...</p>
		</div>

	</div>
</div>

<br />
<div class="row">
    <div class="col-sm-12">
      <div style="text-align:center;">
        <span class="mess-alert-save alert alert-danger" style="display:none">N'oubliez pas d'enregistrer vos modifications</span>
      </div>
      <h2 style="text-align:center">Edition du Tableau de distribution N° <span class="num_cycle"><?php echo $num_cycle;  ?></span> 
        <button class="btn btn-success" style="font-size:17px" onclick="saveTout()">
          <i class="fa fa-save"></i> Enregistrer et publier</button>
      </h2>
    </div>
</div>

<div class="row">
  <div class="col-sm-1" style="text-align:right"><i class="fa fa-chevron-left navig" onclick="goLeft()"></i></div>
	<div class="col-sm-10">

		<div class="panel panel-primary" id="charts_env">

			<div class="panel-heading">
				<div class="panel-title">
          Client à fournir : 
          <select class="client_select">
            <option value=""> - Aucun - </option>
            <?php
              $list_cli = getAllClients();
              $options = '';
              for($c=0; $c<sizeof($list_cli); $c++){
                $options .= '<option value="'.$list_cli[$c]['ID_CLIENT'].'">'
                        . $list_cli[$c]['RAISON_SOC_CLIENT']
                        . '</option>';
              }
              echo $options;
            ?>
          </select>
           | 
           <button class="btn btn-blue" style="" onclick="JourPrec()">
              <i class="fa fa-chevron-left"></i>
           </button> 
           Changer de jour 
           <button class="btn btn-blue" style="" onclick="JourSuiv()">
              <i class="fa fa-chevron-right"></i>
           </button>
        </div>

				<div class="panel-options">
          Modifier le nombre de jours
          <input class="nb_jour_field" style="width:44px; margin-top:1px" type="number" min="3" value="3"/>
          <button class="btn btn-blue" style="" onclick="addJour($('.nb_jour_field').val())">
            Valider
          </button>
				</div>
			</div>

			<div class="panel-body" style="overflow-x: scroll;">
        <input type="hidden" id="last_day" value="<?php echo getRankTransp()[0]['NBR']; ?>"/>
				<div class="tab-content tb_distribution">
          
          
				</div>

			</div>

			<table class="table table-bordered table-responsive">

				<thead>
					<tr>
						<th width="50%" class="col-padding-1">
							<div class="pull-left">
								<div class="h4 no-margin">Nombre de camions en maintenance</div>
								<span class="numb-maint">0</span>
							</div>
							<span class="pull-right pageviews interval_jours"></span>

						</th>
						<th width="50%" class="col-padding-1">
							<div class="pull-left">
<!--								<div class="h4 no-margin">Nombre de jours désactivés</div>
								<span class="nb_jour_off">0</span>-->
							</div>
              <input type="hidden" class="cycle_exist" value="<?php echo $Cycle_is_exist;  ?>">
              <input type="hidden" class="selected_jour" value="<?php echo $actif_jour;  ?>">
              <input type="hidden" class="slide_position" value="0">
              <input type="hidden" class="scroll_position" value="0">
              <input type="hidden" class="jr_ajoute" value="0">
              <span class="pull-right uniquevisitors">Cycle N° <span class="num_cycle"><?php echo $num_cycle;  ?></span></span>
						</th>
					</tr>
				</thead>

			</table>

		</div>

	</div>
  <div class="col-sm-1"><i class="fa fa-chevron-right navig" onclick="goRight()"></i></div>
</div>
<script src="modules/tableau/scripts.js"></script>
<script src="modules/modals/scripts.js"></script>
<script>
  window.onload = function(){
    remplir();
  };
</script>
<?php
  include_once 'templates/modals/next-cycle.php';
  include_once 'templates/modals/add-drop-jour.php';
