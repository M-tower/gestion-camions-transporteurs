function switchTo(a,position){
  var jour = a.split('-')[0];
 if(!$('.table-'+jour).hasClass('disabled')){ 
  var ligne = a.split('-')[1];
  var jour_suiv = parseInt(jour) + 1;
  var ligne_suiv = parseInt(ligne) + 1;
  var jour_prec = parseInt(jour) - 1;
  var ligne_prec = parseInt(ligne) - 1;
  if(position == 'right'){
    var next_box_id = '';
    if($('#'+jour_suiv+'-'+ligne).length === 0){
      /* on tente un retour à la ligne suivante */
      if($('#1-'+ligne_suiv).length === 0){
        notifNO('Fin du tableau!', 'Action non autorisée!');
        console.log('#'+jour_suiv+'-'+ligne);
        return;
      }
      next_box_id = '#1-'+ligne_suiv;
    }else{
      next_box_id = '#'+jour_suiv+'-'+ligne;
    }
    if(next_box_id != ''){
      var current_cont = $('#'+a+' .elt_box').html();
      var current_imma = $('#'+a+' .elt_box').attr('imma');
      var current_etat = $('#'+a+' .elt_box').attr('etat');
      var next_cont = $(next_box_id+' .elt_box').html();
      var next_imma = $(next_box_id+' .elt_box').attr('imma');
      var next_etat = $(next_box_id+' .elt_box').attr('etat');
      $(next_box_id+' .elt_box').html(current_cont);
      $(next_box_id+' .elt_box').attr('imma',current_imma);
      $(next_box_id+' .elt_box').attr('etat',current_etat);
      $(next_box_id).addClass('select-col');
      $('#'+a+' .elt_box').html(next_cont);
      $('#'+a+' .elt_box').attr('imma',next_imma);
      $('#'+a+' .elt_box').attr('etat',next_etat);
      $('#'+a).removeClass('select-col');
    }
  }else{
   if(!$('.table-'+jour_prec).hasClass('disabled')){ 
    var prec_box_id = '';
    if($('#'+jour_prec+'-'+ligne).length === 0){
      if(ligne == 1){
        notifNO('Debut du tableau atteint!', 'Action non autorisée!');
        console.log('#'+jour_prec+'-'+ligne);
        return;
      }
      var last_day = $('#last_day').val();
      prec_box_id = '#'+last_day+'-'+ligne_prec;
    }else{
      prec_box_id = '#'+jour_prec+'-'+ligne;
    }
    var current_cont = $('#'+a+' .elt_box').html();
    var current_imma = $('#'+a+' .elt_box').attr('imma');
    var current_etat = $('#'+a+' .elt_box').attr('etat');
    var prec_cont = $(prec_box_id+' .elt_box').html();
    var prec_imma = $(prec_box_id+' .elt_box').attr('imma');
    var prec_etat = $(prec_box_id+' .elt_box').attr('etat');
    $(prec_box_id+' .elt_box').html(current_cont);
    $(prec_box_id+' .elt_box').attr('imma', current_imma);
    $(prec_box_id+' .elt_box').attr('etat', current_etat);
    $(prec_box_id).addClass('select-col');
    $('#'+a+' .elt_box').html(prec_cont);
    $('#'+a+' .elt_box').attr('imma', prec_imma);
    $('#'+a+' .elt_box').attr('etat', prec_etat);
    $('#'+a).removeClass('select-col');
   }else{
    notifNO('Vous ne pouvez pas échanger des camions avec des jours désactivés!', 'Action impossible');
   }
  }
  }
  return;
}

function switchEtat(a){
  if(!$(a).closest('table').hasClass('disabled')){ 
  $(a).toggleClass('fa-check-circle');
  $(a).toggleClass('fa-times-circle');
  var etat = $(a).closest('div.elt_box').attr('etat');
  if(etat == 'Opérationnel'){
    $(a).closest('div.elt_box').attr('etat', 'En maintenance');
  }else{
    $(a).closest('div.elt_box').attr('etat', 'Opérationnel');
  }
  }
  doly();
  nombreCamionsMaintenance();
  return;
}

