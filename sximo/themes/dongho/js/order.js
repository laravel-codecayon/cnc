$( document ).ready(function() {
	$("#change-display").click(function(){
		var type = $(this).attr('type');
	    var link = "{{URL::to('')}}{{$_SERVER['REQUEST_URI']}}";
	    var ln = "{{URL::to('')}}/home/changedisplay";
		$.post( ln,{type : type}, function( data ) {
			window.location.href = link;
		});
	});
});