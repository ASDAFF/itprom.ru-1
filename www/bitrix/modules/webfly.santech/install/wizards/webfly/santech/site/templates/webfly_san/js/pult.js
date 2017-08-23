$(function(){
  var action = $('[name="pult_form"]').attr("action");
  $('[name="pult_form"]').find("[type='radio']").on("change",function(){
    $('[name="pult_form"]').attr("action",location.href);
    $('[name="pult_form"]').submit();
  });
  $('[name="apply"]').on("click",function(){
    var theme = $("[name='pult_theme']:checked").val();
    var actives = $("[name='pult_buttons']:checked").val();
    var shadow = $("[name='pult_shadows']:checked").val();
    var bg = $("[name='pult_bg']:checked").val();
    $.post(action,{theme:theme,actives:actives,shadow:shadow,bg:bg},function(d){
      location.reload();
    });
  });
  $('.icon-default').on("click",function(){
    $.post(action,{action:"reset"},function(d){
      location.reload();
    });
  });
  $('.icon-gear').on('click', function(){
		if($('.pult').is('.show')) {
			$(this).removeClass('icon-active');
			$('.pult').removeClass('show');
			$('.icon-default').removeClass('icon-active');
		}
		else {
			$(this).addClass('icon-active');
			$('.pult').addClass('show');
		}
	});
	
	changeActiveLabel();
	$('.pultLabel').on('click', function(){
		changeActiveLabel();
		if($('.icon-default').is(':not(".icon-active")'))
			$('.icon-default').addClass('icon-active');
	});	
});
function changeActiveLabel() {
	if($('.pultLabel').length) {
		var labels = $('.pultLabel');
		labels.each(function(index, element) {
            if($(element).find('input:radio').is(':checked'))
				$(element).addClass('active');
			else
				$(element).removeClass('active');
        });
	}
}