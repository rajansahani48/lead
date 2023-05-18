{{-- Campagin list  --}}
@extends('master')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="crossorigin="anonymous"
    referrerpolicy="no-referrer" />
<link href="{{ asset('css/campaign/campaigns.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<style>
    .select2-container {
        z-index: 5000 !important;
    }
</style>
@section('main-content')
    <center>
        <h2 id="heading">Campaign's Details</h2>
    </center>
    <main class="m-4">
        <button type="button" class="btn btn-primary" id="btncampaign" data-bs-toggle="modal"
            data-bs-target="#createCampaign">
            Add Campaign
        </button>
        <table class="table table-bordered table-striped table-hover" style="margin-top: 60px;">
            <thead>
                <tr class="item">
                    <th scope="col">Campaign Name</th>
                    <th scope="col">Campaign Description</th>
                    <th scope="col">Cost Per Lead</th>
                    <th scope="col">Conversion Cost</th>
                    <th scope="col">Telecaller</th>
                    <th scope="col">Leads</th>
                    <th scope="col">Pending </th>
                    <th scope="col">Procced </th>
                    <th scope="col" id="action">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($camp as $val)
                    <tr class="item">
                        <td>{{ $val->campaign_name }}</td>
                        <td>{{ $val->campaign_desc }}</td>
                        <td>{{ $val->cost_per_lead }}</td>
                        <td>{{ $val->conversion_cost }}</td>
                        <td>{{ count($val->CampaignHasUser) }}</td>
                        <td>{{ count($val->hasManyLeads) }}</td>
                        <td>{{ count($val->PendingLeads) }}</td>
                        <td>{{ count($val->ProccedLeads) }}</td>
                        <td>
                            <div class="row" id="upload_area" style="display: inline-block;width: 75;">
                                <form method="POST" class="upload_form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="deletecsrf" name="deletecsrf" value="{{ csrf_token() }}" />
                                    <label for="inputcsv{{ $val->id }}">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/826px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png"
                                            style="height: 30px; width: 30px; display:inline-block;margin-left:-15px"
                                            data-toggle="tooltip" data-placement="top" title="Upload CSV" />
                                    </label>
                                    <input class="form-control file" type="file" name="file" accept=".csv"
                                        id="inputcsv{{ $val->id }}" data-campaign_id={{ $val->id }}
                                        style="display: none" />
                                </form>
                            </div>
                            <form method="POST" action="{{ route('campaign.destroy', [$val->id]) }}"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="deletebtn" class="btn btn-danger deleteBtn"
                                    data-campaign_id={{ $val->id }}><i class="fa fa-trash" aria-hidden="true"
                                        data-toggle="tooltip" data-placement="top" title="Delete Campaign"></i></button>
                            </form>
                            <a href="javascript(0):;" class="btn btn-primary editCampaign"
                                data-campaign_id={{ $val->id }}><i class="fas fa-edit " data-toggle="tooltip"
                                    data-placement="top" title="Edit Campaign"></i></a>

                            <a href="{{ route('campaign.show', [$val->id]) }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-eye" data-toggle="tooltip" data-placement="top"
                                    title="Working Telecaller"></i></a>
                            <button type="button" class="btn btn-success addlead" id="addlead"
                                data-campaign_id={{ $val->id }}><i class="fa-solid fa-plus" style="color: #161817;"
                                    data-toggle="tooltip" data-placement="top" title="Add Single Lead"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $camp->links() }}

        {{-- insert csv --}}
        <div class="modal fade" id="csvModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> CSV Mapping</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="csvform">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <h4>Lead's </h4>
                                </div>
                                <div class="col-6">
                                    <h4>Csv Details</h4>
                                </div>
                            </div>

                            @foreach ($columns as $key => $val)
                                <div class="row">
                                    <input type="hidden" id="campaign_id" name="campaign_id" />
                                    <div class="col-6"><select class="form-select set_column_data"
                                            name="selectleadcolumn[]" id="selectlead" style="display:flex;margin: 5px;"
                                            data-column_number="{{ $key }}">
                                            <option value="">select</option>
                                            @foreach ($columns as $option)
                                                <option value="{{ $option }}">
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select set_csv_data" name="selectcsvcolumn[]"
                                            id="mySelect_{{ $val }}" style="display:flex;margin: 5px;"
                                            data-column_number="{{ $key }}">
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="csvFirstRow" value="true"
                                    id="csvFirstRow">
                                <label class="form-check-label" for="csvFirstRow">
                                    Take First Row
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="import"
                                    id="import">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- add single lead modal --}}
        <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Lead</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="leadsdetails">
                            @csrf
                            <input type="hidden" id="campaigns_id" name="campaign_id" />
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="required" class="col-form-label">Phone</label>
                                <input type="number" class="form-control" name="phone">
                            </div>
                            <select class="form-select" name="leadusermodal" id="leadusermodal"
                                style="display:flex;margin: 5px;">
                            </select>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="storelead">Add Lead</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal for Campaign creation --}}
        <div class="modal fade" id="createCampaign" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Campaign</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="campaignFormData">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" placeholder="name" name="campaign_name"
                                    id="campaign_name" maxlength="50" />
                                <label class="required">Campaign name</label>
                                <span id="txterr"></span>
                                <span class="text-danger">
                                    @error('campaign_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" placeholder="name" name="campaign_desc"
                                    maxlength="120" />
                                <label>Campaign description</label>
                                <span class="text-danger">
                                    @error('campaign_desc')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="number" placeholder="name" name="cost_per_lead"
                                    id="cost_per_lead" />
                                <label class="required">Cost Per Lead</label>
                                <div class="errorTxt"></div>
                                <span class="text-danger">
                                    @error('cost_per_lead')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="number" placeholder="name" name="conversion_cost"
                                    id="conversion_cost" />
                                <label class="required">Conversion Cost</label>
                                <span class="text-danger">
                                    @error('conversion_cost')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <label class="required" style="margin-top: 10px;">Select Telecaller</label>
                            <select class="selectpicker" multiple data-live-search="true" name="telecaller_id[]"
                                style="margin-left: 100px" style="margin-left: 15px;">
                                @foreach ($campaingUser as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('telecaller_id')
                                    {{ $message }}
                                @enderror
                            </span>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block createCampaign">Create
                                        Campaign</button>
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

        {{-- Edit Campaign --}}
        <div class="modal fade" id="editCampaignModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Campaign</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="editCampaignForm">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="editcsrf" name="editcsrf" value="{{ csrf_token() }}" />
                            <input type="hidden" name="campaign_id" id="editcampaign_id" />
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="campaign_name"
                                    id="editcampaign_name" />
                                <label for="inputEmail">Campaign name</label>
                                <span id="txterr"></span>
                                <span class="text-danger">
                                    @error('campaign_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="campaign_desc"
                                    id="editcampaign_desc" />
                                <label for="inputEmail">Campaign description</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="number" name="cost_per_lead"
                                    id="editcost_per_lead" />
                                <label for="inputEmail">Cost Per Lead</label>
                                <span class="text-danger">
                                    @error('cost_per_lead')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="number" name="conversion_cost"
                                    id="editconversion_cost" />
                                <label for="inputEmail">Conversion Cost</label>
                                <span class="text-danger">
                                    @error('conversion_cost')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <label class="required" style="margin-top: 10px;">Select Telecaller</label>
                            <select class="js-example-placeholder-multiple js-states form-control" multiple="multiple"
                                name="telecaller_id[]" id="edittelecaller_id" style="width: 300px;">
                            </select>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block updateCampaign">Update
                                        Campaign</button>
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
    </main>
    <script>
        var dbColumn = <?php echo json_encode($columns); ?>;
        var file = '';
        var campaign_id = '';
        $(document).ready(function() {
            $(".js-example-placeholder-multiple").select2({
                placeholder: "Select a Telecaller"
            });
        });
    </script>
    <script src="{{ asset('assets/js/campaigns/campaigns.js') }}"></script>
    <script src="{{ asset('assets/js/campaigns/editcampaign.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
