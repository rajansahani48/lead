@extends('master')
@section('main-content')

    <div class="container">
        <div class="card text-center mt-5">
            <div class="card-header">
                {{ $telecallerdetails[0]['name'] }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Email:{{ $telecallerdetails[0]['email'] }}</h5>
                <h5 class="card-title">Phone:{{ $telecallerdetails[0]['phone'] }}</h5>
                <h5 class="card-title">Country Code:{{ $telecallerdetails[0]['country_code'] }}</h5>
                <p class="card-text">Address:{{ $telecallerdetails[0]['address'] }}</p>
                <a href="{{ route('editTelecallerProfile', [$telecallerdetails[0]['id']]) }}" class="btn btn-primary">Edit
                    Profile</a>
            </div>
        </div>
    </div>
@endsection
