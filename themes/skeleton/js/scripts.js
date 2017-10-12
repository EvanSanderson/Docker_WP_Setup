(function($) {
    
	$('a[href^="#"]').on('click',function (e) {
        e.preventDefault();
        var target = this.hash;
        $('html, body').stop().animate({
            'scrollTop': $(target).offset().top
        }, 750, 'swing', function() {
            //window.location.hash = target;
      $('#secondary-nav').find('a').removeClass('active');
      $('[href*="'+target+'"]').addClass('active');
        });
    });

function onScroll(event){
    var scrollPos = $(document).scrollTop();
    $('#secondary-nav a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('#secondary-nav a').removeClass("active");
            currLink.addClass("active");
        }
        else{
            currLink.removeClass("active");
        }
    });
}

    $(window).scroll(function() {    
	    var scroll = $(window).scrollTop();
	    var targetOffset = $("#main-section").offset().top;
		
		onScroll();

	    if (scroll > targetOffset) {
	        //var id = $(this).attr('id');
	        $("#secondary-nav").addClass("sticky");
	       
	    }
	    else{
	    	$("#secondary-nav").removeClass("sticky");
	    }
	    
	});
	$(document).on('ready', function() {
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
      });
      
    });

    var pull = $('#pull');
    $('#pull').on('click', function(e) {
        e.preventDefault();
        $('.main-menu').slideToggle('is-open');
        $('.main-menu').clearQueue();
    });
    $('.main-menu-search').on('click', function(e) {
        e.preventDefault();
        $('.main-search').slideToggle('is-open');
        $('.main-search').clearQueue();
    });
    

}) (jQuery);