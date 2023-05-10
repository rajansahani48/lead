{{-- For Particaluar telcaller details --}}
@extends('master')
<style>
  .container
  {
    margin-top: 20px;
  }
</style>
@section('main-content')
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
                                  <h4>{{ $obj->name }} </h4>
                                  <p class="text-secondary mb-1">{{ $obj->email }}</p>
                                  <p class="text-muted font-size-sm">
                                    {{ $obj->address }}
                                  </p>
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
                                {{ $obj->name }}
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <h6 class="mb-0">Email</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                  <a>
                                    {{ $obj->email }}
                                  </a>
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <h6 class="mb-0">Phone</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{ $obj->phone }}
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-sm-3">
                                  <h6 class="mb-0">Address</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{ $obj->address }}
                              </div>
                          </div>
                          <hr>
                          <div class="row">
                              <div class="col-6">
                                  <a href="{{ route('telecaller.index') }}" class="btn btn-primary">Back To List</a>
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
@endsection
