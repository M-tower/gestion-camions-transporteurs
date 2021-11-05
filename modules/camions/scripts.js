function editCamion() {
  var id_transp = $('#id_transp').val();
  var imma_camion = encodeURIComponent($('#imma_camion').val());
  var capacite = encodeURIComponent($('#capacite').val());
        
  if(imma_camion.trim()==""){
    document.getElementById('message').innerHTML = `<p class='alert alert-danger alert-dismissible'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      Vous devez renseigner le numéro d'immatriculation du camion.</p>`;
      notifNO('Vous devez renseigner le numéro d\'immatriculation du camion', 'Erreur de saisie');
  }else if(imma_camion.length != 7){
    document.getElementById('message').innerHTML = `<p class='alert alert-danger alert-dismissible'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      Vous devez renseigner un numéro d'immatriculation correcte au format BA-1234.</p>`;
      notifNO('Vous devez renseigner un numéro d\'immatriculation correcte au format BA-1234.', 'Erreur de saisie');
  }else{
    var action = `action=editCamion&id_transp=${id_transp}&imma_camion=${imma_camion}&capacite=${capacite}`;
      $.post('core/ajax.php',
          action,
          function (returnedData) {  

              console.log('success ' + returnedData);
//              message(returnedData);
              if(returnedData == 1){
                notifOK(opeOK(), 'Camion ajouté');
//                $('#myModalEditCamion input').val('');
                refreshListeCamions(id_transp); 
  $('#imma_camion').addClass('isExistControl');
  $('#imma_camion').val('');
  $('#btnValid_liste').html('Ajouter'); 
          $('#capacite').val('');
              }else if(returnedData == 2){
                notifOK(opeOK(), 'Camion modifié');
//                $('#myModalEditCamion input').val('');
                refreshListeCamions(id_transp); 
  $('#imma_camion').addClass('isExistControl');
  $('#imma_camion').val('');
  $('#btnValid_liste').html('Ajouter'); hideModal('myModalEditCamion');
          $('#capacite').val('');
              }else{
                notifNO('Un problème est rencontré lors de l\'enregistrement : '+returnedData
                        +'. Veuillez reéssayer plus tard');
              }
          });
  }
  return false;
}

function refreshListeCamions(id_transp){
  var t = $('.table-camion').DataTable();
  var rows = t
    .rows()
    .remove();
  var lienAction = 'getAllCamionsById_transp&id_transp='+id_transp;
  $('#chargementTable').css('display', 'block');
  $('.table-camion').css('display', 'none');
//				var suiteMenu = '';
  $.ajax({
      type : 'POST',
      url : 'core/ajax.php',
      data : 'action='+lienAction,
      dataType : 'text',
      success : function (ret) { 
                  var tab = JSON.parse(ret);
                  var u = 0;
                  var ope = 0;
                  var total = tab.length;
                  $('#le_total').html(total);
                  while (u < total) {
                      var json = tab[u];
                      var imma_camion = (json.IMMA_CAMION)? json.IMMA_CAMION: '';
                      var capacite = (json.IMMA_CAMION)? json.CAPACITE: '';
                      var etat = (json.ETAT_CAMION == 1)? 'Opérationnel':'<span style="color:red">En Maintenance</span>';
                      console.log(json.ETAT_CAMION+'--'+json.IMMA_CAMION);
                      if(etat == 'Opérationnel'){ ope++; }
                      t.row.add( [
                          imma_camion,
                          etat,
                          `<div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="entypo-down-open"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                             <li>
                              <a onclick="updateCamion('${imma_camion}')">
                               Modifier
                              </a>
                             </li>
                             <li>
                              <a type="button" style="color: red;" onclick="deleteCamion('${imma_camion}')">
                               Supprimer
                              </a>
                             </li>
                            </ul>
                          </div>`
                      ] ).node().id = imma_camion;
                      u++;
                  }
                  t.draw( false );
                  $('#table-1').addClass('tableauData');
                  $('#chargementTable').css('display', 'none');
                  $('.table-camion').css('display', 'table');
                  $('#le_ope').html(ope);
                  $('#le_maint').html(total-ope);
  }});
  t.on('draw', function(){
    var nbCol = 3;

    for(var a=0; a<nbCol-1; a++){
      $('#table-1 tbody tr').on('click', 'td:eq('+a+')', function () {
        var data = $(this).closest('tr').attr('id');
        showModal('show_camion');
      } );
    }
//    checkboxManager();
//    ($(".table-transporteur thead input[type=checkbox]").is(':checked') || $("#table-1 thead tr label div").css('opacity') == '1') ? cocherTout(true) : ''; 
      $('#chargementTable').css('display', 'none');
      $('#table_1').css('display', 'block');
    });
}

