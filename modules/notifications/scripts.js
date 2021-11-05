var opts = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-bottom-left",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "10000",
  "extendedTimeOut": "5000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
var optsNo = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-top-full-width",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "10000",
  "extendedTimeOut": "5000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

function notifOK(message, titre){
  toastr.success(message, titre, opts);
  return;
}
function notifNO(message, titre){
  toastr.error(message, titre, optsNo);
  return;
}
function notifINFO(message, titre){
  toastr.info(message, titre, opts);
  return;
}
function notifALERT(message, titre, f=null){
  toastr.warning(message, titre,  {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-bottom-right",
  "onclick": f,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "0",
  "extendedTimeOut": "0",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
});
  return;
}
function opeOK(){
  return 'Opération réussie';
}
function opeNO(){
  return 'Une erreur s\'est produite';
}