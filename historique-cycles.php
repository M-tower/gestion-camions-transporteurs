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
//  $all_transporteurs = sizeof(getAllTransporteurs());
//  $all_camions = sizeof(getAllCamions());
//  $all_camionsOpe = $all_camions;
//  $all_camionsMain = 0;
//  $all_clients = sizeof(getAllClients());
  
/*  traitement du tableau */
  
  
//  print_r($jour);
?>

<div class="row">
    <div class="col-sm-12">
      <h2 style="text-align:center">Historique des Tableaux de distribution</h2>
    </div>
</div>

<div class="row">
  <div class="col-sm-1" style="text-align:right"><i class="fa fa-chevron-left navig" onclick="goLeft()"></i></div>
	<div class="col-sm-10">

		<div class="panel panel-primary" id="charts_env">

			<div class="panel-heading">
				<div class="panel-title">
          Affichage du cycle N° : 
          <select class="cycle_select" onchange="remplirHistorique()">
            <option value="0"> - Aucun - </option>
            <?php
              $list_cli = getAllInactifCycles();
              $options = '';
              $first = 0;
              for($c=0; $c<sizeof($list_cli); $c++){
                $selected = ($first==0)? 'selected' : '';
                $options .= '<option value="'.$list_cli[$c]['ID_CYCLE'].'" '.$selected.'>'
                        . $list_cli[$c]['ID_CYCLE']
                        . '</option>';
                $first = 1;
              }
              echo $options;
            ?>
          </select>
        </div>

				<div class="panel-options">
          <div class="h4 no-margin">Nombre total de jours</div>
          <span class="nb_jour">0</span>
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
								
							</div>
							<span class="pull-right pageviews interval_jours"></span>

						</th>
						<th width="50%" class="col-padding-1">
							<div class="pull-left">
<!--								<div class="h4 no-margin">Nombre de jours désactivés</div>
								<span class="nb_jour_off">0</span>-->
							</div>
              <?php 
              $num_cycle = (is_array(getActifCycle()))? getActifCycle()['ID_CYCLE'] : getLastIdCycle() + 1;
              $Cycle_is_exist = getIfElementExist('ID_CYCLE', $num_cycle, 'cycles');
              $actif_jour = ($Cycle_is_exist != 0)? getActifsJoursByCycle($num_cycle)[0]['NUM_JOUR'] : 1;
              ?>
              <input type="hidden" class="cycle_exist" value="<?php echo $Cycle_is_exist;  ?>">
              <input type="hidden" class="selected_jour" value="<?php echo $actif_jour;  ?>">
              <input type="hidden" class="slide_position" value="0">
              <input type="hidden" class="scroll_position" value="0">
              <input type="hidden" class="jr_ajoute" value="0">
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
    remplirHistorique();
  };
  
</script>
<?php
//  include_once 'templates/modals/next-cycle.php';
//  include_once 'templates/modals/add-drop-jour.php';
