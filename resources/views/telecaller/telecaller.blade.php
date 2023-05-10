{{-- List of Telecaller --}}
@extends('master')
<style>
    .item {
        text-align: center;
    }

    #heading {
        margin-top: 15px;
        background-color: #d8dde2;
        font-family: serif;
    }

    #btntelecaller {
        float: right;
        margin-right: 20px;
        margin-top: 20px;
    }

    #btnBack {
        float: left;
    }

    .container {
        margin-top: 60px;
    }
</style>

<section>
</section>
@section('main-content')
    <main>
        <center>
            <h2 id="heading">Telecaller's Details</h2>
        </center>
        {{-- for creating new telecaller --}}
        <a href="{{ route('telecaller.create') }}"><button type="button" id="btntelecaller" class="btn btn-primary">Add
                Telecaller</button></a>
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
                    @foreach ($obj as $val)
                        <tr class="item">
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->phone }}</td>
                            <td>{{ $val->country_code }}</td>
                            <td>{{ $val->address }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-3">
                                        <form method="POST" action="{{ route('telecaller.destroy', [$val->id]) }}"
                                            style="display: inline-block:   margin-left: -20px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger deleteBtn"
                                                data-telecaller_id={{ $val->id }} style="margin-left: 19px;"><i
                                                    class="fa fa-trash"aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-2" style="margin-top: 20px;margin-right: -20;"><a
                                            href="{{ route('telecaller.edit', [$val->id]) }}" class="btn btn-primary"><i
                                                class="fas fa-edit"></i></a></div>
                                    <div class="col-3" style="margin-top: 20px;"><a
                                            href="{{ route('telecaller.show', [$val->id]) }}" class="btn btn-secondary"><i
                                                class="fa-solid fa-eye"></i></a></div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        <div class="row">
            {{ $obj->links() }}
        </div>
    </main>

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
                        var url = "{{ route('telecaller.destroy', ':id') }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
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
