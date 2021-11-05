function remplirHistoriqueActivite(){
var mail_user = $('.cycle_select').val();
if(mail_user == ''){
 $('.tb_distribution').html('<h3 style="text-align:center">Aucun contenu disponible pour le moment...</h3>');
 return;
}
var action = 'action=getHistorique&mail_user='+mail_user;
  $.post('core/ajax.php',
    action,
    function(ret){
      console.log('->'+ret);
      if(ret == ''){
        $('.tb_distribution').html('<h3 style="text-align:center">Aucun contenu disponible pour le moment...</h3>');
        return;
      }
      var r = JSON.parse(ret);
      var cont = '';
//      var jour_actif = parseInt($('.selected_jour').val());
//      var a = 1;
//      console.log('->'+r.length);
      cont += `<table class=" table" >
            <tr>
              <th class="tb_lib">Date</th>
              <th class="tb_lib" style="width:75%">Action</th>
            </tr>`;
      for(var i=0; i<r.length; i++){
        var ret = r[i];
        for(var a in ret){
            cont +=`<tr>
              <td class="tb_content">${a}</td>
              <td class="tb_content">${ret[a]}</td>
            </tr>`;
        }
      }
      cont += '</table>';
      $('.tb_distribution').html(cont);
    }
  );
}


