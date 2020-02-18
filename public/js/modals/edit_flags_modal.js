$table = $($activity_table);
$table.on('click', '#ajax_edit_flags_open', function () {
    var id = $(this).val();
    $('#save_flags').val(id).change();

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

            if (flags[0][2]) {
                $("#save_flags").prop('disabled', true);
                $("#resolve-self-flag").prop('checked', true).prop('disabled', true);
                $("#resolve-auto-flag").prop('checked', true).prop('disabled', true);
                if (flags[1][2][0] === "No details.") {
                    $('#resolve-self-flag-details').attr('placeholder', flags[1][2][0]).attr('rows', 1).show().prop('disabled', true).val("");
                } else {
                    $('#resolve-self-flag-details').val(flags[1][2][0]).attr('rows', 6).show().prop('disabled', true);
                }
                if (flags[1][2][1] === "No details.") {
                    $('#resolve-auto-flag-details').attr('placeholder', flags[1][2][1]).attr('rows', 1).show().prop('disabled', true).val("");
                } else {
                    $('#resolve-auto-flag-details').val(flags[1][2][1]).attr('rows', 6).show().prop('disabled', true);
                }
            } else {
                $('#resolve-self-flag-details').val("");
                $('#resolve-auto-flag-details').val("");
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
    var id = $('#save_flags').val();
    var self_resolve_reason = $('#resolve-self-flag-details').val();
    var auto_resolve_reason = $('#resolve-auto-flag-details').val();
    $('#resolve-self-flag-details').hide();
    $('#resolve-auto-flag-details').hide();

    $.ajax({
        type: 'POST',
        url: $url_edit_flags_POST + id,
        data: {self_resolve_reason: self_resolve_reason, auto_resolve_reason: auto_resolve_reason},
        success: function() {
            $('#ajax_edit_flags_cancel').click();
            var toast_heading = "Flags Updated!";
            var toast_text = "This patrol log has been updated and the new data has been sent to the database!";
            var toast_icon = "success";
            var toast_color = "#43f93d";
            globalToast(toast_heading, toast_text, toast_icon, toast_color);

            if ($('#tableElement').length) {
                $('#tableElement').DataTable().ajax.reload();
            }
        },
        error: function(data) {
            var toast_heading = "Flags Update Failed!";
            var toast_text = "Flags update failed, this is likely due to an internal error. Please report this issue.";
            var toast_icon = "error";
            var toast_color = "#f2a654";
            globalToast(toast_heading, toast_text, toast_icon, toast_color);

            var errors = data['responseJSON'].errors;
            console.log(errors);
        }
    });
});
