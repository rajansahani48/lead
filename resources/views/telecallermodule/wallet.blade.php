@extends('master')
<style>
    .container {
        margin-top: 30px;
    }
</style>
@section('main-content')
    <main>

        <div class="container">
            <div class="row">
                <div class="col-xl-1 col-md-1 w-25">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">
                            <h1>Wallet</h1>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span style="display: flex;">
                                <h3>Rupees : <h3 id="rupess">{{ $totalAmoutOfWallet }}</h3>
                                </h3>
                                <h3>.00</h3>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card mb-4">
                <div class="card-header">
                    <center>
                        <h4>Transaction History</h4>
                    </center>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr class="item">
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Rupees</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($transaction as $key => $val)
                                <tr style="height: 45px;">
                                    <td>{{ date('d-m-Y h:i:s', strtotime($val['created_at'])) }}</td>
                                    <td>
                                        Credited From Campaign
                                        {{ $storCampaignName[$count] }}</td>
                                    <td>
                                        +{{ $val['amount'] }}.{{ $paisa = '00' }}
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </main>
@endsection
