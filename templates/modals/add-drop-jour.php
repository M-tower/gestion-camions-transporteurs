<?php
?>
<!-- FORMULAIRE DE SUPPRESSION OU D'AJOUT DE JOUR -->
<div id="myModalJour" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close_btn_supp" class="close" onclick="" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" id="titreModalAchat"><?php echo 'Ajouter un jour au tableau'?></h3>
                </div>
                <div class="modal-body">
                    <div id="message_supp"></div>
                    <div id="supp_gif_ach"></div>
                    <input type="hidden"  id="id_jour"  value=""/>
                    <!--<input type="hidden"  id="idClient_supp"  value=""/>-->
                    <div id="message_alert" class="alert alert-warning" >
                    </div>
                </div>
								<div id= "bouton_action">
									<input type="button"  onclick="" id="buttonSendP" class="col-xs-offset-10 btn btn-info"  value="Oui"/>
									<button type="button" class="btn btn-default" onclick="return" data-dismiss="modal"><?php echo 'Non' ?></button>
								</div>
                <div class="modal-footer">

                    <button type="button" id="fermer_btn_supp" class="btn btn-default" onclick="" data-dismiss="modal"><?php echo 'Fermer' ?></button>

                </div>
            </div>
        </form>


    </div>
</div>

