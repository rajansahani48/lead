{{-- creating campaign
@extends('master')
<link href="{{ asset('css/campaign/addcampaigns.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <div class="container">
        <form action="{{ route('campaign.store') }}" method="POST" id="formsvalue" class="upload_form"
            enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="campaign_name" id="campaign_name" maxlength = "50"
                    value="{{ old('campaignname') }}" />
                <label class="required">Campaign name</label>
                <span id="txterr"></span>
                <span class="text-danger">
                    @error('campaign_name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="campaign_desc"  maxlength = "120"
                    value="{{ old('campaign_des') }}" />
                <label>Campaign description</label>
                <span class="text-danger">
                    @error('campaign_desc')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="number" placeholder="name" name="cost_per_lead" id="cost_per_lead"
                    value="{{ old('cost_per_lead') }}" />
                <label class="required">Cost Per Lead</label>
                <div class="errorTxt"></div>
                <span class="text-danger">
                    @error('cost_per_lead')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="number" placeholder="name" name="conversion_cost" id="conversion_cost"
                    value="{{ old('conversion_cost') }}" />
                <label class="required">Conversion Cost</label>
                <span class="text-danger">
                    @error('conversion_cost')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <label class="required" style="margin-top: 10px;">Select Telecaller</label>
            <select class="selectpicker" multiple data-live-search="true" name="telecaller_id[]" style="margin-left: 100px"
                style="margin-left: 15px;">
                @foreach ($camp as $val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                @endforeach
            </select>
            <span class="text-danger">
                @error('telecaller_id')
                    {{ $message }}
                @enderror
            </span>
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Create Campaign</button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/campaigns/addcampaign.js') }}"></script>
@endsection --}}
