<?php
?>
<div id="myModalEditCamion" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form>
        <div class="modal-content">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Ajouter/Editer un camion</h3>
            </div>
            <div class="modal-body">
              <div style="padding:16px 16px 4px 16px;background-color:#D9EDF7;color:#4c7793;margin-bottom:16px;">
               <p style="font-size:13px; text-align:center;">
                   <i class="entypo-info" style="font-size:18px;color:#4c7793;"></i><br>
                   <span id="leMessage">
                    Les champs marqués * sont obligatoires
                   </span><br>
               </p>
               <p id="msgError">

               </p>
              </div>
              <br>
              <div class="row" style="margin-bottom: 17px">
               <div class="form-group">
                  <label class="col-md-4 control-label" style="text-align:left;">Immatriculation *</label>
                  <div class="col-md-8 margin-b-7">
                      <input type="text" name="imma_camion" id="imma_camion" class="form-control input-lg isExistControl required" 
                       placeholder="ex: BA-3400" data-mask="AA-9999" data-toggle="tooltip" data-placement="top"
                      title="" data-original-title="" existControlUrl="camionIsExist" onkeyup="isExist(this.id, 'camionIsExist')">
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-md-4 col-xs-12 control-label" style="text-align:left;">Capacité</label>
                  <div class="col-md-8 col-xs-12 margin-b-7">
                    <input type="text" name="capacite" id="capacite" class="form-control input-lg" placeholder="(Facultatif)"
                    value="" />
                    <input type="hidden" id="id_transp" value="<?php echo $soc->ID_TRANSP(); ?>" />
                  </div>
               </div>
              </div>
              <button id="btnValid_liste" onclick="return editCamion()" class="btn btn-info sender">Ajouter</button>
            </div>
            <div class="modal-footer">
             <div class="col-md-8"></div>
             <div class="col-md-4">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
             </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

