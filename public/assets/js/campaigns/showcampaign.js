$(".deleteBtn").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to get this data Again!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            telecaller_id = $(this).data('telecaller_id');
            campaign_id=$(this).data('campaign_id');
            deleteTelecallerUrl = '/deletetelecaller/' +campaign_id +'/'+telecaller_id;

            console.log(deleteTelecallerUrl);
            $.ajax({
                url: deleteTelecallerUrl,
                type: "delete",
                data: telecaller_id,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'X-CSRF-Token':$('#deletecsrf').val()
                },
                success: function (data) {
                    if (data.deleteTelecallerError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "You Can't Delete this Telecaller Due To Incomplete Task!!",
                        })
                    } else {
                        Swal.fire(
                            'Deleted!',
                            'Telecaller has been deleted.',
                            'success'
                        ).then(function () {
                            location.reload();
                        });
                    }
                }
            })
        }
    })
});
