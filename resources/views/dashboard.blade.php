{{-- Common Dashboard for both --}}
@extends('master')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    .main-body {
        padding: 15px;
        margin-top: 15px;
    }
</style>
@section('main-content')
    <main>
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>@php
                                            if (auth()->check()) {
                                                echo auth()->user()->name;
                                            }
                                        @endphp </h4>
                                        <p class="text-secondary mb-1">@php
                                            echo auth()->user()->email;
                                        @endphp</p>
                                        <p class="text-muted font-size-sm">@php
                                            echo auth()->user()->address;
                                        @endphp</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @php
                                            echo auth()->user()->name;
                                        @endphp
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a>@php
                                            echo auth()->user()->email;
                                        @endphp</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @php
                                            echo auth()->user()->phone;
                                        @endphp
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @php
                                            echo auth()->user()->address;
                                        @endphp
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <a  class="btn btn-primary"
                                            href="{{ route('editProfile') }}">Edit Profile</a>
                                    </div>
                                <div class="col-6">
                                        <a  class="btn btn-primary"
                                            href="{{ route('changepassword') }}">Change Password</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row gutters-sm">
                            <div class="col-sm-6 mb-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript"></script>
    </main>
@endsection
