(function($) {

	$('#btn-select-community').change(function() {
		$('#edit-communities').addClass('hide');
		$('#new-community').addClass('hide');
		$('#select-communities').removeClass('hide');
	});

	$('#btn-edit-community').change(function() {
		$('#select-communities').addClass('hide');
		$('#new-community').addClass('hide');
		$('#edit-communities').removeClass('hide');
	});

	$('#btn-create-community').change(function() {
		$('#edit-communities').addClass('hide');
		$('#select-communities').addClass('hide');
		$('#new-community').removeClass('hide');
	});

	$('#new-community form').submit(function() {
		var name = $('#new-community-name').val();
		$('#new-community form :input').prop('disabled', true);

		$.ajax({
			url : '/api/v1/community',
			method : 'post',
			data : {
				name : name
			},
			success : function(response) {
				$('#new-community-name').val('');
				$('#new-community form :input').prop('disabled', false);
				$('#new-community-success-message').removeClass('hide');
				loadCommunities();
			},
			error : function() {
				$('#new-community form :input').prop('disabled', false);
				$('#new-community-error-message').removeClass('hide');
			}
		});

		return false;
	});
	
	$('#select-communities .item')

	loadCommunities();

	function loadCommunities() {
		$.ajax({
			url : '/api/v1/community',
			success : function(response) {
				$.each(response, function(i, item) {
					addCommunity(item);
				});
			}
		});
	}

	function addCommunity(item) {
		var div = $('<div class="item clickable" data-id="' + item.id + '"><p class="title">' + item.name + '</p></div>');
		div.click(function(){
			var id = $(this).attr('data-id');
			$.cookie('community', id);
			console.log(id);
			window.location.href = 'app/shoppinglist';
		});
		$('#select-communities .list').append(div);
		
		var row = $('<tr data-id="' + item.id + '">'+
	        '<td><input type="checkbox"></td>'+
	        '<td>' + item.name + '</td>'+
	        '<td class="buttons">'+
	            '<button type="button" class="btn btn-default edit"><span class="glyphicon glyphicon-pencil"></span></button>'+
	            '<button type="button" class="btn btn-default btn-danger remove"><span class="glyphicon glyphicon-remove"></span></button>'+
	        '</td>'+
	    '</tr>');
		
		$('#edit-communities tbody').append(row);
		
	}

})(jQuery);