jQuery(document).ready(function(e) {

	$ = jQuery;

    /*-----------------------------------------------------------------------------------*/
    /*	check a mobile device in javascript and assign a class to body based on that
    /*-----------------------------------------------------------------------------------*/
	function mobile_device(){
		var current_width = $(window).width();
		if(current_width < 480){
		  	jQuery('body').addClass("probably-mobile");
		}
		else
		{
			 jQuery('body').removeClass("probably-mobile");
		}
	}
	
	mobile_device();
	
	$(window).resize(function(){
		mobile_device();
	});


    /*-----------------------------------------------------------------------------------*/
    /*	Remove Width and Height Attribute of Images
     /*-----------------------------------------------------------------------------------*/
    $('img').not('.lt-ie9 img').removeAttr("width height");


	/*-----------------------------------------------------------------------------------*/
	/*	Flex Slider 
	/*-----------------------------------------------------------------------------------*/
    if(jQuery().flexslider)
    {

        // Flex Slider for Homepage
		$('.flexslider').flexslider({
							animation: "fade",
							slideshowSpeed: 7000,
							animationSpeed:	1500,
							directionNav: true,
							controlNav: false,			
							keyboardNav: true				
						});


        // Remove Flex Slider Navigation for Smaller Screens Like IPhone Portrait
		$('.slider-wrapper').hover(function(){
										var mobile = $('body').hasClass('probably-mobile');
										if(!mobile)
										{
											$('.flex-direction-nav').stop(true,true).fadeIn('slow');
										}
									},function(){
										    $('.flex-direction-nav').stop(true,true).fadeOut('slow');
									});
    }



	/*-----------------------------------------------------------------------------------*/
	/*	Carousel - Elastislide
	/*-----------------------------------------------------------------------------------*/
    if(jQuery().elastislide)
    {
		$('.carousel').elastislide({
					imageW		: 89,				
					minItems	: 0,
					margin		: 11,
					border		: 0
				});
    }


    $(function() {
        $('.es-carousel figure').click(function(e){
            window.location = $(this).find('a').attr('href');
        });
    });


	/*-----------------------------------------------------------------------------------*/
	/*	Cross Browser CSS Fixes
	/*-----------------------------------------------------------------------------------*/	
		$('#header .main-menu > ul > li:last-child > a').css('background','none');
		$('#sidebar .widget .sidebar-menu-item:last-child').css('border-bottom','none');
		//('#header ul > li > ul > li:last-child').css('border-bottom','none');

	
	
	/*-----------------------------------------------------------------------------------*/
	/* Main Menu Dropdown Control
	/*-----------------------------------------------------------------------------------*/
    $(function() {
		$('.main-menu ul li').hover(function(){
				$(this).children('.sub-menu').stop(true, true).slideDown(500);
			},function(){
				$(this).children('.sub-menu').stop(true, true).slideUp(500);
		}); 
    });

    $(function() {
		$('.main-menu .sub-menu .menu-item').click(function(e){
					window.location = $(this).children('a').attr('href');
		});
    });


	
	/*-----------------------------------------------------------------------------------*/
	/* Pretty Photo Lightbox
	/*-----------------------------------------------------------------------------------*/
    if( jQuery().prettyPhoto )
    {
        $(".pretty-photo").prettyPhoto({
            deeplinking: false,
            social_tools: false
        });
    }
		


	/* ---------------------------------------------------- */
	/*	Accordion
	/* ---------------------------------------------------- */
    $(function() {
		$('.accordion dt').click(function(){
			$(this).siblings('dt').removeClass('current');
			$(this).addClass('current').next('dd').slideDown(500).siblings('dd').slideUp(500);
		});	
    });
		

	/* ---------------------------------------------------- */
	/*	FAQ
	/* ---------------------------------------------------- */
    $(function() {
		$('dl.toggle dt').click(function(){
			if($(this).hasClass('current')){
				$(this).removeClass('current').next('dd').slideUp(500);
			}				
			else{
				$(this).addClass('current').next('dd').slideDown(500);
			}
		});	 
    });



	/*-----------------------------------------------------------------------------------*/
	/*	Scroll to Top
	/*-----------------------------------------------------------------------------------*/	
    $(function() {
        $(window).scroll(function () {
            if(!$('body').hasClass('probably-mobile'))
            {
                if ($(this).scrollTop() > 50) {
                    $('a#scroll-top').fadeIn();
                } else {
                    $('a#scroll-top').fadeOut();
                }
            }
            else
            {
                $('a#scroll-top').fadeOut();
            }
        });

        $('a#scroll-top').on('click', function(){
            if(!$('body').hasClass('probably-mobile'))
            {
                $('html, body').animate({scrollTop:0}, 'slow' );
                return false;
            }
        });
    });



	/* ---------------------------------------------------- */
	/*	Content Tabs
	/* ---------------------------------------------------- */
    $(function(){

        var $tabsNav    = $('.tabs-nav'),
            $tabsNavLis = $tabsNav.children('li');

        $tabsNav.each(function(){
            var $this = $(this);
            $this.next().children('.tab-content').stop(true,true).hide()
                                                 .first().show();
            $this.children('li').first().addClass('active').stop(true,true).show();
        });

        $tabsNavLis.on('click', function(e) {
            var $this = $(this);
            $this.siblings().removeClass('active').end()
                 .addClass('active');
            var idx = $this.parent().children().index($this);
            $this.parent().next().children('.tab-content').stop(true,true).hide().eq(idx).fadeIn();
            e.preventDefault();
        });

    });



	 /* ---------------------------------------------------- */
	 /*  Responsive Tables by ZURB
	 /*	  Foundation v2.1.4 http://foundation.zurb.com
	 /* ---------------------------------------------------- */
	  var switched = false;
	  var updateTables = function() {
		if (($(window).width() < 767) && !switched ){
		  switched = true;
		  $("table.responsive").each(function(i, element) {
			splitTable($(element));
		  });
		  return true;
		}
		else if (switched && ($(window).width() > 767)) {
		  switched = false;
		  $("table.responsive").each(function(i, element) {
			unsplitTable($(element));
		  });
		}
	  };
	   
	  $(window).load(updateTables);
	  $(window).bind("resize", updateTables);
	   
		
		function splitTable(original)
		{
			original.wrap("<div class='table-wrapper' />");
			
			var copy = original.clone();
			copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
			copy.removeClass("responsive");
			
			original.closest(".table-wrapper").append(copy);
			copy.wrap("<div class='pinned' />");
			original.wrap("<div class='scrollable' />");
		}
		
		function unsplitTable(original) {
            original.closest(".table-wrapper").find(".pinned").remove();
            original.unwrap();
            original.unwrap();
		}



    /*-----------------------------------------------------------------------------------*/
    /*	Isotope
    /*-----------------------------------------------------------------------------------*/
    if( jQuery().isotope )
    {
        $(function() {

            var container = $('.isotope'),
                filterLinks = $('#filter-by a');

            filterLinks.click(function(e){
                var selector = $(this).attr('data-filter');
                container.isotope({
                    filter : '.' + selector,
                    itemSelector : '.isotope-item',
                    layoutMode : 'fitRows',
                    animationEngine : 'best-available'
                });

                filterLinks.removeClass('active');
                $('#filter-by li').removeClass('current-cat');
                $(this).addClass('active');
                e.preventDefault();
            });

        });
    }



    /* ---------------------------------------------------- */
    /*	Gallery Hover Effect
    /* ---------------------------------------------------- */

    var $mediaContainer=$('.gallery-item .media_container'),
        $media=$('.gallery-item .media_container a');

    var $margin= -($media.height()/2);
    $media.css('margin-top',$margin);

    $(function(){

        $('.gallery-item figure').hover(

            function(){
                var media= $media.width(),
                    container= ($mediaContainer.width()/2)-(media+2);

                $(this).children('.media_container').stop().fadeIn(300);
                $(this).find('.media_container').children('a.link').stop().animate({'right':container}, 300);
                $(this).find('.media_container').children('a.zoom').stop().animate({'left':container}, 300);
            },
            function(){
                $(this).children('.media_container').stop().fadeOut(300);
                $(this).find('.media_container').children('a.link').stop().animate({'right':'0'}, 300);
                $(this).find('.media_container').children('a.zoom').stop().animate({'left':'0'}, 300);
            }

        );

    });

    /*-----------------------------------------------------------------------------------*/
    /*	Responsive Nav for Header
     /*-----------------------------------------------------------------------------------*/
    var $mainNav    = $('.main-menu > div').children('ul');
    var optionsList = '<option value="" selected>Go to...</option>';

    $mainNav.find('li').each(function() {
        var $this   = $(this),
            $anchor = $this.children('a'),
            depth   = $this.parents('ul').length - 1,
            indent  = '';
        if( depth ) {
            while( depth > 0 ) {
                indent += ' - ';
                depth--;
            }
        }
        optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
    }).end().last()
        .after('<select class="responsive-nav">' + optionsList + '</select>');

    $('.responsive-nav').on('change', function() {
        window.location = $(this).val();
    });



    /*-----------------------------------------------------------------------------------*/
    /*	Responsive Nav for Footer
     /*-----------------------------------------------------------------------------------*/
    var $mainNav    = $('#footer-menu').children('ul');
    var optionsList = '<option value="" selected>Go to...</option>';

    $mainNav.find('li').each(function() {
        var $this   = $(this),
            $anchor = $this.children('a'),
            depth   = $this.parents('ul').length - 1,
            indent  = '';
        if( depth ) {
            while( depth > 0 ) {
                indent += ' - ';
                depth--;
            }
        }
        optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
    }).end()
        .after('<select class="responsive-nav">' + optionsList + '</select>');

    $('.responsive-nav').on('change', function() {
        window.location = $(this).val();
    });


    /*----------------------------------------------------------------------------------*/
    /*	Contact Form AJAX validation and submition
     /*  Validation Plugin : http://bassistance.de/jquery-plugins/jquery-plugin-validation/
     /*	Form Ajax Plugin : http://www.malsup.com/jquery/form/
     /*---------------------------------------------------------------------------------- */

    $('#contact-form .contact-form').validate({
        errorLabelContainer: $("div.error-container"),
        submitHandler: function(form) {
            $(form).ajaxSubmit(contact_options);
        }
    });


    /* ---------------------------------------------------- */
    /*	jQuery UI Date Picker
     /* ---------------------------------------------------- */

    /*
     *   For localization of Datepicker
     *   Visit - http://docs.jquery.com/UI/Datepicker/Localization
     *   And Modify the code below after removing comments
     */

     $( "#date" ).datepicker();

});







