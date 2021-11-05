function checkboxManager(){
	// Highlighted rows
			$("#table-1 tbody input[type=checkbox]").each(function(i, el)
			{
				var $this = $(el),
					$p = $this.closest('tr');
				
				$(el).on('change', function()
				{
					var is_checked = $this.is(':checked');
					
					$p[is_checked ? 'addClass' : 'removeClass']('highlight');
					(is_checked) ? $(this).closest('label').children('div').css('opacity', '1') : $(this).closest('label').children('div').css('opacity', '0');
					if(!is_checked){//si l'élément est décocher, on le décoche le check du thead
							$("#table-1 thead input[type=checkbox]").prop('checked', false);
							$("#table-1 thead tr label div").css('opacity', '0');
					}
					
				});
			});
			//gestion du checkbox du header --> sélectionner tout
			$("#table-1 thead input[type=checkbox]").each(function(i, el)
			{
				var $this = $(el);
					// $p = $('tbody tr');
				
				$(el).on('change', function()
				{
					var is_checked = $this.is(':checked');
					// $p[is_checked ? 'addClass' : 'removeClass']('highlight');
					(is_checked) ? cocherTout(true) : cocherTout(false) ;
					// (is_checked) ? $('tbody tr label div').css('opacity', '1') : $('tbody tr label div').css('opacity', '0');
				});
			});
			
			// Replace Checboxes
			$(".pagination a").click(function(ev)
			{
				replaceCheckboxes();
			});
}
function cocherTout(a){
	$("#table-1 tbody input[type=checkbox]").prop('checked', a);
	if(a){
		$('thead tr label div').css('opacity', '1');
		$('tbody tr label div').css('opacity', '1');
		$('tbody tr').addClass('highlight');
	}else{
		$('thead tr label div').css('opacity', '0');
		$('tbody tr label div').css('opacity', '0');
		$('tbody tr').removeClass('highlight');
	}
}