function refreshListeAllCamions(){
  var t = $('.table-camion').DataTable();
  var rows = t
    .rows()
    .remove();
  var lienAction = 'getAllCamions';
  $('#chargementTable').css('display', 'block');
  $('.table-camion').css('display', 'none');
//				var suiteMenu = '';
  $.ajax({
      type : 'POST',
      url : 'core/ajax.php',
      data : 'action='+lienAction,
      dataType : 'text',
      success : function (ret) { 
                  var tab = JSON.parse(ret);
                  var u = 0;
//                  var ope = 0;
                  var total = tab.length;
//                  $('#le_total').html(total);
                  while (u < total) {
                      var json = tab[u];
                      var imma_camion = (json.IMMA_CAMION)? json.IMMA_CAMION: '';
                      var capacite = (json.IMMA_CAMION)? json.CAPACITE: '';
                      var maison = (json.MAISON_TRANSP)? json.MAISON_TRANSP: '';
                      t.row.add( [
                          imma_camion,
                          maison,
                          capacite
                      ] ).node().id = imma_camion;
                      u++;
                  }
                  t.draw( false );
                  $('#table-1').addClass('tableauData');
                  $('#chargementTable').css('display', 'none');
                  $('.table-camion').css('display', 'table');
//                  $('#le_ope').html(ope);
//                  $('#le_maint').html(total-ope);
  }});
//  t.on('draw', function(){
//    var nbCol = 3;
//
//    for(var a=0; a<nbCol-1; a++){
//      $('#table-1 tbody tr').on('click', 'td:eq('+a+')', function () {
//        var data = $(this).closest('tr').attr('id');
//        showModal('show_camion');
//      } );
//    }
////    checkboxManager();
////    ($(".table-transporteur thead input[type=checkbox]").is(':checked') || $("#table-1 thead tr label div").css('opacity') == '1') ? cocherTout(true) : ''; 
//      $('#chargementTable').css('display', 'none');
//      $('#table_1').css('display', 'block');
//    });
}

function updateCamion(imma_camion){
  $('#imma_camion').removeClass('isExistControl');
  $('#imma_camion').val(imma_camion);
  $('#btnValid_liste').html('Modifier');
  $.post('core/ajax.php',
      'action=getCamionByImma_camion&imma_camion=' + imma_camion,
      function (ret) { 
        var retour = JSON.parse(ret);
        if(ret != ''){
          $('#capacite').val(retour.CAPACITE);
        }else{
          notifNO(opeNO(),'Une erreur s\'est produite. '+ret);
        }showModal('myModalEditCamion'); 
  });
}
function deleteCamion(imma_camion){
  $('#message_alert').html('Voulez-vous vraiment supprimer le camion immatriculé <b>'+imma_camion+'</b> de façon définive ? '
  + 'Cette action est irreversible.');
  showModal('myModalConfirmation');
  $('#buttonSendP').attr('onclick', 'suppConfCamion("'+imma_camion+'")');
}

function suppConfCamion(imma_camion){
  $.post('core/ajax.php',
      'action=deleteCamion&imma_camion=' + imma_camion,
      function (ret) {
        if(ret == ''){
          notifOK(opeOK(), "Le camion est supprimé");
          hideModal('myModalConfirmation'); var id_transp = $('#id_transp').val();
          refreshListeCamions(id_transp);
        }else{
          notifNO(opeNO(),'Suppression impossible. '+ret);
        }
  });
}























