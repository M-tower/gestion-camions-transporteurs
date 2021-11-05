/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function edit() {
  var id_client = $('#id_client').val();    
  var raison_soc_client = encodeURIComponent($('#raison_soc_client').val());
  var adresse_client = encodeURIComponent($('#adresse_client').val());
  var contacts_client = encodeURIComponent($('#contacts_client').val());
  var pays_client = encodeURIComponent($('#pays_client').val());
        
  if(raison_soc_client.trim()==""){
      document.getElementById('message').innerHTML = `<p class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        Des champs requis n'ont pas été remplis : Raison sociale.</p>`;
        notifNO('Des champs requis n\'ont pas été remplis : Raison sociale.', 'Erreur de saisie');
  }else{
    var action = `action=editClient&id_client=${id_client}&raison_soc_client=${raison_soc_client}&adresse_client=${adresse_client}`
            +`&contacts_client=${contacts_client}&pays_client=${pays_client}`;
      $.post('core/ajax.php',
          action,
          function (returnedData) {  

              console.log('success ' + returnedData);
//              message(returnedData);
              if(returnedData == 'oui'){
                $mess = (id_client != -1)? 'Client modifié avec succès' : 'Client ajouté avec succès';
                notifOK(opeOK(), $mess);
                if(id_client != -1){
                  redirection();
                }else{
                  $('#formClient input').val('');
                  $('#id_client').val(-1);
                  $.post('core/ajax.php',
                    'action=getAllClientsLimite&limite=10',
                    function (r) {
                      var tab = JSON.parse(r);
                      var u = 0;
                      var affiche = '';
                      while (u < tab.length) {
                        affiche += tab[u].RAISON_SOC_CLIENT + '<br>';
                        u++;
                      }
                      $('.conteneur-client').html(affiche);
                    });
                }
              }else if(returnedData == 'non'){
                notifNO('Un problème est rencontré lors de l\'enregistrement. Veuillez reéssayer plus tard');
              }else if(returnedData == 'Erreur doublon'){
                var autre = (id_client != -1)? 'autre' : '';
                notifALERT(`Un ${autre} client déjà dans la base se retrouve exactement avec la même raison sociale`, 
                'Risque de doublon');
              }else{
                notifINFO(returnedData, 'Valeur maximale atteinte pour certains champs...');
              }
          });
  }
  return false;
}
function refreshListeClients(){
  var t = $('.table-client').DataTable();
  var rows = t
    .rows()
    .remove();
  var lienAction = 'getAllClients';
  $('#chargementTable').css('display', 'block');
  $('.table-client').css('display', 'none');
//				var suiteMenu = '';
  $.ajax({
      type : 'POST',
      url : 'core/ajax.php',
      data : 'action='+lienAction,
      dataType : 'text',
      success : function (ret) { 
//        console.log('----'+ret)
                  var tab = JSON.parse(ret);
                  var u = 0;
                  while (u < tab.length) {
                      var json = tab[u];
                      var id_client = (json.ID_CLIENT)? json.ID_CLIENT: '';
                      var raison_soc_client = (json.RAISON_SOC_CLIENT)? json.RAISON_SOC_CLIENT : '';
                      var adresse_client = (json.ADRESSE_CLIENT)? json.ADRESSE_CLIENT : '';
//                      var camions = (json.CAMIONS)? json.CAMIONS : '';
                      var contacts_client = (json.CONTACTS_CLIENT)? json.CONTACTS_CLIENT: '';
                      t.row.add( [
                          `<div class="checkbox color-blue checkbox-replace neon-cb-replacement">
                            <label class="cb-wrapper">
                              <input type="checkbox" id="chk-1"><div class="checked"></div>
                            </label>
                          </div>`,
                          id_client,
                          raison_soc_client,
                          adresse_client,
                          contacts_client,
                          `<div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="entypo-down-open"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                             <li>
                              <a href="/?page=edit-client&id=${id_client}" >
                               Modifier
                              </a>
                             </li>
                             <li>
                              <a id="supprimer" type="button" style="color: red;"
                                onclick="deleteClient(${id_client},'${slasher(raison_soc_client)}')">
                               Supprimer
                              </a>
                             </li>
                            </ul>
                          </div>`
                      ] ).node().id = id_client;
                      u++;
                  }
                  t.draw( false );
                  $('#table-1').addClass('tableauData');
                  $('#chargementTable').css('display', 'none');
                  $('.table-client').css('display', 'table');
  }});
  t.on('draw', function(){
    var nbCol = 6;

    for(var a=1; a<nbCol-1; a++){
      $('#table-1 tbody tr').on('click', 'td:eq('+a+')', function () {
        var data = $(this).closest('tr').attr('id');
        goTo('fiche-client',data);
      } );
    }
    checkboxManager();
    ($(".table-client thead input[type=checkbox]").is(':checked') || $("#table-1 thead tr label div").css('opacity') == '1') ? cocherTout(true) : ''; 
      $('#chargementTable').css('display', 'none');
      $('#table_1').css('display', 'block');
    });
}

function deleteClient(id,nom){
  $('#message_alert').html('Voulez-vous vraiment supprimer le client <b>'+nom+'</b> de façon définive ? ');
  showModal('myModalConfirmation');
  var p_courant = lapage();
  $('#buttonSendP').attr('onclick', 'suppConfClient('+id+',\''+p_courant+'\')');
}

function deleteGroupClient(){
  var lesRows = $('#table-1 tbody tr.highlight');
  if(lesRows.length == 0){
    notifNO('Vous devez sélectionner une ligne au moins pour effectuer cette action', 
    'Aucun élément sélectionné pour la suppression');
    return;
  }
  var arrId = new Array();
  var taille = lesRows.length;
  var s = (taille > 1)? 's' : '';
//  var ses = (taille > 1)? 'leurs' : 'ses';
  for(var i=0; i< taille; i++){
   arrId.push(lesRows.eq(i).attr('id'));
  }
  $('#id_supp').val(arrId);
  $('#message_alert').html('Voulez-vous vraiment supprimer ce'+s+' '+taille+' client'+s+' de façon définive ? ');
  showModal('myModalConfirmation');
  $('#buttonSendP').attr('onclick', 'suppGroupConfClient()');
}

function suppConfClient(id, b=false){
  $.post('core/ajax.php',
      'action=deleteClient&id_client=' + id,
      function (ret) {
        if(ret == ''){
          notifOK(opeOK(), "Le client est supprimé");
          hideModal('myModalConfirmation');
          if(b == 'fiche-client'){
            goTo('clients');
          }else{
            refreshListeClients();
          }
        }else{
          notifNO(opeNO(),'Suppression impossible. '+ret);
        }
  });
}

function suppGroupConfClient(){
  var id = $('#id_supp').val();
  $.post('core/ajax.php',
      'action=deleteGroupClient&ids=' + id,
      function (ret) {
        if(ret == ''){
          notifOK(opeOK(), "Action effectuée!");
          hideModal('myModalConfirmation');
          refreshListeClients();
        }else{
          notifNO(opeNO(),'Suppression impossible. '+ret);
        }
  });
}



