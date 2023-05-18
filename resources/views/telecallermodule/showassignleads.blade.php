{{-- for showing which leads assign to particular telecaller --}}
@extends('master')
<link href="{{ asset('css/telecallermodule/showassignleads.css') }}" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <main>
        <div class="container">
            <div class="row">
                <form method="get" action="{{ route('showlead') }}" style="display: flex;" id="searchleads">
                    <div class="col-5">
                        <h3><span class="badge badge-secondary title" style="margin-left: 150;" >Campaing's List</span></h3>
                        <select class="form-select" name="campaign_id" id="leadusermodal"
                            style="display:flex;margin: 5px;  ">
                            <option value="">@if (isset($campaigName)) {{$campaigName[0]}}  @else Select @endif</option>
                            @foreach ($finalArray as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-5">
                        <h3><span class="badge badge-secondary title"  style="margin-left: 150;">Lead's Status</span></h3>
                        <select class="form-select" name="status" id="leadusermodal" style="display:flex;margin: 5px;margin-left: 15;">
                            <option value="">@if (isset($status)) {{$status}}  @else Select @endif</option>
                            <option value="pending">pending</option>
                            <option value="in progress">in progress</option>
                            <option value="on hold">on hold</option>
                            <option value="converted">converted</option>
                        </select>
                    </div>
                    <div class="col-2" style="margin-top: 42;">
                        <button type="submit" class="btn btn-outline-dark" style="margin-left: 20px;">Search Leads</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <table class="table table-bordered table-striped table-hover">
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
                    @if (count($leadsDetails) == 0)
                        <tr class="item">
                            <td colspan="4" style="color:rgb(91, 85, 85)">
                                <h6>No Leads's Found</h6>
                            </td>
                        </tr>
                    @else
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
                                                <option selected value="in progress">in progress</option>
                                                <option value="on hold">on hold</option>
                                                <option value="converted">converted</option>
                                            </select>
                                        </form>
                                    </td>
                                @elseif($val['status'] == 'on hold')
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
                                                <option  value="in progress">in progress</option>
                                                <option selected value="on hold">on hold</option>
                                                <option value="converted">converted</option>
                                            </select>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @endif
                        @endif
                </tbody>
            </table>
            <div class="row">
                    @if(isset($leadsDetails))
                    {{ $leadsDetails->appends(request()->query())->links()  }}
                    @endif
            </div>
        </div>
    </main>
    <script src="{{ asset('assets/js/telecallermodule/showassignleads.js') }}"></script>
@endsection
