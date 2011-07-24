$(document).ready(function () {	

	$("#config_form").submit(function(){
		$.post("/adminactions/saveconfigs.json", $("#config_form").serialize(), function(data) {
			if(data.result == 'success')
			{
				$('h4.alert_error').hide();
				$('h4.alert_success').show('slow');
			}
			else
			{			
				$('h4.alert_success').hide();
				$('h4.alert_error').html('Configuration could not been saved!' + data.message).show('slow');
			}
		}, "json");
		return false;
	});


});
