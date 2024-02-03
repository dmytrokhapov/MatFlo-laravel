<x-app-layout>
    <style>
        .btn-primary {
            color: #fff;
            background-color: #0d6efd !important;
            border-color: #0d6efd;
        }
        .btn-danger {
            color: #fff;
            background-color: #DC4C64 !important;
            border-color: #DC4C64;
        }

        .custom-switch{
            background-size: 50% 100% !important;
        }

        .filter-style{
            display: flex;
            margin-top: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .length-style{
            align-self: center;
        }

        .select2-selection--single{
            height: 42px !important;
        }

        .select2-selection__rendered{
            line-height: 42px !important;
        }

        .select2-selection__arrow{
            height: 42px !important;
        }
        fieldset{
            border: 1px solid #c4c4c4;
            padding: 10px;
            display: block;
        }

        fieldset legend {
            background: #fff;
            border: 1px solid #c4c4c4;
            padding: 5px 10px;
            display: inline-block;
            width: auto;
            float: none;
            font-size: 1rem;
        }

        fieldset .form-control{
            margin: 0 0 15px 0;
        }

        .select2-container .select2-selection--single {
            height: 42px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            /* top:8px !important; */
        }

        .cust_radio input, .cust_radio span{
            vertical-align: middle;
        }

        .cust_radio {
            margin-left: 10px;
        }

        .select2-container{
            width: 100% !important;
        }

        .custom-select{
            width: 100%;
            border-radius: 0.375rem;
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity));
            margin-top: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
        }

        .btn-warning {
            color: #000;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-default{
            border: 1px solid;
        }

        div#testingResultDiv input, div#testingResultDiv select {
            height: 42px !important;
        }

        .removeTestingResultBtn {
            margin-left: 10px;
        }

        .removechildRow {
    margin-left: -10px;
}

    </style>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 text-left">
                            {{-- <form action="">
                                <button type="button" class="btn btn-danger deleteMultipleUser" id="deleteButton">Delete Selected</button>
                            </form> --}}
                        </div>
                        <div class="text-right col-md-6">
                            <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importExcel">Import Excel</button>
                            <a href="{{route('export')}}" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('exportForm').submit();">Export</a>
                            <a href="{{route('workspace')}}" class="btn btn-primary">Add New</a>
                            <button type="button" class="btn btn-danger deleteMultipleUser" id="deleteButton">Delete Selected</button>
                        </div>
                        <form action="{{route('export')}}" class="hidden" id="exportForm" method="POST">
                            @csrf
                            <input type="text" name="user_filter_export" id="user_filter_export" value="">
                            <input type="text" name="search_export" id="search_export" value="">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped" width="100%">
                          <thead>
                          <tr>
                              {{-- <th width="5%" class="orderHide"> Index </th> --}}
                              <th width="5%"><input type="checkbox" class="checkAll" id="checkAllValue" name="record"></th>
                              <th width="20%"> Mix Name  </th>
                              <th width="20%"> Purpose  </th>
                              <th width="10%"> Strength  </th>
                              <th width="15%"> Date </th>
                              <th width="20%"> Created By </th>
                              <th width="5%"> Is Published </th>
                              <th width="10%"> Action </th>
                          </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-delete" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-delete">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="crypt-down modal-title" id="modelHeading"><b>Are you sure?</b></h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete workspace?</p>
              <input type="hidden" name="delete_id" id="delete_id">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default cancel-button" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary custom-button delete-user" id="delete-user">Ok</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

    <!-- Multiple Delete Records -->
    <div class="modal fade" id="modal-deleteMultiple" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-deleteMultiple">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="crypt-down modal-title" id="modelHeading"><b>Are you sure?</b></h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete?</p>
              <input type="hidden" name="delete_multipleid" id="delete_multipleid">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default cancel-buttonmultipleuser" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary custom-button delete-multipleuser" id="delete-multipleuser">Ok</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

    <!--Import Excel Modal -->
    <div class="modal fade" id="importExcel" data-bs-backdrop="static"  tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="crypt-down modal-title" id="importExcelModalLabel"><b>Import Your File</b></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <form id="importExcelForm" method="POST">
                @csrf
                <div class="modal-body">
                    <x-text-input type="file" name="excelFile" id="excelFile" />
                    <x-input-error :messages="$errors->get('excelFile')" class="mt-2" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel-button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary custom-button" id="delete-user">Upload</button>
                </div>
            </form>
        </div>
    </div>
    </div>
     <!--Show Modal After upload excel -->
    <div class="modal fade" id="afterImportExcel" data-bs-backdrop="static"  tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content text-gray-900">
            <div class="modal-header">
                <h4 class="crypt-down modal-title" id="importExcelModalLabel"><b>Selct Column for Import Data</b></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="deleteUploadFile()">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
                        <form method="POST" id="workspaceform" action="{{ route('workspace.store') }}">
                        @csrf
                        <input type="hidden" id="file_name" name="file_name">
                        <div class="modal-body">
                        <div class="row">
                        <!-- Name -->
                        <div class="col-md-12">
                            <label for="mix_id"><b>{{__('Mix Name')}}</b></label>
                            <select class="block mt-1 form-control w-full dropdownColumn" name="mix_id" :value="old('mix_id')" id="mix_id" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('mix_id')" class="mt-2" />
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="source"><b>{{__('Source')}}</b></label>
                            <select class="block mt-1 form-control w-full dropdownColumn" name="source" :value="old('source')" id="source" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="purpose"><b>{{__('Purpose')}}</b></label>
                            <select class="block mt-1 form-control w-full dropdownColumn" id="purpose" name="purpose" :value="old('purpose')" autofocus>
                                <option value=""></option>
                            </select>
                            <div class="error_message">
                            </div>
                            {{-- <x-text-input id="purpose" class="block mt-1 form-control w-full " type="text" name="purpose" :value="old('purpose')" required autofocus autocomplete="purpose" /> --}}
                            <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="unit"><b>{{__('Unit')}}</b></label>
                            <label for="metric_unit" class="cust_radio"><x-text-input id="metric_unit"  type="radio" checked name="unit" value="1"/> <span>Metric</span></label>
                            <label for="imperial_unit" class="cust_radio"><x-text-input id="imperial_unit"  type="radio" name="unit" value="2"/> <span>Imperial</span></label>
                            <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="mix design" class="metric_block"><b>{{__('Mix Design (kg/m3)')}}</b></label>
                            <label for="mix design" class="imperial_block hidden"><b>{{__('Mix Design (lb/ft3)')}}</b></label>
                        </div>

                        <div class="col-md-12">
                        <x-input-label for="cement" :value="__('Cement')" />
                            <select class="block mt-1 form-control w-full dropdownColumn" name="cement" :value="old('cement')" id="cement" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('cement')" class="mt-2" />
                        </div>

                        <div class="col-md-12 mt-3">
                            <x-input-label for="water" :value="__('Water')" />
                            <select class="block mt-1 form-control w-full dropdownColumn" name="water" :value="old('water')" id="water" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('water')" class="mt-2" />
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                            <div class="col-md-12">
                                <x-input-label for="scm_value" :value="__('Fine Aggregate')" />
                            </div>
                            <div class="col-md-11 align-self-center">
                            <select class="block mt-1 form-control w-full dropdownColumn" name="fine_aggregate" :value="old('fine_aggregate')" id="fine_aggregate" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('fine_aggregate')" class="mt-2" />
                            </div>
                            <div class="col-md-1 align-self-center"><a href="javascript::void(0);" id="detail_fine_aggregate">Detail+</a></div>
                            <div class="col-md-12 text-danger hidden" id="fine_div_error">Please click on detail+ button to see validation error.</div>
                        </div>
                            <div class="col-md-12 hidden" id="fine_aggregate_div">
                            <fieldset class="mt-3">
                                <legend>
                                    Fine Aggregate
                                </legend>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="fitness_module">Fineness Modulus</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="fitness_module" :value="old('fitness_module')" id="fitness_module" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="specific_gravity_f">Specific Gravity</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="specific_gravity_f" :value="old('specific_gravity_f')" id="specific_gravity_f" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="absorption_f">Absorption (%)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="absorption_f" :value="old('absorption_f')" id="absorption_f" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="moisture_content_f">Moisture Content(%)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="moisture_content_f" :value="old('moisture_content_f')" id="moisture_content_f" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="row">
                            <x-input-label for="coarse_aggregate" :value="__('Coarse Aggregate')" />
                            <div class="col-md-11 align-self-center">
                            <select class="block mt-1 form-control w-full dropdownColumn" name="coarse_aggregate" :value="old('coarse_aggregate')" id="coarse_aggregate" autofocus>
                                <option value=""></option>
                            </select>
                            <x-input-error :messages="$errors->get('coarse_aggregate')" class="mt-2" />
                            </div>
                            <div class="col-md-1 align-self-center"><a id="detail_coarse_aggregate" href="javascript::void(0);">Detail+</a></div>
                            <div class="col-md-12 text-danger hidden" id="coarse_div_error">Please click on detail+ button to see validation error.</div>
                            <div class="col-md-12 hidden" id="coarse_aggregate_div">
                            <fieldset class="mt-3">
                                <legend>
                                    Coarse Aggregate
                                </legend>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3 metric_block">
                                            <label for="nominal_maximum_size_mm">Nominal Maximum Aggregate Size (mm)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="nominal_maximum_size_mm" :value="old('nominal_maximum_size_mm')" id="nominal_maximum_size_mm" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3 imperial_block hidden">
                                            <label for="nominal_maximum_size_inch">Nominal Maximum Aggregate Size (inch)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="nominal_maximum_size_inch" :value="old('nominal_maximum_size_inch')" id="nominal_maximum_size_inch" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="round_shaped_aggregate">Round-Shaped Aggregate?</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="round_shaped_aggregate" :value="old('round_shaped_aggregate')" id="round_shaped_aggregate" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3 metric_block">
                                            <label for="dry_rodded_density_kg ">Dry-Rodded Bulk Density (kg/m3)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="dry_rodded_density_kg" :value="old('dry_rodded_density_kg')" id="dry_rodded_density_kg" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3 imperial_block hidden">
                                            <label for="dry_rodded_density_lb ">Dry-Rodded Bulk Density (lb/ft3)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="dry_rodded_density_lb" :value="old('dry_rodded_density_lb')" id="dry_rodded_density_lb" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="specific_gravity_c">Specific Gravity</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="specific_gravity_c" :value="old('specific_gravity_c')" id="specific_gravity_c" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="absorption_c">Absorption (%)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="absorption_c" :value="old('absorption_c')" id="absorption_c" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="moisture_content_c">Moisture Content(%)</label>
                                            <select class="block mt-1 form-control w-full dropdownColumn" name="moisture_content_c" :value="old('moisture_content_c')" id="moisture_content_c" autofocus>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 metric_block"><b>Note :</b> Please select column in <b>Nominal Maximum Aggregate Size (mm), Round-Shaped Aggregate</b> in which contain the same value as dropdown. If no value match from the dropdown then will not add that value in DB.</div>
                                <div class="col-md-12 hidden imperial_block"><b>Note :</b> Please select column in <b>Nominal Maximum Aggregate Size (inch), Round-Shaped Aggregate</b> in which contain the same value as dropdown. If no value match from the dropdown then will not add that value in DB.</div>
                            </fieldset>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="scms"><b>{{__('SCMs')}}</b></label>
                        </div>

                        <div class="col-md-12">
                            <div id="SCMDiv">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="block mt-1 form-control w-full dropdownColumn scm_name_text" name="scm_name[1]" :value="old('scm_name')" id="scm_name" data-id="1" autofocus>
                                        <option value=""></option>
                                    </select>
                                    <x-input-error :messages="$errors->get('scm_name')" class="mt-2" />
                                    </div>
                                    <div class="col-md-5">
                                        <x-text-input class="block mt-1 w-full scm_name_value" type="number" name="scm_value[1]" :value="0" min="0" autofocus autocomplete="scm_value" placeholder="SCM Value" disabled/>
                                        <!-- <x-input-error :messages="$errors->get('scm_value')" class="mt-2" /> -->
                                    </div>
                                    <div class="col-md-1"><a class="btn btn-danger hidden removeScmBtn" >X</a></div>
                            </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-primary-button type="button" id="addMoreSCMBtn">
                                    {{ __('Add More +') }}
                                </x-primary-button>
                            </div>

                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="admixtures"><b>{{__('Admixtures')}}</b></label>
                        </div>


                        <div class="col-md-12">

                            <div id="admixturesDiv">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="block mt-1 form-control w-full dropdownColumn admixtures_name_text" name="admixtures_name[1]" :value="old('admixtures_name')" id="admixtures_name" data-id="1"  autofocus>
                                            <option value=""></option>
                                        </select>
                                        <x-input-error :messages="$errors->get('admixtures_name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-5">
                                            <x-text-input  class="block mt-1 w-full form-control admixtures_name_value" type="number" name="admixtures_value[1]" :value="0" min="0" autofocus autocomplete="admixtures_value" placeholder="Admixture Value" disabled/>
                                            <!-- <x-input-error :messages="$errors->get('admixtures_value')" class="mt-2" /> -->
                                        </div>
                                        <div class="col-md-1"><a class="btn btn-danger hidden removeAdmixtureBtn" >X</a></div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-primary-button type="button" id="addMoreAdmixtureBtn">
                                    {{ __('Add More +') }}
                                </x-primary-button>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="fibers"><b>{{__('Fibers')}}</b></label>
                        </div>

                        <div class="col-md-12">

                            <div id="fibersDiv">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="block mt-1 form-control w-full dropdownColumn fibers_name_text" name="fibers_name[1]" :value="old('fibers_name')" id="fibers_name" data-id="1" autofocus>
                                            <option value=""></option>
                                        </select>
                                        <x-input-error :messages="$errors->get('fibers_name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-5">
                                            <x-text-input  class="block mt-1 w-full form-control fibers_name_value" type="number" name="fibers_value[1]" :value="0" min="0" autofocus autocomplete="fibers_value" placeholder="Fiber Value" disabled/>
                                            <x-input-error :messages="$errors->get('fibers_value')" class="mt-2" />
                                        </div>
                                        <div class="col-md-1"><a class="btn btn-danger hidden removeFiberBtn" >X</a></div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-primary-button type="button" id="addMoreFiberBtn">
                                    {{ __('Add More +') }}
                                </x-primary-button>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="testing_results"><b>{{__('Testing results')}}</b></label>
                        </div>

                        <div class="col-md-12">
                            <div id="testingResultDiv">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-text-input class="block mt-2 w-full  form-control testing_name_text" type="text" name="testing_name[1]" :value="'Compressive Strength (MPa)'" data-id="1" required autofocus autocomplete="testing_name" readonly placeholder="Testing Result Name" />
                                        <x-input-error :messages="$errors->get('testing_name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="childRowDiv">
                                            <div class="row">
                                                <div class="col-md-5 mt-2">
                                                    <select class="block w-full measureDropdownColumn form-control measure_value" data-c_id="1" name="testing_value[1][measure][1]" autofocus>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <select class="block form-control w-full dropdownColumn measurement_value" name="testing_value[1][measure_value][1]" autofocus>
                                                        <option value=""></option>
                                                    </select>
                                                    <!-- <x-text-input  class="block mt-2 w-full form-control" type="number" name="testing_value[1][measure_value][1]" :value="0" min="0" placeholder="Measurement Value"/> -->
                                                    <x-input-error :messages="$errors->get('testing_value')" class="mt-2" />
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <select class="block form-control w-full dropdownColumn testing_name_value" name="testing_value[1][result_value][1]" :value="old('testing_name')" data-p_id="1" autofocus>
                                                        <option value=""></option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('testing_value')" class="mt-2" />
                                                </div>
                                                <div class="col-md-1 mt-2">
                                                    <a class="btn btn-warning hidden removechildRow" >X</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2"><a class="btn btn-info addchildRow" >+</a></div>
                                        {{-- <div class="col-md-1"><a class="btn btn-danger hidden removeTestingResultBtn" >X</a></div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-text-input class="block mt-2 w-full form-control testing_name_text" type="text" name="testing_name[2]" :value="'Slump (mm)'" data-id="2"  autofocus autocomplete="testing_name" readonly placeholder="Testing Result Name" />
                                        <x-input-error :messages="$errors->get('testing_name')" class="mt-2" />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="childRowDiv">
                                            <div class="row">
                                                <div class="col-md-5 mt-2">
                                                    <select class="block form-control w-full measureDropdownColumn measure_value" data-c_id="2" name="testing_value[2][measure][1]" autofocus>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <select class="block form-control w-full dropdownColumn measurement_value" name="testing_value[2][measure_value][1]" autofocus placeholder="Measurement Value">
                                                        <option value=""></option>
                                                    </select>
                                                    <!-- <x-text-input  class="block w-full form-control" type="number" name="testing_value[2][measure_value][1]" :value="0" min="0" placeholder="Measurement Value"/> -->
                                                    {{-- <x-input-error :messages="$errors->get('testing_value')" class=" /> --}}
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <select class="block form-control w-full dropdownColumn testing_name_value" name="testing_value[2][result_value][1]" :value="old('testing_name')" data-p_id="2" autofocus>
                                                        <option value=""></option>
                                                    </select>
                                                    {{-- <x-input-error :messages="$errors->get('testing_value')" class="mt-2" /> --}}
                                                </div>
                                                <div class="col-md-1 mt-2">
                                                    <a class="btn btn-warning hidden removechildRow" >X</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2"><a class="btn btn-info addchildRow" >+</a></div>
                                        {{-- <div class="col-md-1"><a class="btn btn-danger hidden removeTestingResultBtn" >X</a></div> --}}
                                        {{-- <div class="col-md-1"><a class="btn btn-danger hidden removeAdmixtureBtn" >X</a></div> --}}
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <x-primary-button type="button" id="addMoreTestingResultBtn">
                                    {{ __('Add More +') }}
                                </x-primary-button>
                            </div>

                        </div>

                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default cancel-button" data-bs-dismiss="modal" onclick="deleteUploadFile()">Cancel</button>
                            <button type="submit" id="submitBtn" class="btn btn-primary custom-button">Save</button>
                        </div>
                    </form>
        </div>
    </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <script>
        var _token = "{{ csrf_token() }}";
        var _workspace_list = "{{ route('getWorkspaceList') }}";
        var _delete_workspace = "{{ url('/deleteWorkspace/') }}";
        var _updatedPublishStatus = "{{route('updatedPublishStatus')}}";
        var _delete_uploaded_file = "{{route('deleteUploadedFile')}}";
        var _get_users_list = "{{route('getUsersList')}}";
        var user_type = "{{\Auth::user()->user_type}}";
        var _import_sheet = "{{ route('import') }}";
        var _import_insert_data = "{{ route('importInsertData') }}";
        var _checkMixId = "{{ route('checkMixId') }}";
        var _deleteMultipleRecord = "{{ route('deleteMultipleRecord') }}";
        var dropdownValue = "";
        var measureValue = "";
        var table;
        var selectedIds = [];

        function deleteUploadFile(){
            var file_name = $("#file_name").val();
            //console.log(file_name);
            $.ajax({
                url: _delete_uploaded_file,
                type: "POST",
                async:false,
                data: {
                    "_token": _token,
                    "file_name":file_name
                },
                success: function (data) {
                },
                error: function (data) {
                    toastr.warning(data.error);
                }
            });

        }
        $(document).ready(function() {
              $("#importExcel").on('hide.bs.modal', function(){
                document.getElementById("importExcelForm").reset();
                var $alertas = $('#importExcelForm');
                //$("#file_name").val('');
                // $alertas.reset();
            // $alertas.validate();
                $alertas.find('label.error').remove();
                $alertas.find('.error').removeClass('error');
            });


            $("#afterImportExcel").on('hide.bs.modal', function(){
              //  console.log("jer");
                //$("#file_name").val('');
                $("#SCMDiv > .row").each(function(key) {
                    if(key >= 1){
                        $(this).remove();
                    }
                });

                $("#admixturesDiv > .row").each(function(key) {
                    if(key >= 1){
                        $(this).remove();
                    }
                });

                $("#fibersDiv > .row").each(function(key) {
                    if(key >= 1){
                        $(this).remove();
                    }
                });

                $("#testingResultDiv > .row").each(function(key) {
                    if(key <= 1){
                        //console.log("here");
                        $(this).find('.childRowDiv > .row').each(function(key1){
                            console.log("key",key1);
                            if(key1 >= 1){
                                $(this).remove();
                            }
                        })
                    }
                    else{
                        $(this).remove();
                    }
                   // console.log("this",$(this),key);
                });
                document.getElementById("workspaceform").reset();
                var $alertas = $('#workspaceform');
                // $alertas.reset();
            // $alertas.validate();
                $alertas.find('label.error').remove();
                $alertas.find('.error').removeClass('error');

                $(".removeFiberBtn").addClass('hidden');
                $(".removeAdmixtureBtn").addClass('hidden');
                $(".removeScmBtn").addClass('hidden');
                $(".removeTestingResultBtn").addClass('hidden');
                $(".removechildRow").addClass('hidden');
            });

            $("#search_export").val('');
        $("#user_filter_export").val('');

        table = $(document).find('#example1').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        //stateSave: true,
        "autoWidth": false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search"
        },
        //dom: 'l<"toolbar">frtip',
        dom:"<'row'<'col-sm-12 col-md-3 length-style'l><'col-sm-12 col-md-9 mobile-pl0 filter-style'<'toolbar'>f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 mobile-pl0'p>>",
           initComplete: function(){
              if(user_type == "2"){
                $("div.toolbar").addClass('custom-filter')
                 .html('<div class="form-group"><select id="user_filter" class="select2bs4"><option value="">All</option><option value="0">Self</option></select></div>');
              }

           },
        ajax: {
            url: _workspace_list,
            async:false,
            method:"post",
            data: function(data) {
                data._token = _token,
                data.user_filter = $('#user_filter').val(),
                // data.type = $('#user_filter_type').val(),
                data.search = $('#example1_wrapper input[type="search"]').val()
            }
        },
        order: [[3, 'desc']],
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'select_all', name: 'checkbox', orderable: false, searchable: false},
            {data: 'mix_id', name: 'mix_id'},
            {data: 'purpose', name: 'purpose'},
            {data: 'strength', name: 'strength'},
            {data: 'created_at', name: 'created_at'},
            {data: 'user_name', name: 'user_name'},
            {data: 'is_published', name: 'is_published', className:"is_published", orderable: false, searchable: false},
            {data: 'action', name: 'action', className:"action", orderable: false, searchable: false},
        ],
        "columnDefs": [
          { "width": "5%", "targets": 0 },
          { "width": "20%", "targets": 1 },
          { "width": "20%", "targets": 2 },
          { "width": "10%", "targets": 3 },
          { "width": "15%", "targets": 4 },
          { "width": "15%", "targets": 5 },
          { "width": "5%", "targets": 6 },
          { "width": "10%", "targets": 7 },
        //   { "width": "10%", "targets": 5 }
        ],
    });

    if(user_type == "2"){
    $.ajax({
        url: _get_users_list,
        type: "POST",
        async:false,
        data: {
            "_token": _token
        },
        success: function (data) {

            if(data.flag == 1){
                let html = '<option value="">All</option><option value="0">Self</option>';
                $.each(data.data, function(index, value) {
                    // Do something with each element in the array
                    html += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $("#user_filter").html(html);
            }else {
                toastr.warning(data.message);
            }
        },
        error: function (data) {
            toastr.warning(data.error);
        }
    });
    $("#user_filter").select2({}).on("change", function (e) {
       // if($(this).val() != ''){
            $("#user_filter_export").val($(this).val());
            table.draw();
       // }

    });


    }
    $('#example1_wrapper input[type="search"]').on('keyup', function (e){
        $("#search_export").val($(this).val());
    });

    $('body').on('click', '.deleteUser', function () {
        var user_id = $(this).data("id");
        $('#modal-delete').modal('show');
        $("#delete_id").val(user_id);
    });

    $(".cancel-button").click(function (e) {
        e.preventDefault();
        $("#delete_id").val('');
        $('#modal-delete').modal('hide');
    });
    $('#checkAllValue').on('click', function() {
        if(this.checked){
            $('input[name="record_ids[]"]').prop('checked', this.checked);
        }
        else{
            $('input[name="record_ids[]"]').prop('checked', false);
        }
    });
    $('input[name="record_ids[]"]').on('click',function(){
        if($('input[name="record_ids[]"]:checked').length == $('input[name="record_ids[]"]').length){
            $('#checkAllValue').prop('checked',true);
        }else{
            $('#checkAllValue').prop('checked',false);
        }
    });
    table.on('page.dt', function() {
        $('#checkAllValue').prop('checked', false);
    });
    table.on('draw.dt', function() {
    $('input[name="record_ids[]"]').on('click',function(){
        if($('input[name="record_ids[]"]:checked').length == $('input[name="record_ids[]"]').length){
            $('#checkAllValue').prop('checked',true);
        }else{
            $('#checkAllValue').prop('checked',false);
        }
        });
    });
    $('body').on('click','.deleteMultipleUser', function() {
            $('input[name="record_ids[]"]:checked').each(function() {
                selectedIds.push($(this).val());
            });
            if(selectedIds.length === 0) {
                toastr.warning('Please select at least one item.');
                setTimeout(function() {
                    toastr.clear();
                }, 1000);
            }else{
                $('#modal-deleteMultiple').modal('show');
                $("#delete_multipleid").val(selectedIds);
            }
            $(".cancel-buttonmultipleuser").click(function (e) {
                e.preventDefault();
                $("#delete_multipleid").val('');
                $('#modal-deleteMultiple').modal('hide');
                $('input[name="record_ids[]"]').prop('checked', false);
                $('input[name="record"]').prop('checked', false);
            });
    });
    $("#delete-multipleuser").click(function(event) {
        if(selectedIds.length > 0) {
            // console.log(selectedIds);
            $.ajax({
                url: _deleteMultipleRecord,
                type: 'DELETE',
                data: {
                    ids: selectedIds,
                    "_token": _token
                },
                success: function(response) {
                    console.log("response",response);
                    if(response.flag == 1){
                    table.draw();
                    $('#modal-deleteMultiple').modal('hide');
                    $("#loading").hide();
                    $('input[name="record"]').prop('checked', false);
                    toastr.success(response.message);
                    selectedIds = [];
                    }else {
                        $("#loading").hide();
                        toastr.warning(response.message);
                    }
                    },
                error: function(response) {
                    toastr.warning(response.error);
                }
            });
        }
    });

    $(document).on('change', '.updatePublishStatus', function(e) {
        e.preventDefault();
        var status = 0;
        if($(this).prop('checked')){
            status = 1;
        }
        var id = $(this).data('id');
        if(id != ''){
            $.ajax({
                url: _updatedPublishStatus,
                type: "POST",
                async:false,
                data: {
                    "id": id,
                    "status":status,
                    "_token": _token
                },
                success: function (data) {

                    if(data.flag == 1){
                        table.draw(false);
                        $('#modal-delete').modal('hide');
                        $("#loading").hide();
                        toastr.success(data.message);
                    }else {
                        $("#loading").hide();
                        toastr.warning(data.message);
                    }
                },
                error: function (data) {
                   toastr.warning(data.error);
                }
            });
        }

    });
    $("#delete-user").click(function(event) {
        var workspace_id = $("#delete_id").val();
        //console.log(workspace_id)
        if(workspace_id != '')
        {
            //$("#loading").show();
            $.ajax({
                url: _delete_workspace+"/"+workspace_id,
                type: "DELETE",
                async:false,
                data: {
                    "id": workspace_id,
                    "_token": _token
                },
                success: function (data) {

                    if(data.flag == 1){
                        table.draw();
                        $('#modal-delete').modal('hide');
                        $("#loading").hide();
                        toastr.success(data.message);
                    }else {
                        $("#loading").hide();
                        toastr.warning(data.message);
                    }
                },
                error: function (data) {
                   toastr.warning(data.error);
                }
            });
        }

    });
    });

    $(document).ready(function () {
    $('#importExcelForm').validate({
        rules: {
            excelFile: {
                required: true,
                extension: "xls|csv|xlsx"
            }
        },
        messages: {
            excelFile: {
                required: 'Please select a file.',
                extension: "Only XLS,XLSX and CSV files are allowed."
            }
        },
        submitHandler: function (form) {
            var files = $('#excelFile')[0].files;
            // console.log(files[0]);
            var fd = new FormData();
            fd.append('excelFile', files[0]);
            fd.append('_token', _token);

            $.ajax({
                type: 'POST',
                url: _import_sheet,
                data: fd,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.result){
                        if(response.data.columns)
                        {
                            dropdownValue = '<option value="">Select Column</option>';
                            $.each(response.data.columns, function(key, value) {
                                dropdownValue += '<option value="'+value+'">'+value+'</option>';
                            });
                        }

                        if(response.data.testResult)
                        {
                            measureValue = '<option value="">Select Measurement</option>';
                            $.each(response.data.testResult, function(key, value) {
                                measureValue += '<option value="'+value+'">'+value+'</option>';
                            });
                        }

                        //measureValue = response.data.testResult;


                        $("#file_name").val(response.data.file_name);
                        toastr.success(response.message);
                        $("#afterImportExcel").modal('show');
                        $("#importExcel").modal('hide');
                        var dropdown = $('.dropdownColumn');
                        dropdown.empty();
                        dropdown.html(dropdownValue);
                        //Measure Dropdown value
                        var measureValueDropdown = $('.measureDropdownColumn');
                        measureValueDropdown.empty();
                        measureValueDropdown.html(measureValue);

                        //console.log(dropdownValue);
                    }

                },
                error: function (response) {
                    toastr.warning(response.error);
                    console.error(xhr.responseJSON.error);
                }
            });
        }
    });
    });
    $('#excelFile').on('change', function() {
    $('#excelFile-error').hide();
  });
    $(document).ready(function() {
            $("#detail_fine_aggregate").click(function (e){
                e.preventDefault();
                if($("#detail_fine_aggregate").hasClass('text-danger')){
                    $("#detail_fine_aggregate").removeClass('text-danger');
                    $("#fine_div_error").addClass('hidden');
                }
                $("#fine_aggregate_div").toggleClass('hidden');
            });
            $("#detail_coarse_aggregate").click(function (e){
                e.preventDefault();
                if($("#detail_coarse_aggregate").hasClass('text-danger')){
                    $("#detail_coarse_aggregate").removeClass('text-danger');
                    $("#coarse_div_error").addClass('hidden');
                }
                $("#coarse_aggregate_div").toggleClass('hidden');
            });
            $(".measure_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
            $(".measurement_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
            // scm div
            $("#addMoreSCMBtn").click(function (e) {
                e.preventDefault();
               // console.log($("#SCMDiv .row:last-child .scm_name_text").data("id"));
                let id = parseInt($("#SCMDiv .row:last-child .scm_name_text").data("id")) + 1;


                $("#SCMDiv").append('<div class="row"><div class="col-md-6"><select class="block mt-1 form-control w-full dropdownColumn scm_name_text" name="scm_name['+id+']" data-id="'+id+'" autofocus>'+dropdownValue+'</select></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control scm_name_value" min="0" type="number" value="0" name="scm_value['+id+']" autofocus="autofocus" autocomplete="scm_value" placeholder="SCM Value" disabled></div><div class="col-md-1"><a class="btn btn-danger removeScmBtn">X</a></div></div>')
                // $("#SCMDiv").append('<div class="row"><div class="col-md-6"><input class="border-gray-300 form-control focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full scm_name_text" data-id="'+id+'" type="text" name="scm_name['+id+']" required="required" autofocus="autofocus" autocomplete="scm_name" placeholder="SCM Name"></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control scm_name_value" min="0" type="number" value="0" name="scm_value['+id+']" autofocus="autofocus" autocomplete="scm_value" placeholder="SCM Value" ></div><div class="col-md-1"><a class="btn btn-danger removeScmBtn">X</a></div></div>')
                // console.log(dropdownValue);
                if($("#SCMDiv .row").length > 1){
                    $(".removeScmBtn").removeClass('hidden');
                }
                else{
                    $(".removeScmBtn").addClass('hidden');
                }

                $(".scm_name_text").each(function() {
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        // More validation rules can be added here
                        messages: {
                        required: "Please select SCM Name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });
                $(".scm_name_value").each(function() {
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        min:0,
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter SCM Value." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                });
            });

            $(document).on('click',".removeScmBtn",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                $(this).closest('.row').remove();
                if($("#SCMDiv .row").length > 1){
                    $(".removeScmBtn").removeClass('hidden');
                }
                else{
                    $(".removeScmBtn").addClass('hidden');
                }
            });

            //admixture div
            $("#addMoreAdmixtureBtn").click(function (e) {
                e.preventDefault();
                //console.log($("#SCMDiv .row:last-child .scm_name_text").data("id"));
                let id = parseInt($("#admixturesDiv .row:last-child .admixtures_name_text").data("id")) + 1;
                $("#admixturesDiv").append('<div class="row"><div class="col-md-6"><select class="block mt-1 form-control w-full dropdownColumn admixtures_name_text" name="admixtures_name['+id+']" data-id="'+id+'" required="required" autofocus>'+dropdownValue+'</select></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control admixtures_name_value"  type="number" name="admixtures_value['+id+']" value="0" min="0" autofocus="autofocus" autocomplete="admixtures_value" placeholder="Admixture Value" disabled></div><div class="col-md-1"><a class="btn btn-danger removeAdmixtureBtn">X</a></div></div>');
                // $("#admixturesDiv").append('<div class="row"><div class="col-md-6"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control admixtures_name_text" type="text" name="admixtures_name['+id+']" data-id="'+id+'" required="required" autofocus="autofocus" autocomplete="admixtures_name" placeholder="Admixture Name"></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control admixtures_name_value"  type="number" name="admixtures_value['+id+']" value="0" min="0" autofocus="autofocus" autocomplete="admixtures_value" placeholder="Admixture Value"></div><div class="col-md-1"><a class="btn btn-danger removeAdmixtureBtn">X</a></div></div>');

                if($("#admixturesDiv .row").length > 1){
                    $(".removeAdmixtureBtn").removeClass('hidden');
                }
                else{
                    $(".removeAdmixtureBtn").addClass('hidden');
                }

                $(".admixtures_name_text").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        // More validation rules can be added here
                        messages: {
                        required: "Please select admixture name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                });
                $(".admixtures_name_value").each(function() {
                    $(this).rules("add", {
                        // required: true, // Add your desired validation rules
                        min:0,
                        // More validation rules can be added here
                        // messages: {
                        // required: "Please enter admixture value." // Custom error message for required rule
                        // // More custom error messages can be added here
                        // }
                    });
                });
            });

            $(document).on('click',".removeAdmixtureBtn",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                $(this).closest('.row').remove();
                if($("#admixturesDiv .row").length > 1){
                    $(".removeAdmixtureBtn").removeClass('hidden');
                }
                else{
                    $(".removeAdmixtureBtn").addClass('hidden');
                }
            });

            //fiber div
            $("#addMoreFiberBtn").click(function (e) {
                e.preventDefault();
                //console.log($("#SCMDiv .row:last-child .scm_name_text").data("id"));
                let id = parseInt($("#fibersDiv .row:last-child .fibers_name_text").data("id")) + 1;
                $("#fibersDiv").append('<div class="row"><div class="col-md-6"><select class="block mt-1 form-control w-full dropdownColumn fibers_name_text" name="fibers_name['+id+']" data-id="'+id+'" autofocus>'+dropdownValue+'</select></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control fibers_name_value"  type="number" name="fibers_value['+id+']" value="0" min="0" autofocus="autofocus" autocomplete="fibers_value" placeholder="Fiber Value" disabled></div><div class="col-md-1"><a class="btn btn-danger removeFiberBtn">X</a></div></div>');
                // $("#fibersDiv").append('<div class="row"><div class="col-md-6"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control fibers_name_text" type="text" name="fibers_name['+id+']" data-id="'+id+'" required="required" autofocus="autofocus" autocomplete="fibers_name" placeholder="Fiber Name"></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control fibers_name_value"  type="number" name="fibers_value['+id+']" value="0" min="0" autofocus="autofocus" autocomplete="fibers_value" placeholder="Fiber Value"></div><div class="col-md-1"><a class="btn btn-danger removeFiberBtn">X</a></div></div>');

                if($("#fibersDiv .row").length > 1){
                    $(".removeFiberBtn").removeClass('hidden');
                }
                else{
                    $(".removeFiberBtn").addClass('hidden');
                }

                $(".fibers_name_text").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        // More validation rules can be added here
                        messages: {
                        required: "Please select fiber name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                });
                $(".fibers_name_value").each(function() {
                    $(this).rules("add", {
                        // required: true, // Add your desired validation rules
                        min:0,
                        // More validation rules can be added here
                        // messages: {
                        // required: "Please enter fiber value." // Custom error message for required rule
                        // // More custom error messages can be added here
                        // }
                    });
                });
            });

            $(document).on('click',".removeFiberBtn",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                $(this).closest('.row').remove();
                if($("#fibersDiv .row").length > 1){
                    $(".removeFiberBtn").removeClass('hidden');
                }
                else{

                    $(".removeFiberBtn").addClass('hidden');
                }
            });

            //testing result div
            $("#addMoreTestingResultBtn").click(function (e) {
                e.preventDefault();
                //console.log($("#SCMDiv .row:last-child .scm_name_text").data("id"));
                let id = parseInt($("#testingResultDiv .row:last-child .testing_name_text").data("id")) + 1;

                let c_id = 1;
                // console.log(id);
                // console.log(c_id);
                // $("#testingResultDiv").append('<div class="row"><div class="col-md-6"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control testing_name_text valid" type="text" name="testing_name['+id+']" value="" data-id="'+id+'" autofocus="autofocus" autocomplete="testing_name" placeholder="Testing Result Name" aria-invalid="false"></div><div class="col-md-5"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full form-control testing_name_value" type="number" name="testing_value['+id+']" value="0" min="0" required="required" autofocus="autofocus" autocomplete="testing_value" placeholder="Testing Result Value"></div><div class="col-md-1"><a class="btn btn-danger hidden removeTestingResultBtn">X</a></div></div>');
                $("#testingResultDiv").append('<div class="row"><div class="col-md-4"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-2 w-full form-control testing_name_text valid" type="text" name="testing_name['+id+']" value="" data-id="'+id+'" autofocus="autofocus" autocomplete="testing_name" placeholder="Testing Result Name" aria-invalid="false"></div><div class="col-md-6"><div class="childRowDiv"><div class="row"><div class="col-md-5 mt-2"><select class="block w-full measureDropdownColumn form-control measure_value" data-c_id='+c_id+' name="testing_value['+id+'][measure]['+c_id+']" autofocus="">'+measureValue+'</select></div><div class="col-md-3 mt-2"><select class="block form-control w-full dropdownColumn measurement_value" name="testing_value['+id+'][measure_value]['+c_id+']" autofocus>'+dropdownValue+'</select></div><div class="col-md-3 mt-2"><select class="block form-control w-full dropdownColumn testing_name_value" name="testing_value['+id+'][result_value]['+c_id+']" data-p_id="'+id+'" autofocus>'+dropdownValue+'</select></div><div class="col-md-1 mt-2"><a class="btn btn-warning hidden removechildRow">X</a></div></div></div></div><div class="col-md-2 mt-2"><a class="btn btn-info addchildRow">+</a><a class="btn btn-danger hidden removeTestingResultBtn">X</a></div></div>');

            $(".measure_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
            $(".measurement_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
            if($("#testingResultDiv .row").length > 2){
                    $(".removeTestingResultBtn").removeClass('hidden');
                }
                else{
                    $(".removeTestingResultBtn").addClass('hidden');
                }

                $(".testing_name_text").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter testing result name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });
                $(".testing_name_value").each(function(index) {
                    var data_p_id = $(this).data('p_id');
                   // console.log(data_p_id);
                    if(data_p_id != 2){
                        $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        //min:0,
                        // More validation rules can be added here
                        messages: {
                        required: "Please select testing result value." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    }
                });
            });

            $(document).on('click',".addchildRow",function(e){
                var p_id = $(this).parent().closest('.row').find('.testing_name_text').data('id');
               // console.log($(this).parent().closest('.row').find('.childRowDiv .row:last-child .measure_value'));
                var c_id = $(this).parent().closest('.row').find('.childRowDiv .row:last-child .measure_value').data('c_id')+1;
                // console.log("child pid",p_id);
                // console.log("child cid",c_id);
                $(this).parent().closest('.row').find('.childRowDiv').append('<div class="row"><div class="col-md-5 mt-2"><select class="block w-full measureDropdownColumn form-control measure_value" data-c_id='+c_id+' name="testing_value['+p_id+'][measure]['+c_id+']" autofocus="">'+measureValue+'</select></div><div class="col-md-3 mt-2"><select class="block form-control w-full dropdownColumn measurement_value" name="testing_value['+p_id+'][measure_value]['+c_id+']" autofocus>'+dropdownValue+'</select></div><div class="col-md-3 mt-2"><select class="block form-control w-full dropdownColumn testing_name_value" name="testing_value['+p_id+'][result_value]['+c_id+']" data-p_id="'+p_id+'" autofocus>'+dropdownValue+'</select></div><div class="col-md-1 mt-2"><a class="btn btn-warning hidden removechildRow">X</a></div></div>')
                    $(".measure_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
                    $(".measurement_value").select2({
                    dropdownParent: $("#afterImportExcel .modal-content"),
                    tags: true});
                if($(this).parent().closest('.row').find('.childRowDiv .row').length > 1){
                    $(this).parent().closest('.row').find('.childRowDiv .row .removechildRow').removeClass('hidden');
                }
                else{
                    $(this).parent().closest('.row').find('.childRowDiv .row .removechildRow').addClass('hidden');
                }

                $(".testing_name_value").each(function(index) {
                    var data_p_id = $(this).data('p_id');
                   // console.log(data_p_id);
                    if(data_p_id != 2){
                        $(this).rules("add", {
                        required: true, // Add your desired validation rules
                       // min:0,
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter testing result value." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    }
                });

            });

            $(document).on('click',".removechildRow",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                var childRowDiv = $(this).closest('.childRowDiv');
               // console.log(childRowDiv.children().length);
                $(this).closest('.row').remove();
                //console.log(childRowDiv.children().length);


                if(childRowDiv.children().length > 1){
                    childRowDiv.find(".removechildRow").removeClass('hidden');
                }
                else{
                    childRowDiv.find(".removechildRow").addClass('hidden');
                }
            });
            $(document).on('click',".removeTestingResultBtn",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                $(this).closest('.row').remove();
                if($("#testingResultDiv .row").length > 2){
                    $(".removeTestingResultBtn").removeClass('hidden');
                }
                else{
                    $(".removeTestingResultBtn").addClass('hidden');
                }
            });

            // $(document).on('click',".unit_radio:checked",function(e){
            //     e.preventDefault();
            //   //  console.log("jere",$(this).closest('.row'));
            //     if($(this).val() == 1){
            //         $(".metric_block").removeClass('hidden')
            //         $(".imperial_block").addClass('hidden')
            //     }
            //     else{
            //         $(".metric_block").addClass('hidden')
            //         $(".imperial_block").removeClass('hidden')
            //     }
            // });

            $('input[type=radio][name=unit]').change(function() {
                if (this.value == 1) {
                    $(".metric_block").removeClass('hidden')
                    $(".imperial_block").addClass('hidden')
                    $("input[type='text'][name='testing_name[1]']").val('Compressive Strength (MPa)');
                    $("input[type='text'][name='testing_name[2]']").val('Slump (mm)');
                    // $("input[type='number'][name='testing_value[1]']").rules('remove', 'min');
                    // $("input[type='number'][name='testing_value[1]']").rules('remove', 'max');
                    // $("input[type='number'][name='testing_value[1]']").rules("add", {
                    //     required: true, // Add your desired validation rules
                    //     min:15,
                    //     max:45,
                    //     // More validation rules can be added here
                    //     messages: {
                    //     required: "Please enter testing result value." // Custom error message for required rule
                    //     // More custom error messages can be added here
                    //     }
                    // });
                    // $("input[type='number'][name='testing_value[1]']").valid();

                }
                else {
                    //console.log("hewre");
                    $(".metric_block").addClass('hidden')
                    $(".imperial_block").removeClass('hidden')
                    $("input[type='text'][name='testing_name[1]']").val('Compressive Strength (PSI)');
                    $("input[type='text'][name='testing_name[2]']").val('Slump (inch)');

                    // $("input[type='number'][name='testing_value[1]']").rules("add", {
                    //     required: true, // Add your desired validation rules
                    //     min:2000,
                    //     max:6000,
                    //     // More validation rules can be added here
                    //     messages: {
                    //     required: "Please enter testing result value." // Custom error message for required rule
                    //     // More custom error messages can be added here
                    //     }
                    // });
                    // $("input[type='number'][name='testing_value[1]']").valid();
                    //console.log($("input[type='text'][name='testing_name[1]']").rules());
                }
            });


            $.validator.setDefaults({ ignore: '' });
            jQuery.validator.addMethod("checkMixId", function(value, element) {
            var isEmailexist = false;
            $.ajax({
                url: _checkMixId,
                type: 'POST',
                dataType:'json',
                async:false,
                data: {"_token": _token,
                    "mix_id":value
                },
                success:function(data){
                    if(data.flag == 1)
                    {
                        isEmailexist = true;
                    }
                },
                error:function(error){
                        console.log(error)
                        }
            });
            return isEmailexist;
        }, 'Mix Name already exists.');
            // Do anything
            $("#workspaceform").validate({
                rules: {
                    // mix_id:{
                    //     required:true,
                    //     //checkMixId:true,
                    //     normalizer: function( value ) {
                    //         return $.trim( value );
                    //     }
                    // },
                    source: {
                        // required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    purpose: {
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    cement:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min: 0
                    },
                    water:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min: 0
                    },
                    fine_aggregate:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min: 0
                    },
                    specific_gravity_f:{
                        //required:true,
                        // min:2,
                        // max:8
                    },
                    absorption_f:{
                        // max:10
                    },
                    moisture_content_f:{
                        // max:10
                    },
                    coarse_aggregate:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min: 0
                    },
                    dry_rodded_density_kg:{
                        //required:true,
                        // required: {
                        //     depends: function(element) {
                        //         // Check if "male" radio button is selected
                        //         return $("input[name='unit']:checked").val() == 1;
                        //     }
                        // },
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:1000,
                        // max:2200
                    },
                    dry_rodded_density_lb:{
                        // required:true,
                        // required: {
                        //     depends: function(element) {
                        //         // Check if "male" radio button is selected
                        //         return $("input[name='unit']:checked").val() == 2;
                        //     }
                        //     },
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                            // min:90,
                            // max:120
                    },
                    specific_gravity_c:{
                        // min:2,
                        // max:8
                    },
                    absorption_c:{
                        // max:10
                    },
                    moisture_content_c:{
                        // max:10
                    },
                    'scm_name[1]':{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'scm_value[1]':{
                        // required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:0
                    },
                    'admixtures_name[1]':{
                        //required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'admixtures_value[1]':{
                        // required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:0
                    },
                    'fibers_name[1]':{
                       // required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'fibers_value[1]':{
                        //required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:0
                    },
                    'testing_name[1]':{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'testing_value[1][result_value][1]':{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:0
                    },
                    'testing_name[2]':{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'testing_value[2][result_value][1]':{
                        // required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // min:0
                    }

                },
                messages: {
                    mix_id: {
                        required: "Please select mix name."
                    },
                    purpose:{
                        required:"Please select purpose."
                    },
                    cement:{
                        required:"Please select cement."
                    },
                    water:{
                        required:"Please select water."
                    },
                    fine_aggregate:{
                        required:"Please select fine aggregate."
                    },
                    coarse_aggregate:{
                        required:"Please select coarse aggregate."
                    },
                    nominal_maximum_size_mm: {
                        required:"Please select nominal maximum aggregate size"
                    },
                    nominal_maximum_size_inch: {
                        required:"Please select nominal maximum aggregate size"
                    },
                    // dry_rodded_density_kg:{
                    //     required:"Please enter dry rodded density."
                    // },
                    // dry_rodded_density_lb:{
                    //     required:"Please enter dry rodded density."
                    // },
                    'scm_name[1]':{
                        required:"Please select SCM name."
                    },
                    // 'scm_value[1]':{
                    //     required:"Please enter SCM value."
                    // },
                    'admixtures_name[1]':{
                        required:"Please select admixture name."
                    },
                    // 'admixtures_value[1]':{
                    //     required:"Please enter admixture value."
                    // },
                    'fibers_name[1]':{
                        required:"Please select fiber name."
                    },
                    // 'fibers_value[1]':{
                    //     required:"Please enter fiber value."
                    // },
                    'testing_name[1]':{
                        required:"Please enter testing result name."
                    },
                    'testing_value[1][result_value][1]':{
                        required:"Please enter testing result value."
                    },
                    'testing_name[2]':{
                        required:"Please select testing result name."
                    },
                    // 'testing_value[2]':{
                    //     required:"Please enter testing result value."
                    // }
                },
                errorPlacement: function(error, element) {
                   if(element.attr("name") == "purposef")
                    {
                        element.closest(".purpose_div").find(".error_message").html(error);
                    }else {
                        error.insertAfter(element);
                    }
                    if($("#coarse_aggregate_div input.error").length > 0){
                    if($("#coarse_aggregate_div").hasClass('hidden')){
                        $("#detail_coarse_aggregate").addClass('text-danger');
                        if($("#coarse_div_error").hasClass('hidden')){
                            $("#coarse_div_error").removeClass('hidden')
                        }
                    }

                }
                else{
                    $("#detail_coarse_aggregate").removeClass('text-danger');
                    if(!$("#coarse_div_error").hasClass('hidden')){
                        $("#coarse_div_error").addClass('hidden')
                    }
                }

                if($("#fine_aggregate_div input.error").length > 0){
                        if($("#fine_aggregate_div").hasClass('hidden')){
                            $("#detail_fine_aggregate").addClass('text-danger');
                            if($("#fine_div_error").hasClass('hidden')){
                                $("#fine_div_error").removeClass('hidden')
                            }
                        }
                    }
                    else{
                        $("#detail_fine_aggregate").removeClass('text-danger');
                        if(!$("#fine_div_error").hasClass('hidden')){
                            $("#fine_div_error").addClass('hidden')
                        }
                    }
                },
                submitHandler: function (form) {
                    event.preventDefault();
                    $('#submitBtn').prop('disabled', true);
                    var formData = $("#workspaceform").serialize();
                   // console.log("formdata",formData);
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: _import_insert_data,
                        data: $("#workspaceform").serialize(),
                        success: function (response) {
                            if(response.flag){
                               // console.log("hdfdd");
                                toastr.success(response.message);
                               // console.log("t",table);
                                table.draw();
                                deleteUploadFile();
                                $('#submitBtn').prop('disabled', false);
                                $("#afterImportExcel").modal('hide');
                            }
                            else{
                                $("#afterImportExcel").modal('hide');
                                toastr.error(response.message);
                                $('#submitBtn').prop('disabled', false);
                            }

                        },
                        error: function (response) {
                            $("#afterImportExcel").modal('hide');
                            toastr.warning("Something went wrong.");
                            //console.error(xhr.responseJSON.error);
                            $('#submitBtn').prop('disabled', false);
                        }
                    });
                }
            });
            $("#submitBtn").click(function (e) {
                //e.preventDefault();
                if($("#coarse_aggregate_div input.error").length > 0){
                    if($("#coarse_aggregate_div").hasClass('hidden')){
                        $("#detail_coarse_aggregate").addClass('text-danger');
                        if($("#coarse_div_error").hasClass('hidden')){
                            $("#coarse_div_error").removeClass('hidden')
                        }
                    }

                }
                else{
                    $("#detail_coarse_aggregate").removeClass('text-danger');
                    if(!$("#coarse_div_error").hasClass('hidden')){
                        $("#coarse_div_error").addClass('hidden')
                    }
                }

                if($("#fine_aggregate_div input.error").length > 0){
                        if($("#fine_aggregate_div").hasClass('hidden')){
                            $("#detail_fine_aggregate").addClass('text-danger');
                            if($("#fine_div_error").hasClass('hidden')){
                                $("#fine_div_error").removeClass('hidden')
                            }
                        }
                    }
                    else{
                        $("#detail_fine_aggregate").removeClass('text-danger');
                        if(!$("#fine_div_error").hasClass('hidden')){
                            $("#fine_div_error").addClass('hidden')
                        }
                    }
            });
    });

    </script>
</x-app-layout>
