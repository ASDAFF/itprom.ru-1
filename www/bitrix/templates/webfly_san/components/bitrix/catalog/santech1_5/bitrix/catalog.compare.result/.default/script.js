$(function(){
  $(".data-table tr").each(function(k,v){
    if($(v).find(".prp").length > 0){
      var nbsps = $(v).find(".prp").map(function(){return $.trim($(this).text());}).get().join("");
    //  console.log(nbsps.length);
      if(nbsps.length === 0) $(v).hide();
    }
  }).queue(function(){
	  $('.data-table tr:visible:odd').addClass('darkenTr');
	$(this).dequeue();
	});

});