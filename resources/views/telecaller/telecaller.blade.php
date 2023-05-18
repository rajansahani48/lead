{{-- List of Telecaller --}}
@extends('master')
<link href="{{ asset('css/telecaller/telecaller.css') }}" rel="stylesheet" />
@section('main-content')
    <main>
        <center>
            <h2 id="heading">Telecaller's Details</h2>
        </center>
        {{-- for creating new telecaller --}}
        {{-- <a href="{{ route('telecaller.create') }}"><button type="button" id="btntelecaller" class="btn btn-primary">Add
                Telecaller</button></a> --}}

        <button type="button" class="btn btn-primary" id="btntelecaller" data-bs-toggle="modal"
            data-bs-target="#createTelecaller">
            Add Telecaller
        </button>
        <table class="table table-bordered table-striped table-hover" style="margin-top: 80px;">
            <thead>
                <tr class="item">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Country Code</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($obj))
                @foreach ($obj as $val)
                    <tr class="item">
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->email }}</td>
                        <td>{{ $val->phone }}</td>
                        <td>{{ $val->country_code }}</td>
                        <td>{{ $val->address }}</td>
                        <td>
                            <input type="hidden" id="deletecsrf" name="deletecsrf" value="{{ csrf_token() }}" />
                            <a href="javascript:;" data-telecaller_id={{ $val->id }} class="btn btn-danger deleteBtn"
                                style="height: 33px;"><i class="fa fa-trash"aria-hidden="true"></i></a>
                            {{-- <a href="{{ route('telecaller.edit', [$val->id]) }}" class="btn btn-primary"
                                style="height: 33px;"><i class="fas fa-edit"></i></a>  --}}

                            <a href="javascript(0):;" data-telecaller_id={{ $val->id }}
                                class="btn btn-primary editTelecaller" style="height: 33px;" data-bs-toggle="modal"><i
                                    class="fas fa-edit"></i></a>
                            <a href="{{ route('telecaller.show', [$val->id]) }}" class="btn btn-secondary"
                                style="height: 33px;"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="row">
            {{ $obj->links() }}
        </div>
    </main>

    {{-- Modal for creating Telecaller --}}
    <div class="modal fade" id="createTelecaller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Telecaller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="telecallerFormData">
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
                            <span class="text-danger">
                                <span id="errorName"></span>
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" placeholder="name" name="phone"
                                value="{{ old('phone') }}" />
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
                            <input class="form-control" type="text" placeholder="name" name="address"
                                value="{{ old('address') }}" />
                            <label>Address</label>
                            <span class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="email" placeholder="name@example.com" name="email"
                                id="email" value="{{ old('email') }}" />
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
                                    <input class="form-control" id="password" type="password"
                                        placeholder="Create a password" name="password" value="{{ old('password') }}" />
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
                                    <input class="form-control" id="confirmpassword" type="password"
                                        placeholder="Confirm password" name="confirmpassword"
                                        value="{{ old('confirmpassword') }}" />
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
                                <button type="submit" class="btn btn-primary btn-block addTelecaller">Create
                                    Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Edit Telecaller --}}
    <div class="modal fade" id="editTelecallerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Telecaller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="editTelecallerForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="editcsrf" name="editcsrf" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" id="editid" />
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="name" id="editname" />
                            <label class="required">Name</label><span id="txterr"></span>
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text"  name="phone" id="editphone" />
                            <label>Phone</label>
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="countrycode" id="editcountrycode" />
                            <label>Country Code</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="address" id="editaddress">
                            <label>Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="email"  id="editemail" name="email"
                                 />
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
                                    <input class="form-control" id="inputPassword" type="password"
                                        placeholder="Create a password" name="password" />
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
                                    <input class="form-control" id="inputPasswordConfirm" type="password"
                                        placeholder="Confirm password" name="confirmpassword" />
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
                                <button type="submit" class="btn btn-primary btn-block updateTelecaller">Update Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/telecaller/telecaller.js') }}"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreTelecallerRequest', '#telecallerFormData') !!}
    {!! JsValidator::formRequest('App\Http\Requests\StoreTelecallerRequest', '#editTelecallerForm') !!} --}}
@endsection
