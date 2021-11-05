function goTo(page,i=false) {
  var suite = (i)? "&id=" + i : "";
  document.location.href = "/?page="+page+suite;
}
function slasher(nom){
  return nom.replace(/'/g, "\\'");
}
function noSlasher(nom){
  return nom.replace("\\'", "'");
}
function lapage(){
 var url = new URL(window.location.href);
 var page = url.searchParams.get('page');
 return page;
}

/* 
 * Fonction contrôleur à appliquer à tous les 
 * formulaire de modals
 * INSTRUCTIONS :
 * 1. ajouter la classe sender au bouton d'envoi
 * 2. ajouter la classe required aux champs requises
 * 3. ajouter la classe isExistControl si le contenu du champs doit être soumis à un contrôl d'unicité
 * 3.1 ou isExistControlMulti en cas de contrôle sur plusieurs champs
 * 4. va avec le 3. ajouter l'attribut existControlUrl="[action de l'ajax de contrôle]";
 */
$ = jQuery;
function controleur(modal) {
  var sender = $('.sender');
  var input = $('#'+modal+' input.required');
  var select = $('#'+modal+' select.required');
  input.each(function(i){
   $(this).keyup(function(){
    if($.trim($(this).val()) === '' && !$(this).hasClass('isExistControl') && !$(this).hasClass('isExistControlMulti')){ 
     /* si le champ est vide et ne fait pas partie d'un champs de control ajax */
     $(this).css('border','1px solid red');
     $(this).attr('err', 'true');
     sender.attr('disabled','true'); /* désactive à la moindre erreur */
    }else if($(this).hasClass('isExistControl')){ /* traitement différent pour le champ de control ajax */
     isExist($(this).attr('id'), $(this).attr('existControlUrl'));
    }else if($(this).hasClass('isExistControlMulti')){ 
     /* traitement différent pour le champ de control ajax Multiple (plusieurs champs)*/
     var LesIds = $(this).attr('collectedId');
     isExist(LesIds, $(this).attr('existControlUrl'));
    }else{
     $(this).css('border','1px solid green');
     $(this).removeAttr('err');
    }
   });
   $(this).change(function(){
    if($.trim($(this).val()) === '' && !$(this).hasClass('isExistControl') && !$(this).hasClass('isExistControlMulti')){ 
     /* si le champ est vide et ne fait pas partie d'un champs de control ajax */
     $(this).css('border','1px solid red');
     $(this).attr('err', 'true');
     sender.attr('disabled','true'); /* désactive à la moindre erreur */
    }else if($(this).hasClass('isExistControl')){ /* traitement différent pour le champ de control ajax */
     isExist($(this).attr('id'), $(this).attr('existControlUrl'));
    }else if($(this).hasClass('isExistControlMulti')){ 
     /* traitement différent pour le champ de control ajax Multiple (plusieurs champs)*/
     var LesIds = $(this).attr('collectedId');
     isExist(LesIds, $(this).attr('existControlUrl'));
    }else{
     $(this).css('border','1px solid green');
     $(this).removeAttr('err');
    }
   });
  });
  sender.closest('div').mouseover(function(){
   var error = false;
   input.each(function(i){ /* boucle pour checker si un des input requi a l'attribut err ou est vide*/
    if($(this).attr('err') || $.trim($(this).val()) === ''){
     error = true;
     $(this).css('border','1px solid red');
    }
   });
   if(!error){ /* si on  en a pas trouvé alors tout est bon */
    sender.removeAttr('disabled'); /* activation */
   }else{
    sender.attr('disabled','true'); /*desactivation du bouton */
   }
  });
}
function isExist(a, action){ /* met en error le champ si son contenu existe déjà dans la base */
 /*
  * a = id du champs ou collection d'id de plusieurs champs
  * action =  action de l'ajax
  */
 var coll_id = a.split(',');
 if(coll_id.length <= 1){
  var ref = $('#'+a).val();
  $.post('core/ajax.php',
         'action='+action+'&ref=' + ref,
         function (returnedData) { 
          if(returnedData >= 1){
           $('#'+a).css('background-color', '#fed');
           $('#'+a).css('border','1px solid red');
           var msg = '';
           if(action === 'camionIsExist'){
            msg = 'Un camion avec la même immatriculation existe déjà dans votre base.';
           }
           $('#'+a).attr('data-original-title', msg);
           $('#'+a).attr('err', 'true');
           tooltip_script(); /*activation des tooltip (boite de dialogue) */
          }else{
           $('#'+a).css('background-color', '#fff');
           $('#'+a).css('border','1px solid green');
           $('#'+a).removeAttr('err');
           $('#'+a).attr('data-original-title', '');
          }
         });
 }else{
  
 }
//        return $('#'+a).hasClass('fatalError');
}
function videur(modal, inpt) {
 /*
  * la variable inpt ici, est un array d'ids de champs input
  */
 var sendBtn = $('#'+modal+' .sender');
 for(var i=0; i<inpt.length; i++){
  
  var leType = $('#'+modal+' #'+inpt[i]).attr('type');
  if(leType == 'text' || leType == 'mail' || leType == 'hidden'){
   $('#'+modal+' #'+inpt[i]).val('');
  }
 }
 sendBtn.attr('disabled','true');
}
function remplisseur(modal, inpt){
 /*
  * la variable inpt ici, est un array d'ids de champs input et leurs valeurs.
  * "id" => "valeur"
  */
// console.log('just');
 var sender = $('.sender');
 var clefs = arrayKeys(inpt);
 for(var i=0; i<clefs.length; i++){
  var leType = $('#'+clefs[i]).attr('type');
  var elt = $('#'+clefs[i]);
  var valeur = inpt[clefs[i]];
  elt.val(valeur);
//   console.log('clef = '+clefs[i]);
//   console.log('inpt = '+valeur);
 }
 if(modal == 'myModal'){
  if(inpt['type_access'] == 1){ /* si admin */
   $('#tableMessage').html('<tr><td><i class="entypo-check"></i></td><td>Tous les accès</td></tr>');
  }else{
   var message = '';
   $.post('core/ajax.php',
   'action=getAccess&id=' + inpt['type_access'],
   function (returnedData) {   // A function to be called if request succeeds
 //   console.log('id ' + inpt['type_access']);
 //   console.log('returnedData type=' + (typeof returnedData));
 //   console.log('success ' + returnedData);
    var actifs = JSON.parse(returnedData);
    for(var i=0; i< actifs.length; i++){
     message += '<tr><td><i class="entypo-check"></i></td><td>'+accessTable[actifs[i]]+'</td></tr>';
    }
    $('#tableMessage').html(message);
   });
  }
 }
// console.log('okk');
 sender.html('modifier');
 sender.attr('disabled','true');
}

function arrayKeys(input) {
 /*
  * function qui retourne les clefs de l'array input
  */
    var output = new Array();
    var counter = 0;
    for (i in input) {
        output[counter++] = i;
    } 
    return output; 
}
function couperTexte(texte, limit){
 var points = '...';
 if(texte){
 if(texte.length < limit){
  points = '';
 }
 }else{
  return '--';
 }
 return texte.substring(0, limit) + points;
}
function setPageTitle(page){
 switch (page){
  case 'clients' : 
   document.title = 'Clients | SY.NA.TRA.C.T - Transport';
   break;
  case 'edit-client' : 
   document.title = 'Editer un Client | SY.NA.TRA.C.T - Transport';
   break;
  case 'transporteurs' : 
   document.title = 'Transporteurs | SY.NA.TRA.C.T - Transport';
   break;
  case 'camions' : 
   document.title = 'Camions | SY.NA.TRA.C.T - Transport';
   break;
  case 'edit-transporteur' : 
   document.title = 'Editer un transporteur | SY.NA.TRA.C.T - Transport';
   break;
  case 'historique-cycles' : 
   document.title = 'Historique des cycles | SY.NA.TRA.C.T - Transport';
   break;
  case 'historique-activites' : 
   document.title = 'Historique des activités | SY.NA.TRA.C.T - Transport';
   break;
  default :
   document.title = 'SY.NA.TRA.C.T - Transport';
 }
}
function activeMenu(a){
 /* gère la surbrillance du menu concerné par la page encours
  * a -> valeur du variable "page" dans l'URL
  */
 var sous_pages_client = new Array(
         'clients',
         'edit-client',
         );
 var sous_pages_transporteurs = new Array(
         'transporteurs',
         'edit-transporteur',
         'camions'
         );
 var sous_pages_historique = new Array(
         'historique-cycles',
         'historique-activites'
         );
 
 if(a === null){
  $('._home').addClass('active');
 }else{
  if($.inArray(a, sous_pages_client) !== -1){
   $('._clients').addClass('active');
  }else if($.inArray(a, sous_pages_transporteurs) !== -1){
   $('._transporteurs').addClass('active');
  }else if($.inArray(a, sous_pages_historique) !== -1){
   $('._historique').addClass('active');
  }else{
   $('._'+a).addClass('active');
  }
 }
}