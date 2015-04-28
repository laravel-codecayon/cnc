
$(function(){
	slider2 = $("#menu-slide").slideReveal({
	  // width: 100,
	  push: false,
	  position: "right",
	  speed: 600,
	  trigger: $(".show-slide-menu"),
	  show: function(slider, trigger){
		$("#menu-slide").css({ opacity: "1" });
		$("#hide-menu").css({ display: "inline-block" });
		},
	  hidden: function(slider, trigger){
		$("#menu-slide").css({ opacity: "0" });
		}   
	});
	
	$("#hide-menu").click(function(){
		$("#menu-slide").slideReveal("hide");
		$("#hide-menu").css({ display: "none" });
	});		
	$('#news .latest-news').mCustomScrollbar();
	
	$(".youtube").YouTubeModal({autoplay:0, width:640, height:480});
	
});
//$(document).ready(function() {
	
	//$("body").css("display", "none");
//	$("body").addClass('animated');
  //  $("body").addClass('fadeInRight');
    
	//$("a.transition").click(function(event){
		//event.preventDefault();
		//linkLocation = this.href;
		//$("body").addClass('fadeOutLeft').fadeOut(500, redirectPage);		
	//});
		
	//function redirectPage() {
		//window.location = linkLocation;
	//}
	
//});

jQuery(document).ready(function() {
	jQuery('.move').addClass("hide-block").viewportChecker({
	    classToAdd: 'visible animated fadeInRight',
	    offset: 200
	   });
	jQuery('.article').addClass("hide-block").viewportChecker({
	    classToAdd: 'visible animated fadeInRight',
	    offset: 200
	   });

	$('.slider-customer').slick();
	$('.news-2column .row').slick();
	$('.news-1column .wrapper').slick();
	$('.news-3column .row').slick();

					   
});