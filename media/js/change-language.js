(function($){
	'use strict';
	
	$(document).on('change', '#select-language', function(){
		$.cookie('lang', $(this).val(), {
        	expires : 300, 
        	path : '/'
        });
		window.location.reload();
	});
	
	moment.locale($(document.querySelector("html")).attr('lang'));
})(jQuery);