{{-- Edit Telecaller  --}}
@extends('master')
<style>
    form {
        margin: 10px;
    }

    span {
        color: red;
    }

    .required:after {
        content: " *";
        color: red;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <form method="POST" action="{{ route('telecaller.update', ['telecaller' => $obj->id]) }}" id="formsvalue">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-floating mb-3">
            <input class="form-control" type="text" placeholder="name" name="name" id="name"
                value="{{ $obj->name }}" />
            <label class="required">Name</label><span id="txterr"></span>
            <span class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" placeholder="name" name="phone" value="{{ $obj->phone }}" />
            <label>Phone</label>
            <span class="text-danger">
                @error('phone')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" placeholder="name" name="countrycode"
                value="{{ $obj->country_code }}" />
            <label>Country Code</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" placeholder="name" name="address" value="{{ $obj->address }}">
            <label>Address</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="email" placeholder="name@example.com" name="email" id="email"
                value="{{ $obj->email }}" />
            <label class="required">Email address</label><span id="txterremail"></span>
            <span class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputPassword" type="password" placeholder="Create a password"
                        name="password" />
                    <label class="required">Password</label>
                    <span class="text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password"
                        name="confirmpassword" />
                    <label class="required">Confirm Password</label>
                    <span class="text-danger">
                        @error('confirmpassword')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
        </div>
        <div class="mt-4 mb-0">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block">Update Account</button>
            </div>
        </div>
    </form>

    <script src="{{ asset('assets/js/telecaller/telecaller.js') }}"></script>
@endsection
