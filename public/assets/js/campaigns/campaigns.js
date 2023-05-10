// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

// $(document).ready(function() {
    $(".file").on('change', function(e) {
        campaign_id = $(this).data('campaign_id');
        var formData = new FormData();
        file = $(this)[0].files[0];
        formData.append('file', file);
        formData.append('campaign_id', campaign_id);
        $.ajax({
            url: "upload",
            method: "POST",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            },
            processData: false,
            success: function(data) {
                if (data.wrongfile) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Choose Only CSV file!',
                    }).then(function() {
                        location.reload();
                    });
                } else if (data.telecallerEmpty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There Is No More Telecaller In This Campaign Please Add Telecaller!',
                    }).then(function() {
                        location.reload();
                    });
                } else if (data.blankCsv) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Csv File is Empty!',
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    $("#csvModal").modal('show');
                    $("#campaign_id").val(campaign_id);
                    var html = "<option value=''>select</option>";
                    $.each(data.csvheader, function(val, text) {
                        html += "<option value=" + val + ">" + text +
                            "</option>";
                    });
                    $.each(dbColumn, function(key, value) {
                        $('#mySelect_' + value).html(html);
                    });
                }
            }
        });
    });

    //validation on lead table so user can't choose same column twice
    $(document).on('change', '.set_column_data', function() {
        var selectedOption = $(this);
        var column_name = selectedOption.val();
        console.log(column_name);

        var column_number = selectedOption.data('column_number');
        console.log(column_number);

        $('.set_column_data').each(function() {
            if ((column_number != $(this).data('column_number')) && (column_name == $(this)
                    .val())) {
                selectedOption.val('');
                alert('You have already define ' + column_name + ' column');
            }
        });
    });

    //validation on csv so user can't choose same column twice
    $(document).on('change', '.set_csv_data', function() {
        var selectedOption = $(this);
        var column_name = selectedOption.val();
        var column_number = selectedOption.data('column_number');
        $('.set_csv_data').each(function() {
            if ((column_number != $(this).data('column_number')) && (column_name == $(this)
                    .val())) {
                selectedOption.val('');
                alert('You have already define this column');
            }
        });
    });

    //storing csv file's headers(columns)
    $(document).on('click', '#import', function(event) {
        event.preventDefault();
        var csvData = $("#csvform").serializeArray();
        var storCsvColumnName = [];
        $('.set_csv_data').each(function() {
            if ($(this).val() == undefined || $(this).val() == '') {
                storCsvColumnName.push('');
            } else {
                storCsvColumnName.push($(this).val());
            }
        });
        // storing lead table's columns
        var storLeadColumnName = [];
        $('.set_column_data').each(function() {
            if ($(this).val() == undefined || $(this).val() == '') {
                storLeadColumnName.push('');
            } else {
                storLeadColumnName.push($(this).val());
            }
        });

        //import calling after csv file validation for csv uploading into database
        $cb = $('input#csvFirstRow');
        $csvfirstRow = ($cb.prop('checked'));
        var csvfirstRow = $csvfirstRow;
        var formData = new FormData();
        formData.append('file', file);
        formData.append('storCsvColumnName', storCsvColumnName);
        formData.append('storLeadColumnName', storLeadColumnName);
        formData.append('campaign_id', campaign_id);
        formData.append('csvfirstRow', csvfirstRow);
        $.ajax({
            url: "import",
            method: "POST",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            },
            processData: false,
            success: function(data) {
                if (data.choosePhone) {
                    alert("Phone Details Is Required")
                } else {
                    $('#csvModal').modal('hide');
                    Swal.fire(
                        'Inserted Successfully!',
                        " Total Inserted Record " + data.rec + " Out Of " + data
                        .count,
                        'success'
                    ).then(function() {
                        location.reload();
                    });
                }
            }
        })

    });

    //FOR ADDING A SINGLE LEAD FROM USER
    $(".addlead").click(function() {
        campaign_id = $(this).data('campaign_id');
        $.ajax({
            url: "get-campaign-user/" + campaign_id,
            method: "get",
            dataType: 'json',
            success: function(data) {
                $("#leadModal").modal('show');
                $("#campaign_id").val(campaign_id);
                var html = "<option value=''>Select Telecaller</option>";
                $.each(data.usersArray, function(val, text) {
                    html += "<option value=" + text.id + ">" + text.name +
                        "</option>";
                });
                $('#leadusermodal').html(html);
            }
        });
    });

    //UPLOADING SINGLE LEAD FROM USER
    $("#storelead").click(function(event) {
        $('#campaigns_id').val(campaign_id);
        event.preventDefault();
        $.ajax({
            url: 'upload-lead',
            method: "POST",
            data: $("#leadsdetails").serializeArray(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.leadAlert) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Lead Already Exists!',
                    })
                }
                if (data.LeadMessage) {
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: 'Lead Inserted Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                }
                $('#leadModal').modal('hide');
            }
        })
    });

    //deleting campaign make sure that campaign don't have pending leads
    $(".deleteBtn").click(function(e) {
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
                campaign_id = $(this).data('campaign_id');
                var id = campaign_id;
                var url = "{{ route('campaign.destroy', ':id') }}";
                url = url.replace(':id', id);
                console.log(campaign_id);
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: campaign_id,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    },
                    processData: false,
                    success: function(data) {
                        //if campaign have pending leads then it will not allow to delete it
                        if (data.deleteCampaignError) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "You Can't Delete this Campaign Due To Incomplete Task!!",
                            })
                        } //if campaing don't have pending leads  then only u can delete
                        else {
                            Swal.fire(
                                'Deleted!',
                                'Campaign has been deleted.',
                                'success'
                            ).then(function() {
                        location.reload();
                    });
                        }
                    }
                })
            }
        })
    });
// });
