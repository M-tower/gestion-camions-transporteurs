
function startModal(elt, action, type){
 /*charge le contenu html du modal après avoir fait
  * intervenir la fonction de select2
  * et le controleur
  */
  $.post('core/modal_ajax.php',
   'elt='+elt+'&action='+action+'&type='+type,
   function (returnedData) { 
//    console.log('success ' + returnedData);
    // message(returnedData);
    if(returnedData){
      if($('#modalContent').html(returnedData)){
       if(elt == 'liste_client'){
        select2_script();
       }else if(elt == 'articles'){
        inputmask_script();
//        $('#designation').focus();
       }
       controleur('modalPrincipal');
       showModal('modalPrincipal');
      }
    }else{
      notifNO('Une erreur s\'est produite', "");
    }

 });
}

function startModal2(elt, action, type,location){
    startProfileModal(elt, action, type,location);
}

function startProfileModal(elt, action, type,location){
 /*charge le contenu html du modal après avoir fait
  * intervenir la fonction de select2
  * et le controleur
  */
  $.post('core/modal_ajax.php',
   'elt='+elt+'&action='+action+'&type='+type+'&location='+location,
   function (returnedData) {
    console.log('success ' + returnedData);
    // message(returnedData);
    if(returnedData){
      if($('#modalContent').html(returnedData)){
       if(elt == 'liste_client'){
        select2_script();
       }else if(elt == 'articles'){
        inputmask_script();
        $('#designation').focus();
       }
       controleur('modalPrincipal');
       showModal('modalPrincipal');
      }
    }else{
      notifNO('Une erreur s\'est produite', "");
    }

 });
}
function inputmask_script(){
// Input Mask
 if($.isFunction($.fn.inputmask))
 {
   $("[data-mask]").each(function(i, el)
   {
     var $this = $(el),
       mask = $this.data('mask').toString(),
       opts = {
         numericInput: attrDefault($this, 'numeric', false),
         radixPoint: attrDefault($this, 'radixPoint', ''),
         rightAlignNumerics: attrDefault($this, 'numericAlign', 'left') == 'right'
       },
       placeholder = attrDefault($this, 'placeholder', ''),
       is_regex = attrDefault($this, 'isRegex', '');


     if(placeholder.length)
     {
       opts[placeholder] = placeholder;
     }

     switch(mask.toLowerCase())
     {
       case "phone":
         mask = "(999) 999-9999";
         break;

       case "currency":
       case "rcurrency":

         var sign = attrDefault($this, 'sign', '$');;

         mask = "999,999,999.99";

         if($this.data('mask').toLowerCase() == 'rcurrency')
         {
           mask += ' ' + sign;
         }
         else
         {
           mask = sign + ' ' + mask;
         }

         opts.numericInput = true;
         opts.rightAlignNumerics = false;
         opts.radixPoint = '.';
         break;

       case "email":
         mask = 'Regex';
         opts.regex = "[a-zA-Z0-9._%-]+@[a-zA-Z0-9-]+\\.[a-zA-Z]{2,4}";
         break;

       case "fdecimal":
         mask = 'decimal';
         $.extend(opts, {
           autoGroup		: true,
           groupSize		: 3,
           radixPoint		: attrDefault($this, 'rad', '.'),
           groupSeparator	: attrDefault($this, 'dec', ',')
         });
     }

     if(is_regex)
     {
       opts.regex = mask;
       mask = 'Regex';
     }

     $this.inputmask(mask, opts);
   });
 }
}

/* Select avec tag */
function select2_script(){ 
 /*fonction pour le sélect à choix multiple
  * récupérée intacte dans le fichier neon-custom.js
  * */
 // Select2 Dropdown replacement
		if($.isFunction($.fn.select2))
		{
			$(".select2").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						allowClear: attrDefault($this, 'allowClear', false)
					};

				$this.select2(opts);
				$this.addClass('visible');

				//$this.select2("open");
			});


			if($.isFunction($.fn.niceScroll))
			{
				$(".select2-results").niceScroll({
					cursorcolor: '#d4d4d4',
					cursorborder: '1px solid #ccc',
					railpadding: {right: 3}
				});
			}
		}
}

function tooltip_script(){
 // Popovers and tooltips
		$('[data-toggle="popover"]').each(function(i, el)
		{
			var $this = $(el),
				placement = attrDefault($this, 'placement', 'right'),
				trigger = attrDefault($this, 'trigger', 'click'),
				popover_class = $this.hasClass('popover-secondary') ? 'popover-secondary' : ($this.hasClass('popover-primary') ? 'popover-primary' : ($this.hasClass('popover-default') ? 'popover-default' : ''));

			$this.popover({
				placement: placement,
				trigger: trigger
			});

			$this.on('shown.bs.popover', function(ev)
			{
				var $popover = $this.next();

				$popover.addClass(popover_class);
			});
		});

		$('[data-toggle="tooltip"]').each(function(i, el)
		{
			var $this = $(el),
				placement = attrDefault($this, 'placement', 'top'),
				trigger = attrDefault($this, 'trigger', 'hover'),
				popover_class = $this.hasClass('tooltip-secondary') ? 'tooltip-secondary' : ($this.hasClass('tooltip-primary') ? 'tooltip-primary' : ($this.hasClass('tooltip-default') ? 'tooltip-default' : ''));

			$this.tooltip({
				placement: placement,
				trigger: trigger
			});

			$this.on('shown.bs.tooltip', function(ev)
			{
				var $tooltip = $this.next();

				$tooltip.addClass(popover_class);
			});
		});
}

function showModal(a){
//  if(a == 'myModalConfirmation'){
//    initialiseModal('myModalConfirmation');
//  }
  $('#'+a).modal({
         show:true,
         backdrop:'static'
        });
}
function hideModal(a){
  setTimeout(function () {
      $('#'+a).modal('hide');
  }, 500);
}
function initialiseModal(a){
  if(a == 'myModalConfirmation'){
    $('#message_alert').css('display', 'block');
    $('#bouton_action').css('display', 'block');
  }
}
