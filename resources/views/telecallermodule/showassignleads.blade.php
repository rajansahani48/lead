{{-- for showing which leads assign to particular telecaller --}}
@extends('master')
<style>
    .container {
        margin-top: 30px;
    }

    .item {
        text-align: center;
    }

    option {
        font-weight: 500;
    }

    .form-select {
        font-weight: 600;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <main>
        <div class="container">
            <div class="row">
                <form method="POST" action="{{ route('showFilterleads') }}" style="display: flex;" id="searchleads">
                    @csrf
                    <div class="col-5">
                        <h3><span class="badge badge-secondary" style="margin-left: 150;">Campaing's List</span></h3>
                        <select class="form-select" name="campaign_id" id="leadusermodal"
                            style="display:flex;margin: 5px;  ">
                            <option value="">Select</option>
                            @foreach ($finalArray as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <h3><span class="badge badge-secondary" style="margin-left: 150;">Lead's Status</span></h3>
                        <select class="form-select" name="status" id="leadusermodal" style="display:flex;margin: 5px;">
                            <option value="">Select</option>
                            <option value="pending">pending</option>
                            <option value="in progress">in progress</option>
                            <option value="on hold">on hold</option>
                            <option value="converted">converted</option>
                        </select>
                    </div>
                    <div class="col-2" style="margin-top: 42;">
                        <button type="submit" class="btn btn-outline-dark">Search Leads</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="card mb-4">
                <div class="card-header">
                    <center>
                        <h4>Lead's Details</h4>
                    </center>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr class="item">
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($leadsDetails))
                            @foreach ($leadsDetails as $val)
                                <tr class="data_{{ $val['id'] }}" style="text-align: center;">
                                    <td>{{ $val['name'] }}</td>
                                    <td>{{ $val['email'] }}</td>
                                    <td>{{ $val['phone'] }}</td>
                                    @if ($val['status'] == 'pending')
                                        <td style="width: 185;">
                                            <form id="status">
                                                <input type="hidden" id="telecaller_id" name="telecaller_id"
                                                    value="{{ auth()->user()->id }}" />
                                                <input type="hidden" id="lead_id" name="lead_id"
                                                    value="{{ $val['id'] }}" />
                                                <input type="hidden" id="campaignId" name="campaignId"
                                                    value="{{ $campaignId }}" />
                                                <select class="form-select selectstatus" name="status" id="selectstatus"
                                                    style="display:flex;MARGIN-LEFT: -25PX;margin-top: -22; font-weight:600"
                                                    data-leadId="{{ $val['id'] }}">
                                                    <option value="pending">pending</option>
                                                    <option value="in progress">in progress</option>
                                                    <option value="on hold">on hold</option>
                                                    <option value="converted">converted</option>
                                                </select>
                                            </form>
                                        </td>
                                    @elseif($val['status'] == 'converted')
                                        <td>
                                            <h4><span class="badge bg-success">Converted</span></h4>
                                        </td>
                                    @elseif($val['status'] == 'in progress')
                                        <td>
                                            <h4><span class="badge bg-warning">in progress</span></h4>
                                        </td>
                                    @elseif($val['status'] == 'on hold')
                                        <td>
                                            <h4><span class="badge bg-danger">on hold</span></h4>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.selectstatus', function(event) {
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
                    success: function(data) {
                        $(`.data_${leadId}`).remove();
                        Swal.fire({
                            position: 'center-center',
                            icon: 'success',
                            title: 'Lead Updated Successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection
