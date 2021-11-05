/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var $ = jQuery;
var responsiveHelper;
var breakpointDefinition = {
    tablet: 1024,
    phone: 480
};
var tableContainer;
jQuery(document).ready(function ($)
{
    tableContainer = $("#table-1");

    if(tableContainer) {
        tableContainer.dataTable({
          dom: 'Bfrtip',
          "oLanguage": {
              "sEmptyTable": "Aucun enregistrement",
              "sInfoEmpty": "Aucun élément",
              "sZeroRecords": "Aucun résultat trouvé",
              "sSearch": "<i class='entypo-search'></i>",
              "sInfoFiltered": " - filter depuis _MAX_ ligne(s)",
              "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ lignes"
          },
          "sPaginationType": "bootstrap",
          "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
          "bStateSave": true,
          select: true,
          "lengthChange": true,

          // Responsive Settings
          bAutoWidth: false,
          fnPreDrawCallback: function () {
              // Initialize the responsive datatables helper once.
              if (!responsiveHelper) {
                  responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
              }
          },
          fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
              responsiveHelper.createExpandIcon(nRow);
          },
          fnDrawCallback: function (oSettings) {
              responsiveHelper.respond();
          },

          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5'
          ]
      });
    }
    let select2Objects = $(".dataTables_wrapper select");

    if(select2Objects) {
        select2Objects.select2({
            minimumResultsForSearch: -1
        });
    }
//														var pageEncour = $(location).attr('href');
    // var lien = pageEncour.replace('https://web.zaofia.com', '');

    // var menu = $('.main-menu li a');
    // for(var i=0; i<menu[0].length; i++){
    // if(menu.attr('href') == lien){
    // console.log('>>lien '+lien+' et len ='+menu.attr('href'));
    // $(this).closest('li').addClass('active');
    // }
    // }
});
var $ = jQuery;
//              $(document).ready(function() {
//    $("[datatableid ='jet1']").DataTable( {
//        dom: 'Bfrtip',
//        buttons: [
//            'copyHtml5',
//            'excelHtml5',
//            'csvHtml5',
//            'pdfHtml5'
//        ]
//    } );
//} );
