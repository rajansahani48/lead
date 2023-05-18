$(document).on('change', '.selectstatus', function (event) {
    event.preventDefault();
    var leadId = $(this).attr("data-leadId");
    $.ajax({
        url: "select-status",
        method: "get",
        data: $('#status').serialize(),
        dataType: 'json',
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-Token': "{{ csrf_token() }}"
        },
        processData: false,
        success: function (data) {
            $(`.data_${leadId}`).remove();
            Swal.fire({
                position: 'center-center',
                icon: 'success',
                title: 'Lead Updated Successfully!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
});
