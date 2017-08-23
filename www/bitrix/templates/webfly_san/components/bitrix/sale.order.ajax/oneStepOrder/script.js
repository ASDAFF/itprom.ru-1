// Order scripts
function checkMyLabels(){
			$('.myLabel').each(function() {
				var myInput='#'+$(this).attr('for');
				if ($(myInput).is(':checked')) 
					$(this).addClass('active');
				else $(this).removeClass('active');
			});
		}
		$(document).ready(function(e) {

		$('.myLabel').on('click', function(e) {
					checkMyLabels();
			})
		});