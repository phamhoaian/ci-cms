$(function () {
	$('#sidebar-menu li ul').hide();
	$('#sidebar-menu li').each(function(){
		if ($(this).is('.active')) {
			$('ul', this).slideDown();
		}
	});

    $('#sidebar-menu li').click(function () {
    	if ($(this).is('.active')) {
    		$(this).removeClass('active');
            $('ul', this).slideUp();
		} else {
			$('#sidebar-menu li ul').slideUp();
			$('ul', this).slideDown();
            $('#sidebar-menu li').removeClass('active');
            $(this).addClass('active');
		}
    });

    $('#menu-toggle').click(function () {
    	if ($('body').hasClass('nav-sm')) {
    		$('body').removeClass('nav-sm');
    		$('#sidebar-menu li.active-sm ul').slideDown();
    		
            if ($('#sidebar-menu li').hasClass('active-sm')) {
                $('#sidebar-menu li.active-sm').addClass('active');
                $('#sidebar-menu li.active-sm').removeClass('active-sm');
            }
    	} else {
    		$('body').addClass('nav-sm');
    		$('#sidebar-menu li ul').hide();

			if ($('#sidebar-menu li').hasClass('active')) {
                $('#sidebar-menu li.active').addClass('active-sm');
                $('#sidebar-menu li.active').removeClass('active');
            }
    	}
    });

    // tooltip
    $('[data-toggle="tooltip"]').tooltip(); 
});