<?php 
//include "config.php"; ?>
<link rel="stylesheet" href="modules/datatables/styles.css">
<div class="row" id="couleur_entete">

    <!-- Profile Info and Notifications -->
    <div class="col-md-6 clearfix">
        <ul class="user-info pull-left pull-right-xs pull-none-xsm">

            <!-- Raw Notifications -->
            <div class="btn-group">
                <a href="/?page=edit-transporteur">
                    <button type="button" class="btn btn-blue btn-icon icon-lef btn-lg">
                        Nouveau transporteur
                        <i class="entypo-user-add"></i>
                    </button>
                </a>
            </div>
        </ul>
    </div>
    <div class="col-md-6 clearfix" style="text-align:right">
      <h4 style="margin-top: 10px">LISTE DES TRANSPORTEURS</h4>
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
            <div id="table_1" class="" style="display:none">
							<div class="row">
									<div class="col-md-2"><label class="control-label" style="margin-top: 7px;">Action groupée</label></div>
									<div class="col-md-10 alignRight">
										<button type="button" class="btn btn-red btn-supp-group " onclick="deleteGroupTransporteur()">Supprimer la sélection</button>
									</div>
							</div>
                <table class="table table-transporteur table-bordered datatable" id="table-1" datatableid="jet1">
                    <thead>
                      <tr>
                        <th style="width: 5%;">
                          <div class="checkbox color-blue checkbox-replace">
                            <input type="checkbox" id="chk-1">
                          </div>
                        </th>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 30%;">Maison de transp.</th>
                        <th style="width: 30%;">Dirigeant</th>
                        <th style="width: 20%;">Camions</th>
                        <th style="width: 10%;" id="espaceDif"><center>Actions</center></th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
            <div id="resultJson" style="display:none"></div>
       
    

<?php 
include "templates/modals/suppression.php"; ?>
<!--<script src="modules/listes/scripts.js"></script>-->  
<!--<script src="modules/clients/scripts.js"></script>-->
<script src="modules/datatables/initialisation.js"></script>
<script src="modules/datatables/scripts.js"></script>
<script src="modules/transporteurs/scripts.js"></script>
<script src="modules/modals/scripts.js"></script>
<script>

window.onload = function(){
     refreshListeTransporteurs();
}

$(document).ready(function() {
	
});

 

</script>            
