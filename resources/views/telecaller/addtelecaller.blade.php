{{-- Adding New Telecaller --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <div class="container">
        <form action="{{ route('telecaller.store') }}" method="POST" id="formsvalue">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="name" id="name"
                    value="{{ old('name') }}" />
                <label class="required">Name</label><span id="txterr"></span>
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="phone" value="{{ old('phone') }}" />
                <label class="required">Phone</label>
                <span class="text-danger">
                    @error('phone')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="country_code"
                    value="{{ old('country_code') }}" />
                <label>Country Code</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" placeholder="name" name="address" value="{{ old('address') }}" />
                <label>Address</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="email" placeholder="name@example.com" name="email" id="email"
                    value="{{ old('email') }}" />
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
                        <input class="form-control" id="password" type="password" placeholder="Create a password"
                            name="password" value="{{ old('password') }}" />
                        <label for="inputPassword" class="required">Password</label>
                        <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="confirmpassword" type="password" placeholder="Confirm password"
                            name="confirmpassword" value="{{ old('confirmpassword') }}" />
                        <label for="inputPasswordConfirm" class="required">Confirm Password</label>
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
                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/telecaller/telecaller.js') }}"></script>
@endsection