function remplir(jr_ajoute=0){
var cycle_exist = parseInt($('.cycle_exist').val());
if(jr_ajoute != 0){
  var old = parseInt($('.jr_ajoute').val());
  jr_ajoute = old + jr_ajoute;
  $('.jr_ajoute').val(jr_ajoute);
}
var surplus = '&jr_ajoute='+jr_ajoute;
var action = 'action=remplirParDefaut'+surplus;
var id_cycle = parseInt($('.num_cycle').html());
if(cycle_exist == 1){
  action = 'action=remplir&id_cycle='+id_cycle+surplus;
}
  $.post('core/ajax.php',
    action,
    function(ret){
//      console.log('->'+ret);
      var r = JSON.parse(ret);
      var cont = '';
      var jour_actif = parseInt($('.selected_jour').val());
//      var a = 1;
//      console.log('->'+r.length);
      var a = 1;
      var dis = 0;
      var all_cam = 0;
      for(a in r){
        var actif = (jour_actif == a)? 'actif' : '';
        var desactive = (a < jour_actif)? 'disabled' : '';
        cont += `<table class="${actif} ${desactive} table-${a}" num-jour="${a}">
          <tr>
            <td class="tb_lib tb_date" onclick=""><h4>Jour ${a}</h4></td>
          </tr>`;
        var j = r[a];
        var num = 1;
        var u = 1; var id_client = 1;
        for(u in j){
          let maison = j[u].MAISON_TRANSP;
          let imma = j[u].IMMA_CAMION;
          let contacts = j[u].CONTACTS_TRANSP;
          let etat = (j[u].ETAT_SERV == 'Opérationnel' || !j[u].ETAT_SERV)? 'fa-check-circle' : 'fa-times-circle';
          if(etat == 'fa-times-circle'){ dis += 1;}
          cont +=`<tr  id="${a}-${num}">
            <td class="tb_content">
              <div class="elt_box" maison="${maison}" contacts="${contacts}" imma="${imma}" etat="${(j[u].ETAT_SERV)? j[u].ETAT_SERV : 'Opérationnel'}">
                <div class="label label-primary" 
                     data-toggle="tooltip" data-placement="top" title="" data-original-title="${maison}">${couperTexte(maison,10)}</div>
                <p><i class="fa ${etat}" onclick="switchEtat(this)"></i> <span class="immat">${imma}</span></p>
              </div>
              <div class="fleche_box">
                <i class="fa fa-chevron-circle-left fleche" onclick="switchTo(\'${a}-${num}\', \'left\')"></i>  
                <i class="fa fa fa-chevron-circle-right fleche" onclick="switchTo(\'${a}-${num}\', \'right\')"></i>
              </div>
            </td>
          </tr>`;
          num++;
          id_client = (j[u].ID_CLIENT)? j[u].ID_CLIENT : '';
          u++;
          all_cam++;
        }
        cont += '</table>';
        a++;
      }
//      console.log('-->'+cont);
//      ajout du box pour le jour de plus
      $('.tb_distribution').html(cont);
      $('.nb_jour').html(a-1);
      $('.nb_jour_field').val(a-1);
      $('.client_select').val(id_client);
      $('.numb-maint').html(dis);
      $('.all_cam').html(all_cam);
      if(id_client != ''){
       $('.client_select').attr('disabled', 'true');
      }
      tooltip_script();
      if(jr_ajoute != 0){
       notifOK('Opération réussie', 'Nombre de jours modifié!');
       hideModal('myModalJour');
       goEnd();
      }
    }
  );
}
function remplirHistorique(){
var id_cycle = $('.cycle_select').val();
if(id_cycle == 0){
 $('.tb_distribution').html('<h3 style="text-align:center">Aucun contenu disponible pour le moment...</h3>');
 return;
}
var surplus = '&jr_ajoute=0';
var action = 'action=remplir&id_cycle='+id_cycle+surplus;
  $.post('core/ajax.php',
    action,
    function(ret){
//      console.log('->'+ret);
      var r = JSON.parse(ret);
      var cont = '';
//      var jour_actif = parseInt($('.selected_jour').val());
//      var a = 1;
//      console.log('->'+r.length);
      var a = 1;
      for(a in r){
        var desactive = 'disabled';
        cont += `<table class="${desactive} table-${a}" num-jour="${a}">
          <tr>
            <td class="tb_lib tb_date" onclick=""><h4>Jour ${a}</h4></td>
          </tr>`;
        var j = r[a];
        var num = 1;
        var u = 1; var id_client = 1;
        for(u in j){
          let maison = j[u].MAISON_TRANSP;
          let imma = j[u].IMMA_CAMION;
          let etat = (j[u].ETAT_SERV == 'Opérationnel' || !j[u].ETAT_SERV)? 'fa-check-circle' : 'fa-times-circle';
          cont +=`<tr  id="${a}-${num}">
            <td class="tb_content">
              <div class="elt_box" imma="${imma}" etat="${(j[u].ETAT_SERV)? j[u].ETAT_SERV : 'Opérationnel'}">
                <div class="label label-primary" 
                     data-toggle="tooltip" data-placement="top" title="" data-original-title="${maison}">${couperTexte(maison,10)}</div>
                <p><i class="fa ${etat}" onclick="switchEtat(this)"></i> <span class="immat">${imma}</span></p>
              </div>
              <div class="fleche_box">
                <i class="fa fa-chevron-circle-left fleche" onclick="switchTo(\'${a}-${num}\', \'left\')"></i>  
                <i class="fa fa fa-chevron-circle-right fleche" onclick="switchTo(\'${a}-${num}\', \'right\')"></i>
              </div>
            </td>
          </tr>`;
          num++;
          id_client = (j[u].ID_CLIENT)? j[u].ID_CLIENT : '';
          u++;
        }
        cont += '</table>';
        a++;
      }
//      console.log('-->'+cont);
//      ajout du box pour le jour de plus
      $('.tb_distribution').html(cont);
      $('.nb_jour').html(a-1); 
      tooltip_script();
    }
  );
}
function remplirAccueil(){
//var cycle_exist = $('.cycle_exist').val(); var action = 'action=remplirParDefaut';
//var id_cycle = parseInt($('.num_cycle').html());
  action = 'action=remplirAccueil';
  $.post('core/ajax.php',
    action,
    function(ret){
//      console.log('->'+ret);
      var r = JSON.parse(ret);
      var cont = '';
      var jour_actif = parseInt($('.selected_jour').val());
//      var a = 1;
//      console.log('->|'+typeof(jour_actif));
      var a = 1;
      for(a in r){
        var actif = (jour_actif == a)? 'actif' : '';
        var desactive = (a < jour_actif)? 'disabled' : '';
        cont += `<table class="${actif} ${desactive}">
          <tr>
            <td class="tb_lib tb_date"><h4>Jour ${a}</h4></td>
          </tr>`;
        var j = r[a];
        var num = 1;
        var u = 1;
        for(u in j){
          let maison = j[u].MAISON_TRANSP;
          let imma = j[u].IMMA_CAMION;
          let etat = (j[u].ETAT_SERV == 'Opérationnel' || !j[u].ETAT_SERV)? 'fa-check-circle' : 'fa-times-circle';
          cont +=`<tr  id="${a}-${num}">
            <td class="tb_content">
              <div class="elt_box" imma="${imma}" etat="${(j[u].ETAT_SERV)? j[u].ETAT_SERV : 'Opérationnel'}">
                <div class="label label-primary" 
                     data-toggle="tooltip" data-placement="top" title="" data-original-title="${maison}">${couperTexte(maison,10)}</div>
                <p><i class="fa ${etat}"></i> <span class="immat">${imma}</span></p>
              </div>
            </td>
          </tr>`;
          num++;
          u++;
        }
        cont += '</table>';
        a++;
      }
//      console.log('-->'+cont);
      $('.tb_distribution').html(cont);
      tooltip_script();
    }
  );
}
function saveTout(){
var client = $('.client_select').val();
  if(client == ''){
    notifNO('Vous devez d\'abord choisir un client en haut du tableau.','Client manquant');
    return;
  }
var id_cycle = parseInt($('.num_cycle').html());
var nb_jour = parseInt($('.nb_jour').html());
var cycle_exist = $('.cycle_exist').val();
var jour_actif = $('.selected_jour').val();console.log('->'+jour_actif);
if(cycle_exist == 0){
$.post('core/ajax.php',
`action=saveCycleNJours&nb_jour=${nb_jour}&jour_actif=${jour_actif}`,
function(r){
if(parseInt(r)>0){ console.log('-->'+r); 
saveTable(r);
}else{
notifNO('Une erreur s\'est produite', 'ERREUR');
}
}
);
}else{
$.post('core/ajax.php',
`action=updateCycleNJours&nb_jour=${nb_jour}&jour_actif=${jour_actif}&id_cycle=${id_cycle}`,
function(r){
if(r != ''){
RemplaceOldContent(id_cycle);
}else{
notifNO('Une erreur s\'est produite : '+r, 'ERREUR');
}
});
}
}
 
