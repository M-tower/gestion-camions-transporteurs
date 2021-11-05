<style>
  .tb_distribution table{
    border-spacing: 4px;
    border-collapse: separate;
    border: 2px solid transparent;
    /*width: 152px;*/
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
  .select-col td{
    box-shadow: 1px 1px 11px #4093c3;
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

</script>
<?php 

?>

<div class="row">
    <div class="col-sm-12">
      <h2 style="text-align:center">Historique des activités</h2>
    </div>
</div>

<div class="row">
  <div class="col-sm-1" style="text-align:right"></div>
	<div class="col-sm-10">

		<div class="panel panel-primary" id="charts_env">

			<div class="panel-heading">
				<div class="panel-title">
          Affichage de l'historique complet de l'utilisateur : 
          <select class="cycle_select" onchange="remplirHistoriqueActivite()">
            <option value=""> - Aucun - </option>
            <?php
              $list_cli = getAllUsers();
              $options = '';
              $first = 0;
              for($c=0; $c<sizeof($list_cli); $c++){
                $selected = ($first==0)? 'selected' : '';
                $options .= '<option value="'.$list_cli[$c]['MAIL_UTIL'].'" '.$selected.'>'
                        . $list_cli[$c]['NOM_UTIL'] .' '. $list_cli[$c]['PRENOM_UTIL']
                        . '</option>';
                $first = 1;
              }
              echo $options;
            ?>
          </select>
        </div>

				<div class="panel-options">
          
				</div>
			</div>

			<div class="panel-body" style="overflow-y: scroll;height: 500px;">
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
						</th>
					</tr>
				</thead>

			</table>

		</div>

	</div>
  <div class="col-sm-1"></div>
</div>
<script src="modules/activites/scripts.js"></script>
<script src="modules/modals/scripts.js"></script>
<script>
  window.onload = function(){
    remplirHistoriqueActivite();
  };
  
</script>
<?php
//  include_once 'templates/modals/next-cycle.php';
//  include_once 'templates/modals/add-drop-jour.php';
