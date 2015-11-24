jQuery(function ($) {
	// jQuery code comes here

    $(document).ready(function () {
        ts_ptshortcodeajax();
        ts_ripplebutton();
        alert('hi');//console.log('hi')
    });

    function ts_ripplebutton() {$('body').on( 'click', '.ripple-effect', function(e){
        // Ignore default behavior

        e.preventDefault();

        // Cache the selector
        var the_dom = $(this);

        // Get the limit for ripple effect
        limit = the_dom.attr( 'data-ripple-limit' );

        // Get custom color for ripple effect
         color = the_dom.attr( 'data-ripple-color' );
        if( typeof color == 'undefined' ){
            var color = 'rgba( 0, 0, 0, 0.3 )';
        }

        // Get ripple radius
        radius = the_dom.attr( 'data-ripple-wrap-radius' );
        if( typeof radius == 'undefined' ){
            var radius = 0;
        }

        // Get the clicked element and the click positions
        if( typeof limit == 'undefined' ){
             the_dom_limit = the_dom;
        } else {
            var the_dom_limit = the_dom.closest( limit );
        }

        var the_dom_offset = the_dom_limit.offset();
        var click_x = e.pageX;
        var click_y = e.pageY;

        // Get the width and the height of clicked element
        var the_dom_width = the_dom_limit.outerWidth();
        var the_dom_height = the_dom_limit.outerHeight();

        // Draw the ripple effect wrap
        var ripple_effect_wrap = $('<span class="ripple-effect-wrap"></span>');
        ripple_effect_wrap.css({
            'width' 			: the_dom_width,
            'height'			: the_dom_height,
            'position' 			: 'absolute',
            'top'			 	: the_dom_offset.top,
            'left'	 			: the_dom_offset.left,
            'z-index' 			: 100,
            'overflow' 			: 'hidden',
            'background-clip'	: 'padding-box',
            '-webkit-border-radius' : radius,
            'border-radius'		: radius
        });

        // Adding custom class, it is sometimes needed for customization
        var ripple_effect_wrap_class = the_dom.attr( 'data-ripple-wrap-class' );

        if( typeof ripple_effect_wrap_class != 'undefined' ){
            ripple_effect_wrap.addClass( ripple_effect_wrap_class );
        }

        // Append the ripple effect wrap
        ripple_effect_wrap.appendTo('body');

        // Determine the position of the click relative to the clicked element
        var click_x_ripple = click_x - the_dom_offset.left;
        var click_y_ripple = click_y - the_dom_offset.top;
        var circular_width = 1000;

        // Draw the ripple effect
        var ripple = $('<span class="ripple"></span>');
        ripple.css({
            'width' 						: circular_width,
            'height'						: circular_width,
            'background'					: color,
            'position'						: 'absolute',
            'top'							: click_y_ripple - ( circular_width / 2 ),
            'left'							: click_x_ripple - ( circular_width / 2 ),
            'content'						: '',
            'background-clip' 				: 'padding-box',
            '-webkit-border-radius'     	: '50%',
            'border-radius'             	: '50%',
            '-webkit-animation-name'		: 'ripple-animation',
            'animation-name'              	: 'ripple-animation',
            '-webkit-animation-duration'  	: '0.5s',
            'animation-duration'          	: '0.5s',
            '-webkit-animation-fill-mode' 	: 'both',
            'animation-fill-mode'         	: 'both'
        });
        $('.ripple-effect-wrap:last').append( ripple );

        // Remove rippling component after half second
        setTimeout( function(){
            ripple_effect_wrap.fadeOut(function(){
                $(this).remove();
            });
        }, 50 );

        // Get the href
        var href = the_dom.attr('href');

        // Safari appears to ignore all the effect if the clicked link is not prevented using preventDefault()
        // To overcome this, preventDefault any clicked link
        // If this isn't hash, redirect to the given link
        if( typeof href != 'undefined' && href.substring(0, 1) != '#' ){
            setTimeout( function(){
                window.location = href;
            }, 200 );
        }

        // Ugly manual hack to fix input issue
        if( the_dom.is('input') || the_dom.is('button') ){
            setTimeout( function(){
                the_dom.removeClass('ripple-effect');
                the_dom.trigger('click');
                the_dom.addClass('ripple-effect');
            }, 200 );
        }

    });
    }

    function ts_ptshortcodeajax() {

        var parent = $('*[class*="ts-ptshortcodeajax-"]');

        $.each(parent, function (i, value) {

            var item = $(this);

            var button = item.find('.btn'),
                callback = item.find('.callback');

            button.on('click', function () {

                var post_id = $(this).data('id');
                var field = $(this).data('field');

                $.ajax({
                    url: TSPTSC.ajax_url,
                    type: 'post',
                    data: {
                        action: 'ptshortcodeajax',
                        post_id: post_id,
                        field: field
                    },
                    success: function (response) {
                        //alert(response);
                        callback.html(response);
                    }
                });
            });
        });
    }
});