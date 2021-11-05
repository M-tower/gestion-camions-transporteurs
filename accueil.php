<style>
  .page-container .main-content{
    background-image:url(img/background_syntract.jpg);
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-attachment: fixed;
  }
  
  .tb_distribution{
    display: flex;
  }
  .tb_distribution table{
    float: left;
    text-align: center;
    border-spacing: 4px;
    border-collapse: separate;
    border: 2px solid transparent;
  }
  .tb_distribution table.actif{
    border-color: #fff;
    border-radius: 4px;
  }
  .tb_distribution table:hover{
    border-color: #bababa;
    border-radius: 4px;
  }
  .tb_distribution table:hover .tb_content{
    background-color: #eee;
  }
  .tb_distribution table.actif .tb_date,  .tb_distribution table.actif h4{
    background-color: #fff;
    color: #000;
    border-radius: 4px;
  }
  .tb_distribution .tb_lib h4{
    font-weight: 800;
    color: #fff;
  }
  .tb_distribution .tb_date{
    color: #fff;
  }
  .tb_distribution .tb_content{
    background-color: rgba(238, 238, 238, 0.7);
    padding: 7px;
    border-radius: 4px;
  }
  .tb_distribution .tb_content .label-primary{
    /*background-color: #676a6f;*/
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
  }
  .tb_distribution .fa-times-circle{
    color: #ec2c58;
    font-size: 16px;
  }
  .tb_distribution .fleche{
    font-size: 23px;
    margin: 0 3px;
    font-weight: 800;
    color: #0073b7;
    display: none;
    cursor: pointer;
  }
  
  .tb_distribution .immat{
    cursor: pointer;
  }
  
  .gros_titre {
    text-align: center;
    color: #fff;
    font-size: 70px;
    font-family: time-new-roman;
  }
  
  .disabled-button, .disabled i, .disabled h4{
    color: #adadad !important;
  }
  .disabled .label.label-primary{
    background-color: #929292 !important;
  }
  .navig{
    font-size: 72px;
    cursor: pointer;
    margin-top: 132px;
    color: #21a9e1;
  }
</style>
<link rel="stylesheet" href="neon/css/fond-sombre.css">
<div class="container">
			<div class="row">
				<div class="col-md-12">
		
		
<script type="text/javascript">
jQuery(document).ready(function($)
{
	
});


function getRandomInt(min, max)
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>
<?php 
  $num_cycle = (is_array(getActifCycle()))? getActifCycle()['ID_CYCLE'] : 1;
  $Cycle_is_exist = getIfElementExist('ID_CYCLE', $num_cycle, 'cycles');
  $actif_jour = ($Cycle_is_exist != 0 && is_array(getActifCycle()))? getActifsJoursByCycle($num_cycle)[0]['NUM_JOUR'] : 1;
?>
<input type="hidden" class="selected_jour" value="<?php echo $actif_jour;  ?>"?>
<div class="row">
    <div class="col-sm-12">
      <h1 class="gros_titre">SY.NA.TRA.C.T</h1>
      <br>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
      <h2 style="text-align:center; color:#fff">Tableau de distribution N° <span class="num_cycle"><?php echo $num_cycle;  ?></h2>
      <br>
    </div>
</div>

<div class="row">
  <div class="col-sm-1" style="text-align:right"><i class="fa fa-chevron-left navig" onclick="goLeft()"></i></div>
	<div class="col-sm-10">
    
				<div class="legende" style="">
          <table style="width:100%"><tr>
              <td>
                <p style="font-size: 17px; color: #fff"><i class="fa fa-check-circle"></i> Camion Opérationnel | <i class="fa fa-times-circle"></i> Camion en maintenance</p>
              </td>
              <td style="text-align:right">
                <?php if (isset($_SESSION['header'])){ ?>
                <a target="_blank" rel="noopener noreferrer" 
                   href="<?php echo '/list-view.php?id_cycle='.$num_cycle.'&num_jour='.$actif_jour.'&with_name=1' ?>">
                  <button class="btn btn-success" style="font-size: 16px" >
                  <i class="entypo-doc-text-inv"></i> Télécharger la liste avec les noms</button>
                </a><br><br>
                <?php } ?>
                <a target="_blank" rel="noopener noreferrer" 
                   href="<?php echo '/list-view.php?id_cycle='.$num_cycle.'&num_jour='.$actif_jour ?>">
                  <button class="btn btn-success" style="font-size: 16px" >
                  <i class="entypo-doc-text-inv"></i> Télécharger la liste des 6 prochains jours</button>
                </a>
              </td>
            </tr></table>
          
				</div>
				<div class="tb_distribution" style="overflow-x: scroll;">
          
				</div>

	</div>
  <div class="col-sm-1" style=""><i class="fa fa-chevron-right navig" onclick="goRight()"></i></div>
  <input type="hidden" class="slide_position" value="0">
  <input type="hidden" class="scroll_position" value="0">
</div>
<script src="modules/tableau/scripts.js"></script>
<script src="neon/scripts-generals.js"></script>
<script src="modules/modals/scripts.js"></script>
<script>
  window.onload = function(){
    remplirAccueil();
  };
</script>
<?php
//  include_once 'modules/camions/modals.php';


