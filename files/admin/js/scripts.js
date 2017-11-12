$(document).ready(function () {

	// Not index Footer changes
	if($("#homepage-flag").length == 0) {
		$(".footer .col-md-3:nth-child(2)").css({"margin-left":"auto"});
		$(".footer .col-md-3:last-child").css({"display":"block"});
	}
	
	// Map page Footer changes
	if($("#map-page-flag").length == 1) {
		$(".footer").css({"display":"none"});
	}
	
	// Mobile menu toggle
	$( ".mobile_btn" ).on( "click", function() {
		$(this).toggleClass("active");
		$( ".top_nav" ).slideToggle();
		$(" .mobile_btn .fa").toggleClass("fa-times fa-bars");
	});
	
	//Seo text full view 
	var seoHeight = $( ".seo_text" ).height();
	
	if ($(window).width() < 480) {
		$( ".seo_text" ).css( {"height":"250"} );
	}
	
	$( ".seo_text_btn" ).on( "click", function() {
		$(this).toggleClass("active").find(".fa").toggleClass("fa-angle-up fa-angle-down");;
		// Seo box height toggle
		if ( $(this).hasClass("active") ){
			$( ".seo_text" ).animate({ height: seoHeight }, 300 );
			$(".seo_text_inner .white_blure").fadeOut("fast");
		} else{
			$( ".seo_text" ).animate({ height: 250}, 300 );
			$(".seo_text_inner .white_blure").fadeIn("fast");
		}
	});
});
