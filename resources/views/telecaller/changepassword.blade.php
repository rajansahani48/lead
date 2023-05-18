{{-- Chnage Password For Both Module --}}
@extends('master')
<link href="{{ asset('css/telecaller/changepassword.css') }}" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@section('main-content')
    <main>
        <form method="post" action="{{ route('updatechangepassword', ['id' => auth()->user()->id]) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="user_id" value={{ auth()->user()->id }}>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Enter Old Password</label>
                <input type="password" class="form-control" name="oldPassword">
                <span class="text-danger">
                    @error('oldPassword')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Enter New Password</label>
                <input type="password" class="form-control" name="newPassword">
                <span class="text-danger">
                    @error('newPassword')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Enter New Confirm Password</label>
                <input type="password" class="form-control" name="newConfirmPassword">
                <span class="text-danger">
                    @error('newConfirmPassword')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
@endsection
