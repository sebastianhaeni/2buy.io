(function($) {
    'use strict';

    var editingCommunityName = null;

    $.removeCookie('community');

    $('#new-community-btn').click(function() {
        $('#new-community-name').val('');
        $('#new-community-dialog').modal('show');
    });

    $('#new-community-form').submit(function() {
        var name = $('#new-community-name').val();
        $('#new-community-form :input').prop('disabled', true);

        $.ajax({
            url : '/api/v1/community',
            method : 'post',
            data : {
                name : name
            },
            success : function(response) {
                $('#new-community-name').val('');
                $('#new-community-form :input').prop('disabled', false);
                $('#new-community-dialog').modal('hide');
                loadCommunities();
            },
            error : function() {
                $('#new-community-form :input').prop('disabled', false);
                $('#new-community-error-message').removeClass('hide');
            }
        });

        return false;
    });

    $('#edit-community-name')
            .on(
                    'keyup',
                    function() {
                        $('#edit-community-name-form button[type=submit]')
                                .prop(
                                        'disabled',
                                        $('#edit-community-name').val() == editingCommunityName);
                    });

    $('#edit-community-name-form').submit(
            function() {
                var id = $('#edit-community-dialog').attr('data-id');
                var name = $('#edit-community-name').val();
                $(this).find(':input').prop('disabled', true);

                $.ajax({
                    url : '/api/v1/community/' + id,
                    method : 'put',
                    data : {
                        name : name
                    },
                    success : function() {
                        $('#community-list [data-id=' + id + '] .title').html(
                                name);
                        $('#edit-community-name-error-message')
                                .addClass('hide');
                        $('#edit-community-name-form :input').prop('disabled',
                                false);
                        editingCommunityName = name;
                        $('#edit-community-name-form button[type=submit]')
                                .prop('disabled', true);
                    },
                    error : function() {
                        $('#edit-community-name-form :input').prop('disabled',
                                false);
                        $('#edit-community-name-error-message').removeClass(
                                'hide');
                    }
                });

                return false;
            });

    $('#edit-community-invite-email').on(
            'keyup',
            function() {
                $('#edit-community-invite-form button[type=submit]').prop(
                        'disabled',
                        !$('#edit-community-invite-email')[0].checkValidity());
            });

    $('#edit-community-invite-form').submit(
            function() {
                var id = $('#edit-community-dialog').attr('data-id');
                var email = $('#edit-community-invite-email').val();
                $(this).find(':input').prop('disabled', true);

                $.ajax({
                    url : '/api/v1/community/' + id + '/invite',
                    method : 'post',
                    data : {
                        email : email
                    },
                    success : function() {
                        $('#edit-community-invite-error-message').addClass(
                                'hide');
                        $('#edit-community-invite-form :input').prop(
                                'disabled', false);
                        $('#edit-community-invite-form button[type=submit]')
                                .prop('disabled', true);
                        $('#edit-community-invite-email').val('').focus();
                    },
                    error : function() {
                        $('#edit-community-invite-form :input').prop(
                                'disabled', false);
                        $('#edit-community-invite-error-message').removeClass(
                                'hide');
                    }
                });

                return false;
            });

    $('#delete-community-form').submit(function() {
        var id = $(this).parent().parent().attr('data-id');

        $.ajax({
            url : '/api/v1/community/' + id,
            method : 'delete',
            success : function() {
                $('#community-list [data-id=' + id + ']').remove();
                $('#delete-community-dialog').modal('hide');
            },
            error : function() {
                $('#delete-community-error-message').removeClass('hide');
            }
        });

        return false;
    });

    loadCommunities();

    function loadCommunities() {
        $('#community-list .list').html('');
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

        var div = $('<div class="input-group item clickable" data-id="'
                + item.id
                + '">'
                + '<span class="input-group-addon"><input type="checkbox" class="notification-flag"> <span class="glyphicon glyphicon-envelope"></span></span>'
                + '<span class="form-control title">' + item.name
                + '</span></div>');

        if (item.administrator == '1') {
            var editButton = $('<button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>');
            var deleteButton = $('<button type="button" class="btn btn-default btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></button>');

            var buttonContainer = $('<span class="input-group-addon"></span>');
            buttonContainer.append(editButton).append(' ').append(deleteButton);
            div.append(buttonContainer);

            editButton.click(function() {
                editingCommunityName = item.name;

                loadMembers(item.id);
                loadInvites(item.id);

                $('#edit-community-name-error-message').addClass('hide');
                $('#edit-community-name').val(item.name);
                $('#edit-community-dialog').attr('data-id', item.id);
                $('#edit-community-dialog').modal('show');
            });

            deleteButton.click(function() {
                $('#delete-community-error-message').addClass('hide');
                $('#delete-community-name').html(item.name);
                $('#delete-community-dialog').attr('data-id', item.id);
                $('#delete-community-dialog').modal('show');
            });
        }

        div.find('.title').click(function() {
            var id = $(this).attr('data-id');
            $.cookie('community', id);
            window.location.href = 'app/shoppinglist';
        });

        div.find('input[type=checkbox].notification-flag').prop('checked',
                item.receiveNotifications == '1').change(function() {
            $.ajax({
                url : '/api/v1/community/' + item.id,
                data : {
                    receiveNotifications : $(this).prop('checked')
                },
                method : 'put'
            });
        });

        $('#community-list .list').append(div);

    }

    function loadMembers(communityId) {
        $('#member-list').html('');
        $.ajax({
            url : '/api/v1/community/' + communityId + '/member',
            success : function(response) {
                $.each(response, function(i, item) {
                    addMember(item);
                });
            }
        });
    }

    function loadInvites(communityId) {
        $('#invite-list').html('');
        $.ajax({
            url : '/api/v1/community/' + communityId + '/invite',
            success : function(response) {
                $.each(response, function(i, item) {
                    addInvite(item);
                });
            }
        });
    }

    function addMember(member) {
        var div = $('<div class="item input-group" data-id="'
                + member.id
                + '">'
                + '<span class="input-group-addon"><label><input type="checkbox" class="admin-flag" '
                + (member.isCurrentUser ? 'disabled' : '')
                + '> Admin</label></span>'
                + '<span class="form-control title">' + member.name
                + ' <small>&lt;' + member.email + '&gt;</small>'
                + '</span></div>');

        var deleteButton = $('<button type="button" class="btn btn-default btn-xs btn-danger" '
                + (member.isCurrentUser ? 'disabled' : '')
                + '><span class="glyphicon glyphicon-remove"></span></button>');

        var buttonContainer = $('<span class="input-group-addon"></span>');
        buttonContainer.append(deleteButton);
        div.append(buttonContainer);

        div.find('.admin-flag').prop('checked', member.admin == '1');

        deleteButton.click(function() {
            $('#delete-member-name').html(member.name);
            $('#delete-invite-dialog').attr('data-community-id',
                    member.communityId).attr('data-id', member.id)
                    .modal('show');
        });

        $('#member-list').append(div);

    }

    function addInvite(invite) {
        var div = $('<div class="item input-group" data-id="' + invite.id
                + '">' + '<span class="form-control title">' + invite.email
                + '</span></div>');

        var deleteButton = $('<button type="button" class="btn btn-default btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></button>');

        var buttonContainer = $('<span class="input-group-addon"></span>');
        buttonContainer.append(deleteButton);
        div.append(buttonContainer);

        deleteButton.click(function() {
            $('#delete-invite-name').html(invite.email);
            $('#delete-invite-dialog').attr('data-community-id',
                    invite.communityId).attr('data-id', invite.id)
                    .modal('show');
        });

        $('#invite-list').append(div);
    }

    $('#delete-member-form').submit(function() {
        var id = $('#delete-member-dialog').attr('data-id');
        var communityId = $('#delete-member-dialog').attr('data-community-id');

        $.ajax({
            url : '/api/v1/community/' + communityId + '/member/' + id,
            method : 'delete',
            success : function() {
                $('#member-list [data-id=' + id + ']').remove();
                $('#delete-member-dialog').modal('hide');
            },
            error : function() {
                $('#delete-member-error-message').removeClass('hide');
            }
        });

        return false;
    });

    $('#delete-invite-form').submit(function() {
        var id = $('#delete-invite-dialog').attr('data-id');
        var communityId = $('#delete-invite-dialog').attr('data-community-id');

        $.ajax({
            url : '/api/v1/community/' + communityId + '/invite/' + id,
            method : 'delete',
            success : function() {
                $('#invite-list [data-id=' + id + ']').remove();
                $('#delete-invite-dialog').modal('hide');
            },
            error : function() {
                $('#delete-invite-error-message').removeClass('hide');
            }
        });

        return false;
    });

})(jQuery);
