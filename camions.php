<?php 
//include "config.php"; ?>
<link rel="stylesheet" href="modules/datatables/styles.css">
<div class="row" id="couleur_entete">

    <!-- Profile Info and Notifications -->
    <div class="col-md-6 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">

            <!-- Raw Notifications -->
            
        </ul>

    </div>
    <div class="col-md-6 clearfix" style="text-align:right">
      <h4 style="margin-top: 10px">LISTE DES CAMIONS</h4>
    </div>
		<style>
			.sup{
				background-color: red;
				color: #fff;
			}
      #couleur_entete{
        padding: 10px 27px;
        background-color: #dee;
        margin-top: -16px;
      }
		</style>
</div>
<div>
    <div class="container" style="margin-top:32px;">
        
        <div class="">
            <div id="wait"></div>
						<div id="chargementTable" style="text-align:center;">
              <h2 style="text-align: center">Chargement...</h2>
							<!--<img src="/img/chargement.gif" width="20%"/>-->
						</div>
            <div id="table_1" class="" >
							
                <table class="table table-camion table-bordered datatable" id="table-1" datatableid="jet1">
                    <thead>
                      <tr>
                        <th style="width: 20%;">Numéro Imm.</th>
                        <th style="width: 60%;">Maison de transp.</th>
                        <th style="width: 20%;">Capacité</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
            <div id="resultJson" style="display:none"></div>
       
    
<script src="modules/datatables/initialisation.js"></script>
<script src="modules/datatables/scripts.js"></script>
<script src="modules/camions/scripts.js"></script>
<script>

window.onload = function(){
     refreshListeAllCamions();
};


 

</script>            
