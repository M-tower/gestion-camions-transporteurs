/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function edit() {
  var id_transp = $('#id_transp').val();    
  var maison_transp = encodeURIComponent($('#maison_transp').val());
  var dirigeant_transp = encodeURIComponent($('#dirigeant_transp').val());
  var adresse_transp = encodeURIComponent($('#adresse_transp').val());
  var mail_transp = $('#mail_transp').val();
  var lat_transp = $('#lat_transp').val();
  var lng_transp = $('#lng_transp').val();
  var contacts_transp = encodeURIComponent($('#contacts_transp').val());
        
  if(maison_transp.trim()=="" || dirigeant_transp.trim()==""){
      document.getElementById('message').innerHTML = `<p class='alert alert-danger alert-dismissible'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        Des champs requis n'ont pas été remplis.</p>`;
        notifNO('Des champs requis n\'ont pas été remplis', 'Erreur de saisie');
  }else{
    var action = `action=editTransporteur&id_transp=${id_transp}&maison_transp=${maison_transp}&dirigeant_transp=${dirigeant_transp}`
        +`&adresse_transp=${adresse_transp}&mail_transp=${mail_transp}&lat_transp=${lat_transp}`
            +`&lng_transp=${lng_transp}&contacts_transp=${contacts_transp}`;
      $.post('core/ajax.php',
          action,
          function (returnedData) {  

              console.log('success ' + returnedData);
//              message(returnedData);
              if(returnedData == 'oui'){
                $mess = (id_transp != -1)? 'Transporteur modifié avec succès' : 'Transporteur ajouté avec succès';
                notifOK(opeOK(), $mess);
                if(id_transp != -1){
                  redirection();
                }else{
                  $('#formClient input').val('');
                  $('#id_transp').val(-1);
                  $.post('core/ajax.php',
                    'action=getAllTransporteursLimite&limite=10',
                    function (r) {
                      var tab = JSON.parse(r);
                      var u = 0;
                      var affiche = '';
                      while (u < tab.length) {
                        affiche += tab[u].MAISON_TRANSP + '<br>';
                        u++;
                      }
                      $('.conteneur-transp').html(affiche);
                    });
                }
              }else if(returnedData == 'non'){
                notifNO('Un problème est rencontré lors de l\'enregistrement. Veuillez reéssayer plus tard');
              }else if(returnedData == 'Erreur doublon'){
                var autre = (id_transp != -1)? 'autre' : '';
                notifALERT(`Un ${autre} transporteur déjà dans la base se retrouve exactement avec la même maison de transport`, 
                'Risque de doublon');
              }else{
                notifINFO(returnedData, 'Valeur maximale atteinte pour certains champs...');
              }
          });
  }
  return false;
}
function refreshListeTransporteurs(){
  var t = $('.table-transporteur').DataTable();
  var rows = t
    .rows()
    .remove();
  var lienAction = 'getAllTransporteurs';
  $('#chargementTable').css('display', 'block');
  $('.table-transporteur').css('display', 'none');
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
                      var id_transp = (json.ID_TRANSP)? json.ID_TRANSP: '';
                      var maison = (json.MAISON_TRANSP)? json.MAISON_TRANSP : '';
                      var dirigeant = (json.DIRIGEANT_TRANSP)? json.DIRIGEANT_TRANSP : '';
//                      var camions = (json.CAMIONS)? json.CAMIONS : '';
                      var camions = (json.NB_CAMIONS)? json.NB_CAMIONS: '';
                      t.row.add( [
                          `<div class="checkbox color-blue checkbox-replace neon-cb-replacement">
                            <label class="cb-wrapper">
                              <input type="checkbox" id="chk-1"><div class="checked"></div>
                            </label>
                          </div>`,
                          id_transp,
                          maison,
                          dirigeant,
                          camions,
                          `<div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="entypo-down-open"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                             <li>
                              <a href="/?page=edit-transporteur&id=${id_transp}" >
                               Modifier
                              </a>
                             </li>
                             <li>
                              <a id="supprimer" type="button" style="color: red;"
                                onclick="deleteTransporteur(${id_transp},'${slasher(maison)}')">
                               Supprimer
                              </a>
                             </li>
                            </ul>
                          </div>`
                      ] ).node().id = id_transp;
                      u++;
                  }
                  t.draw( false );
                  $('#table-1').addClass('tableauData');
                  $('#chargementTable').css('display', 'none');
                  $('.table-transporteur').css('display', 'table');
  }});
  t.on('draw', function(){
    var nbCol = 6;

    for(var a=1; a<nbCol-1; a++){
      $('#table-1 tbody tr').on('click', 'td:eq('+a+')', function () {
        var data = $(this).closest('tr').attr('id');
        goTo('fiche-transporteur',data);
      } );
    }
    checkboxManager();
    ($(".table-transporteur thead input[type=checkbox]").is(':checked') || $("#table-1 thead tr label div").css('opacity') == '1') ? cocherTout(true) : ''; 
      $('#chargementTable').css('display', 'none');
      $('#table_1').css('display', 'block');
    });
}

function deleteTransporteur(id,nom){
  $('#message_alert').html('Voulez-vous vraiment supprimer le transporteur <b>'+nom+'</b> de façon définive ? '
  + 'Sa suppression entrainera aussi celles de toutes ses éventuels camions.<br>'
  + '<b>La modification ne prendra effet que sur les prochains cycles enregistrés.</b>');
  showModal('myModalConfirmation');
  var p_courant = lapage();
  $('#buttonSendP').attr('onclick', 'suppConfTransporteur('+id+',\''+p_courant+'\')');
}

function deleteGroupTransporteur(){
  var lesRows = $('#table-1 tbody tr.highlight');
  if(lesRows.length == 0){
    notifNO('Vous devez sélectionner une ligne au moins pour effectuer cette action', 
    'Aucun élément sélectionné pour la suppression');
    return;
  }
  var arrId = new Array();
  var taille = lesRows.length;
  var s = (taille > 1)? 's' : '';
  var ses = (taille > 1)? 'leurs' : 'ses';
  for(var i=0; i< taille; i++){
   arrId.push(lesRows.eq(i).attr('id'));
  }
  $('#id_supp').val(arrId);
  $('#message_alert').html('Voulez-vous vraiment supprimer ce'+s+' '+taille+' transporteur'+s+' de façon définive ? '
  + 'la suppression entrainera aussi celles de toutes '+ses+' éventuels camions.');
  showModal('myModalConfirmation');
  $('#buttonSendP').attr('onclick', 'suppGroupConfTransporteur()');
}

function suppConfTransporteur(id, b=false){
  $.post('core/ajax.php',
      'action=deleteTransporteur&id_transp=' + id,
      function (ret) {
        if(ret == ''){
          notifOK(opeOK(), "Le transporteur est supprimé");
          hideModal('myModalConfirmation');
          if(b == 'fiche-transporteur'){
            goTo('transporteurs');
          }else{
            refreshListeTransporteurs();
          }
        }else{
          notifNO(opeNO(),'Suppression impossible. '+ret);
        }
  });
}

function suppGroupConfTransporteur(){
  var id = $('#id_supp').val();
  $.post('core/ajax.php',
      'action=deleteGroupTransporteur&ids=' + id,
      function (ret) {
        if(ret == ''){
          notifOK(opeOK(), "Action effectuée!");
          hideModal('myModalConfirmation');
          refreshListeTransporteurs();
        }else{
          notifNO(opeNO(),'Suppression impossible. '+ret);
        }
  });
}



