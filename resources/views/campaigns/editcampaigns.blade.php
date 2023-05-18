{{-- Edit Campaign
@extends('master')
<link href="{{ asset('css/campaign/editcampaigns.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <div class="container">
        <form action="{{route('campaign.update',['campaign'=>$camp->id])}}" method="POST" id="formsvalue">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-floating mb-3">
                <input class="form-control"  type="text" placeholder="name" name="campaign_name" id="campaign_name"
                value="{{$camp->campaign_name}}" />
                <label for="inputEmail">Campaign name</label>
                <span id="txterr"></span>
                <span class="text-danger">
                    @error('campaign_name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control"  type="text" placeholder="name" name="campaign_desc" id="campaign_desc"
                value="{{$camp->campaign_desc}}" />
                <label for="inputEmail">Campaign description</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control"  type="number" placeholder="name" name="cost_per_lead" id="cost_per_lead"
                value="{{$camp->cost_per_lead}}" />
                <label for="inputEmail">Cost Per Lead</label>
                <span class="text-danger">
                    @error('cost_per_lead')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control"  type="number" placeholder="name" name="conversion_cost" id="conversion_cost"
                value="{{$camp->conversion_cost}}" />
                <label for="inputEmail">Conversion Cost</label>
                <span class="text-danger">
                    @error('conversion_cost')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <label class="required" style="margin-top: 10px;">Select Telecaller</label>
            <select class="selectpicker" multiple data-live-search="true" name="telecaller_id[]" id="telecaller_id[]">
                @foreach ($campid as $val)
                    <option class="telecallerlist"  value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
            </select>
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Update Campaign</button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/campaigns/editcampaign.js') }}"></script>
@endsection --}}
