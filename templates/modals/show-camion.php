<?php
?>
<div id="show_camion" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" >&times;</button>
                    <h3 class="modal-title" id="entete_noteShow">Détails concernant le camion</h3>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="col-md-12 col-xs-12">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading" style="background-color:#F0ECDB;">
                                    <div class="panel-title" style="font-size:18px">
                                      <span class="immat_camion">BA-3400</span> programmé sur le 
                                      <span class="date_camion">11/11/2019</span>
                                    </div>
                                </div>
                                <div class="panel-body" style="background-color: #FFFCED;">
                                    <div class="col-sm-12">
                                        <table class="detailTable" style="font-size:14px;">
                                            <tr class="detailTable_tr" style="height: 32px;">
                                              <td style="margin-left:8px;" class="">
                                                <div class="label label-primary" > de : 
                                                  <span class="transporteur_camion">BOUKARI SARL</span></div>
                                              </td>
                                            </tr>
                                            <tr class="detailTable_tr">
                                                <td>Etat :</td>
                                                <td>
                                                  <select name="etat_camion" class="form-control input-lg etat_camion">
                                                    <option value="opérationnel">Opérationnel</option>
                                                    <option value="en maintenance">En maintenance</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>commentaire :</td>
                                                <td>
                                                  <textarea class="form-control comment_camion" name="comment_camion" 
                                                            style="height:150px" placeholder="Rajoutez des détails..."></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .detailTable {
                            width: 100%;
                        }
                        .detailTable_tr{
                            border-bottom: 1px solid #f0ecdb;
                        }
                        .detailTable td{
                            padding: 7px 16px;
                        }
                    </style>
                    <div class="col-md-8 col-md-offset-2 col-xs-12" style="margin-top:16px;">
                      <button type="button" class="btn btn-succes icon-left disabled">
                        <i class="fa fa-save"></i>
                        Enregistrer les modifications
                      </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </form>
    </div>
</div>
