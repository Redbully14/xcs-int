$table = $($activity_table);
$table.on('click', '#ajax_edit_flags_open', function () {

    var id = $(this).val();

    $.ajax({
        type: "POST",
        url: $url_edit_flags+id,
        success: function(data){
            console.log(data);
            $("#ajax_edit_flags").modal("toggle");
            var flags = JSON.parse(data);
            if (flags[0][0]) {
                $("#ajax-span-self-flag-viewer").html('Yes').css('color', 'red');
                $("#ajax-textarea-self-flag-viewer").val(flags[1][0]).attr('rows', 6);

                $("#resolve-self-flag").prop('checked', false).prop('disabled', false);
            } else {
                $("#ajax-span-self-flag-viewer").html('No').css('color', '');
                $("#ajax-textarea-self-flag-viewer").val(flags[1][0]).attr('rows', 1);

                $("#resolve-self-flag").prop('checked', true).prop('disabled', true);
            }
            if (flags[0][1]) {
                $("#ajax-span-auto-flag-viewer").html('Yes').css('color', 'red');
                $("#ajax-textarea-auto-flag-viewer").val(flags[1][1]).attr('rows', 6);

                $("#resolve-auto-flag").prop('checked', false).prop('disabled', false);
            } else {
                $("#ajax-span-auto-flag-viewer").html('No').css('color', '');
                $("#ajax-textarea-auto-flag-viewer").val(flags[1][1]).attr('rows', 1);

                $("#resolve-auto-flag").prop('checked', true).prop('disabled', true);
            }

            if (flags[0][0] || flags[0][1]) {
                $("#save_flags").prop('disabled', false);
            } else {
                $("#save_flags").prop('disabled', true);
            }
        }
    }).done(function(data) {});
});

$(document).on('click', 'input[id="resolve-self-flag"]', function() {
    let area = $('#resolve-self-flag-details');
    if (this.checked) {
        area.show();
    } else {
        area.hide();
    }
});

$(document).on('click', 'input[id="resolve-auto-flag"]', function() {
    let area = $('#resolve-auto-flag-details');
    if (this.checked) {
        area.show();
    } else {
        area.hide();
    }
});

$('#ajax_edit_flags').on('submit', function(e) {
    e.preventDefault();
    var id = $('#ajax_edit_member_save').val();
    var name = $('#profile-name-field').val();
    var website_id = $('#profile-website-id-field').val();
    var department_id = $('#profile-department-id-field').val();
    var rank = $('#profile-rank-field').val();
    var antelope_status = $("#profile-active-field").prop("checked") ? 1 : 0;
    var username = $('#profile-username-field').val();
    var role = $('#profile-role-field').val();
    var advanced_training = $("#profile-training-field").prop("checked") ? 1 : 0;
    var requirements_exempt = $("#profile-exempt-field").prop("checked") ? 1 : 0;

    $.ajax({
        type: 'POST',
        url: $url_edit_profile_modal_POST + id,
        data: {name:name, website_id:website_id, department_id:department_id, rank:rank, antelope_status:antelope_status, username:username, role:role, advanced_training:advanced_training, requirements_exempt:requirements_exempt},
        success: function() {
            for (var element in elements) {
                $(element).parent().removeClass('has-danger');
                $(element).removeClass('form-control-danger');
                $(elements[element]).prop('hidden', true);
                $(elements[element]).empty();
            }
            showSuccessToast_EditMember();
            if ($('#tableElement').length) {
                $('#tableElement').DataTable().ajax.reload();
            }
        },
        error: function(data) {
            for (var element in elements) {
                $(element).parent().removeClass('has-danger');
                $(element).removeClass('form-control-danger');
                $(elements[element]).prop('hidden', true);
                $(elements[element]).empty();
            }
            showFailToast_EditMember();
            var errors = data['responseJSON'].errors;
            console.log(errors);

            for (var key in errors) {
                switch (key) {
                    case 'name':
                        var element = '#profile-name-field';
                        var label = '#edit-name-error';
                        $(element).parent().addClass('has-danger');
                        $(element).addClass('form-control-danger');
                        $(label).append(errors[key]);
                        $(label).prop('hidden', false);
                        break;
                    case 'website_id':
                        var element = '#profile-website-id-field';
                        var label = '#edit-website_id-error';
                        $(element).parent().addClass('has-danger');
                        $(element).addClass('form-control-danger');
                        $(label).append(errors[key]);
                        $(label).prop('hidden', false);
                        break;
                    case 'username':
                        var element = '#profile-username-field';
                        var label = '#edit-username-error';
                        $(element).parent().addClass('has-danger');
                        $(element).addClass('form-control-danger');
                        $(label).append(errors[key]);
                        $(label).prop('hidden', false);
                        break;
                }
            }
        }
    });
});
