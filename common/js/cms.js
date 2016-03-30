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
    
    // Collapse ibox function
    $('.collapse-link').click(function () {
        var x_panel = $(this).closest('div.x_panel');
        var button = $(this).find('i');
        var content = x_panel.find('div.x_content');
        content.slideToggle(200);
        (x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
        (x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        setTimeout(function () {
            x_panel.resize();
        }, 50);
    });
});
// insert read more
function jInsertEditorText(text, editor)
{
    tinyMCE.execCommand('mceInsertContent', false, text);
}
function insertReadMore(editor)
{
    var content = tinyMCE.activeEditor.getContent();
    if (content.match(/<hr\s+id=("|')readmore("|')\s*\/*>/i))
    {
        alert('There is already a Read more ... link that has been inserted. Only one link is permitted. Use {pagebreak} to split the page up further.');
            return false;
    } else {
        jInsertEditorText("<hr id='readmore' />", editor);
    }
}