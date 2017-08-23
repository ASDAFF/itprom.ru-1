$(document).ready(function() {

	$(function(){
                $(document).click(function(e){
                    if ($(e.target).closest('div.shkaf-div').length) return;
                    $('div.shkaf-div div.discription-two').hide();
                    e.stopPropagation();
                });
                $('div.shkaf-div a.quest-about').mouseenter(function(){
                    $(this).next().show();
                });
                $('div.shkaf-div a.quest-about').mouseleave(function(){
                    $(this).next().hide();
                });
            });

});