function RemplaceOldContent(id_cycle){
$.post('core/ajax.php',
`action=deleteAllServiresByCycle&id_cycle=${id_cycle}`,
function(r){ 
 if(r == 1){          
 saveTable(id_cycle);
 }else{notifNO('Une erreur s\'est produite', 'ERREUR'); } }
);
}
 
function saveTable(id_cycle){
  var client = $('.client_select').val();
  var retour = '';
  var les_b = $('.elt_box');
  var coll = [];
  for(var i=0; i<les_b.length; i++){
    var tr = $(les_b[i]).closest('tr').attr('id');
    var jour = tr.split('-')[0];
    var ligne = tr.split('-')[1];
//    var id_cycle = parseInt($('.num_cycle').html());
    var imma_camion = $(les_b[i]).attr('imma');
    var maison_transp = $(les_b[i]).attr('maison');
    var contacts_transp = $(les_b[i]).attr('contacts');
    var etat_serv = $(les_b[i]).attr('etat');
    var obj = {
    imma_camion : imma_camion,
    id_client: client,
    num_jour: jour,
    id_cycle: id_cycle,
    etat_serv: etat_serv,
    maison_transp: maison_transp,
    contacts_transp: contacts_transp,
    commentaire_serv: '',
    ligne_serv: ligne
    };

    coll.push(obj);
//    console.log(imma_camion);
  }
  //console.log(JSON.stringify(coll));
  //return;
  $.post('core/ajax.php',
            `action=addMultipleServire&coll=${JSON.stringify(coll)}`,
            function(r){
                if(r != ''){ 
                  console.log(r); 
                }else{ 
                console.log('ok'); 
                }retour = r;
              }
            );
  if(retour == ''){
 notifOK('Tableau enregistré avec succès', 'Opération réuissie');
 $('.cycle_exist').val(1);
 $('.num_cycle').html(id_cycle);
 noDoly();
  }
}
function JourSuiv(){              
 var num = parseInt($('.actif').attr('num-jour'));
 var num_suiv = num + 1;
 var old_actif = $('.actif');             
 var next_actif = $('.table-'+num_suiv);    //console.log(num + '...' + num_suiv);
 if(next_actif.length > 0){
  $('.actif i').addClass('disabled-button');
  $('.actif .tb_lib h4').addClass('disabled-button');
  old_actif.addClass('disabled');
  $('table').removeClass('actif');
  next_actif.addClass('actif');
  $('.selected_jour').val(num_suiv);
 }else{
//  notifNO('Dernier jour atteint!', 'Action impossible');
  var cycle_exist = $('.cycle_exist').val();
  if(cycle_exist == 1){
   showModal('myModalGoNextCycle');
  }else{
   notifNO('Fin du tableau atteint!', 'Action non autorisée');
  }
 }
 doly();
}
function JourPrec(){              
 var num = parseInt($('.actif').attr('num-jour'));
 var num_prec = num - 1;
// var old_actif = $('.actif');             
 var prec_actif = $('.table-'+num_prec);    //console.log(num + '...' + num_suiv);
 if(prec_actif.length > 0){
  $('table').removeClass('actif');
  prec_actif.removeClass('disabled');
  prec_actif.addClass('actif');
  $('.actif i').removeClass('disabled-button');
  $('.actif .tb_lib h4').removeClass('disabled-button');
  $('.selected_jour').val(num_prec);
 }else{
  notifNO('Premier jour atteint!', 'Action impossible');
 }
 doly();
}
              
              
function doly(){              
 $('.mess-alert-save').css('display', 'inline');
}
              
