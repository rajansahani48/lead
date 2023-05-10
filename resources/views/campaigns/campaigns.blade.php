{{-- Campagin list  --}}
@extends('master')
<style>
    .item {
        text-align: center;
    }

    #heading {
        margin-top: 15px;
        background-color: #d8dde2;
        font-family: serif;
    }

    #btntelecaller {
        float: right;
        margin-right: 10px;
    }

    #file {
        width: 50%;
    }

    #csv {
        width: 20%;
        padding-left: 60px;
    }

    #deletebtn {
        margin: -15px;
    }

    #action {
        padding-left: 90px;
    }

    .required:after {
        content: " *";
        color: red;
    }
</style>

@section('main-content')
    <center>
        <h2 id="heading">Campaign's Details</h2>
    </center>
    <main class="m-4">
        <a href="{{ route('campaign.create') }}"><button type="button" id="btntelecaller" class="btn btn-primary">Add
                Campaign</button></a>
        <table class="table table-bordered table-striped table-hover" style="margin-top: 60px;">
            <thead>
                <tr class="item">
                    <th scope="col">Campaign Name</th>
                    <th scope="col">Campaign Description</th>
                    <th scope="col">Cost Per Lead</th>
                    <th scope="col">Conversion Cost</th>
                    <th scope="col">Telecaller</th>
                    <th scope="col">Leads</th>
                    <th scope="col">Pending </th>
                    <th scope="col">Procced </th>
                    <th scope="col" id="action">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($camp as $val)
                    <tr class="item">
                        <td>{{ $val->campaign_name }}</td>
                        <td>{{ $val->campaign_desc }}</td>
                        <td>{{ $val->cost_per_lead }}</td>
                        <td>{{ $val->conversion_cost }}</td>
                        <td>{{ count($val->CampaignHasUser) }}</td>
                        <td>{{ count($val->hasManyLeads) }}</td>
                        <td>{{ count($val->PendingLeads) }}</td>
                        <td>{{ count($val->ProccedLeads) }}</td>
                        <td>
                            <div class="row" id="upload_area" style="display: inline-block;width: 75;">
                                <form method="POST" class="upload_form" enctype="multipart/form-data">
                                    @csrf
                                    <label for="inputcsv{{ $val->id }}">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/826px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png"
                                            style="height: 30px; width: 30px; display:inline-block;margin-left:-15px"
                                            data-toggle="tooltip" data-placement="top" title="Upload CSV" />
                                    </label>
                                    <input class="form-control file" type="file" name="file"
                                        id="inputcsv{{ $val->id }}" data-campaign_id={{ $val->id }}
                                        style="display: none" />
                                </form>
                            </div>
                            <form method="POST" action="{{ route('campaign.destroy', [$val->id]) }}"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="deletebtn" class="btn btn-danger deleteBtn"
                                    data-campaign_id={{ $val->id }}><i class="fa fa-trash" aria-hidden="true"
                                        data-toggle="tooltip" data-placement="top" title="Delete Campaign"></i></button>
                            </form>
                            <a href="{{ route('campaign.edit', [$val->id]) }}" class="btn btn-primary"><i
                                    class="fas fa-edit" data-toggle="tooltip" data-placement="top"
                                    title="Edit Campaign"></i></a>
                            <a href="{{ route('campaign.show', [$val->id]) }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-eye" data-toggle="tooltip" data-placement="top"
                                    title="Working Telecaller"></i></a>
                            <button type="button" class="btn btn-success addlead" id="addlead"
                                data-campaign_id={{ $val->id }}><i class="fa-solid fa-plus" style="color: #161817;"
                                    data-toggle="tooltip" data-placement="top" title="Add Single Lead"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $camp->links() }}

        {{-- insert csv --}}
        <div class="modal fade" id="csvModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> CSV Mapping</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="csvform">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <h4>Lead's </h4>
                                </div>
                                <div class="col-6">
                                    <h4>Csv Details</h4>
                                </div>
                            </div>

                            @foreach ($columns as $key => $val)
                                <div class="row">
                                    <input type="hidden" id="campaign_id" name="campaign_id" />
                                    <div class="col-6"><select class="form-select set_column_data"
                                            name="selectleadcolumn[]" id="selectlead" style="display:flex;margin: 5px;"
                                            data-column_number="{{ $key }}">
                                            <option value="">select</option>
                                            @foreach ($columns as $option)
                                                <option value="{{ $option }}">
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select set_csv_data" name="selectcsvcolumn[]"
                                            id="mySelect_{{ $val }}" style="display:flex;margin: 5px;"
                                            data-column_number="{{ $key }}">
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="csvFirstRow" value="true"
                                    id="csvFirstRow">
                                <label class="form-check-label" for="csvFirstRow">
                                    Take First Row
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="import"
                                    id="import">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- add single lead modal --}}
        <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Lead</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="leadsdetails">
                            @csrf
                            <input type="hidden" id="campaigns_id" name="campaign_id" />
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="required" class="col-form-label">Phone</label>
                                <input type="number" class="form-control" name="phone">
                            </div>
                            <select class="form-select" name="leadusermodal" id="leadusermodal"
                                style="display:flex;margin: 5px;">
                            </select>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="storelead">Add Lead</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        //for csv uploading
        var dbColumn = <?php echo json_encode($columns); ?>;
        var file = '';
        var campaign_id = '';

        $(document).ready(function() {
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
        });
    </script>

@endsection
