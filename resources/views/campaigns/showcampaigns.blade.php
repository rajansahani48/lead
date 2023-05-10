{{-- for see the list of telecaller who is working in particular campaign --}}
@extends('master')
<style>
        #heading{
        margin-top:20px;
        background-color:#d8dde2;
        font-family: serif;
    }
    #btntelecaller {
        float: right;
        margin-right: 10px;
    }
    #back {
        margin-top: 15px;
        margin-left: 5px;
    }
    .container {
        margin-top: 40px;
    }
</style>
@section('main-content')
    <main>
        <center>
            <h2 id="heading">{{$campaignName[0]}}'s Telecallers</h2>
        </center>
        <a href="/campaign"><button type="button" class="btn btn-dark" id="back">Back</button></a>

        <table  class="table table-bordered table-striped table-hover" style="margin-top: 60px;">
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
                            <a href="{{ route('deletetelecaller', [$val->id]) }}"><button type="submit" data-telecaller_id={{ $val->id }}
                                    class="btn btn-danger deleteBtn">Delete</button></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $campid->links() }}
    </main>
    {{-- <script src="{{ asset('assets/js/campaigns/showcampaign.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $(".deleteBtn").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to get this data Again!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        telecaller_id = $(this).data('telecaller_id');
                        var id = telecaller_id;
                        var url = "{{ route('deletetelecaller', ':id') }}";
                        url = url.replace(':id', id);
                        console.log(telecaller_id);
                        $.ajax({
                            url: url,
                            type: "delete",
                            data: telecaller_id,
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            headers: {
                                'X-CSRF-Token': "{{ csrf_token() }}"
                            },
                            processData: false,
                            success: function(data) {
                                if (data.deleteTelecallerError) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: "You Can't Delete this Telecaller Due To Incomplete Task!!",
                                    })
                                } else {
                                    Swal.fire(
                                        'Deleted!',
                                        'Telecaller has been deleted.',
                                        'success'
                                    ).then(function() {
                                        location.reload();
                                    });
                                }
                            }
                        })
                    }
                })
            });
        })
    </script>
@endsection