function noDoly(){              
 $('.mess-alert-save').css('display', 'none');
}
function goRight() {
  var b = $( '.tb_distribution table' ).width();
  var page = lapage();
  var panneau = (page == 'dashbord' || page == 'historique-cycles') ? 'panel-body':'tb_distribution';
  var panel = $( 'div.'+panneau ).width();
  var pos = parseInt($('.slide_position').val());
  var nb_show = (pos == 0)? (panel % b) : pos;
  var old_scroll_pos = parseInt($('.scroll_position').val());
  var scroll_pos = $( 'div.'+panneau ).scrollLeft();
var valeur = ((old_scroll_pos == scroll_pos) && old_scroll_pos != 0)? scroll_pos : nb_show + b;
        console.log(valeur +'--'+ scroll_pos);
//  $( 'div.'+panneau ).scrollLeft(nb_show - b);
  $('.slide_position').val(valeur);
  if((old_scroll_pos < scroll_pos) || old_scroll_pos==0){ $('.scroll_position').val(scroll_pos);}
  $('div.'+panneau).animate( { scrollLeft: (valeur) }, 100, 'linear' );
}
function goLeft() {
  var b = $( '.tb_distribution table' ).width();
  var page = lapage();
  var panneau = (page == 'dashbord' || page == 'historique-cycles') ? 'panel-body':'tb_distribution';
  var panel = $( 'div.'+panneau ).width();
  var pos = parseInt($('.slide_position').val());
  var nb_show = (pos == 0)? (panel % b) : pos;
  var valeur = ((nb_show - b)<0)? 0 : nb_show - b;
  $('.slide_position').val(valeur);
  $('div.'+panneau).animate( { scrollLeft: (valeur) }, 100, 'linear' );
}
function goEnd() {
  var old_scroll = $('.scroll_position').val();
//  var b = $( '.tb_distribution table' ).width();
  $('.slide_position').val(0);
  var nb_jour = parseInt($('.nb_jour').html());
  var time = 0;
  for(var i=0; i<nb_jour; i++){
    goRight();
    time += 100;
  }
  setTimeout(function () {
    //       répétition de l'action dans goRight() pour permettre de repartir
    var scroll_pos = $( 'div.panel-body' ).scrollLeft();
    if(scroll_pos == old_scroll){
//     si la bar n'a pas bougé. ceci se produit quand on ajout un jour en étant déjà à la fin du tableau
     $('.scroll_position').val(old_scroll-1);
    }else if(scroll_pos > old_scroll){
     $('.scroll_position').val(scroll_pos);
    }
    $('.slide_position').val(scroll_pos);
    goRight();
  }, time);
}
              
