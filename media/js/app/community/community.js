(function($) {

	$.removeCookie('community');
	
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
	
	$('#edit-community-dialog form').submit(function(){
		var id = $(this).parent().parent().attr('data-id');
		var name = $('#edit-community-name').val();
		$(this).find(':input').prop('disabled', true);
		
		$.ajax({
			url: '/api/v1/community/' + id,
			method: 'put',
			data: {name: name},
			success: function(){
				$('#edit-communities [data-id=' + id + '] .name').html(name);
				$('#select-communities [data-id=' + id + '] .title').html(name);
				$('#edit-community-dialog form :input').prop('disabled', false);
				$('#edit-community-dialog').modal('hide');
			},
			error: function(){
				$('#edit-community-dialog form :input').prop('disabled', false);
				$('#edit-community-error-message').removeClass('hide');
			}
		});
		
		return false;
	});

	$('#delete-community-dialog form').submit(function(){
		var id = $(this).parent().parent().attr('data-id');
		
		$.ajax({
			url: '/api/v1/community/' + id,
			method: 'delete',
			success: function(){
				$('#edit-communities [data-id=' + id + ']').remove();
				$('#select-communities [data-id=' + id + ']').remove();
				$('#delete-community-dialog').modal('hide');
			},
			error: function(){
				$('#delete-community-error-message').removeClass('hide');
			}
		});
		
		return false;
	});
	
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
			window.location.href = 'app/shoppinglist';
		});
		$('#select-communities .list').append(div);
		
		var notificationCheckbox = $('<input type="checkbox" class="notification-flag">');
		var editButton = $('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button>');
		var deleteButton = $('<button type="button" class="btn btn-default btn-danger"><span class="glyphicon glyphicon-remove"></span></button>');
		
		var row = $('<tr data-id="' + item.id + '">' +
	        '<td></td>' +
	        '<td class="name">' + item.name + '</td>' +
	        '<td class="buttons"></td>' +
	    '</tr>');
		
		row.find('td:first-child').append(notificationCheckbox);
		
		if(item.administrator == '1'){
			row.find('td:last-child').append(editButton).append(deleteButton);
		}
		
		$('#edit-communities tbody').append(row);
		
		notificationCheckbox.change(function(){
			$.ajax({
				url: '/api/v1/community/' + item.id,
				data: {receiveNotifications: $(this).prop('checked')},
				method: 'put'
			});
		});

		editButton.click(function(){
			$('#edit-community-error-message').addClass('hide');
			$('#edit-community-name').val(row.find('.name').html());
			$('#edit-community-dialog').attr('data-id', item.id);
			$('#edit-community-dialog').modal('show');
		});
		
		deleteButton.click(function(){
			$('#delete-community-error-message').addClass('hide');
			$('#delete-community-name').html(row.find('.name').html());
			$('#delete-community-dialog').attr('data-id', item.id);
			$('#delete-community-dialog').modal('show');
		});
		
	}

})(jQuery);