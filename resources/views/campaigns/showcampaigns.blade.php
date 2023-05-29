{{-- for see the list of telecaller who is working in particular campaign --}}
@extends('master')
<link href="{{ asset('css/campaign/showcampaigns.css') }}" rel="stylesheet" />
@section('main-content')
    <main>
        <center>
            <h2 id="heading">{{ $campaignName[0] }}'s Telecallers</h2>
        </center>
        <a href="/campaign"><button type="button" class="btn btn-dark" id="back">Back</button></a>

        <table class="table table-bordered table-striped table-hover" style="margin-top: 60px;">
            <thead>
                <tr>
                    <th scope="col">Sr</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Country Code</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach ($campid as $val)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $val->user->name }}</td>
                        <td>{{ $val->user->email }}</td>
                        <td>{{ $val->user->phone }}</td>
                        <td>{{ $val->user->country_code }}</td>
                        <td>{{ $val->user->address }}</td>
                        <td>
                            <a href="javascript(0):;"><button type="submit" data-telecaller_id={{ $val->telecaller_id }}
                                    data-campaign_id={{ $val->campaign_id }}
                                    class="btn btn-danger deleteBtn">Delete</button></a>
                            <input type="hidden" id="deletecsrf" name="deletecsrf" value="{{ csrf_token() }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $campid->links() }}
    </main>
    <script src="{{ asset('assets/js/campaigns/showcampaign.js') }}"></script>
@endsection