function addJour(a){      
 var sel_jour = parseInt($('.selected_jour').val());
 var nb_jour = parseInt($('.nb_jour').html());
 var diff = (a - nb_jour);
 if(sel_jour > 1){
  notifNO('Cette action ne peut être accomplie car le cycle contient des jours désactivés');
  return;
 }else if(a < 3){
  notifNO('Cette action ne peut être accomplie car le nombre de jours ne peut être inférieur à 3');
  return;
 }
 $('#myModalJour #message_alert').html('Voulez-vous vraiment effectuer cette action? <br>'
 +'Cela pourrait provoquer d\'importants décalages dans la disposition des camions');  
 $('#myModalJour #titreModalAchat').html('Ajouter un jour à la fin du tableau');  
 $('#myModalJour #buttonSendP').attr('onclick', 'remplir('+diff+')');
 showModal('myModalJour');
}
              
function dropJour(){ /* Deprecated */
 var sel_jour = parseInt($('.selected_jour').val());
 if(sel_jour > 1){
  notifNO('Cette action ne peut être accomplie car le cycle contient des jours désactivés');
  return;
 }
 $('#myModalJour #message_alert').html('Voulez-vous vraiment effectuer cette action? <br>'
 +'Cela pourrait provoquer d\'importants décalages dans la disposition des camions');  
 $('#myModalJour #titreModalAchat').html('Retirer un jour à la fin du tableau');
 $('#myModalJour #buttonSendP').attr('onclick', 'remplir(-1)');
 showModal('myModalJour');
}
function nextCycle(){
 var id_cycle = parseInt($('.num_cycle').html());
 var option = 'action=desactiveLastCycle&id_cycle='+id_cycle;
 $.post('core/ajax.php', option,
  function(r){
   if(r==1){
    console.log('OK');
    $('.cycle_exist').val(0);
    $('.selected_jour').val(1);
    $('.tb_distribution').html('');
    $('.client_select').removeAttr('disabled');
    remplir();
    hideModal('myModalGoNextCycle');
    $('.num_cycle').html(id_cycle+1);
    doly();
   }
 });
}
function nombreCamionsMaintenance(){
 var nb = $('.elt_box .fa-times-circle').length;
 $('.numb-maint').html(nb);
 return;
}
              
              
              
              
              
            