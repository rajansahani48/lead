{{-- for see the list of telecaller who is working in particular campaign --}}
@extends('master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{ asset('css/campaign/showcampaigns.css') }}" rel="stylesheet" />
@section('main-content')
    <main>
        <center>
            <h2 id="heading">{{ $campaignName[0] }}'s Telecallers</h2>
        </center>
        <a href="/campaign"><button type="button" class="btn btn-dark" id="back">Back</button></a>

        <select class="js-example-placeholder-multiple js-states form-control" multiple="multiple" name="telecaller_id[]"
            id="edittelecaller_id">
            <option value="WY">Wyoming</option>
            <option value="AL">Alabama</option>
            <option value="AL">labama</option>
            <option value="WY">ming</option>
            <option value="AL">ma</option>
            <option value="WY">g</option>
            <option value="WY">yong</option>
            <option value="AL">lama</option>
            <option value="WY">ying</option>
        </select>
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
    <script>
        $(document).ready(function() {
            $(".js-example-placeholder-multiple").select2({
                placeholder: "Select a state"
            });
        });
    </script>
    <script src="{{ asset('assets/js/campaigns/showcampaign.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
