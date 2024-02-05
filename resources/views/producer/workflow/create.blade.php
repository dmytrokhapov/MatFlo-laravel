<x-app-layout>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid pt-4 pb-4">
            <div class="workflow-card producer">
                <div class="workflow-header d-md-flex d-block justify-content-md-between">
                    <h3 class="heading">Initiate Workflow</h3>
                    <div class="">
                        <span>
                            Sync product from Reducible.ai 
                        </span>
                        <button type="button" class="btn btn-theme">
                            <img src="{{asset('img/sync.png')}}" />
                            Sync Now
                        </button>
                    </div>
                </div>
                <div class="card-body">
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
                    
                    <div class="text-left">
                        <h4>Inventory</h4>
                    </div>
                    <table class="table product-overview" id="tblInventory">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Name</th>
                                <th>GWP (KG CO2-eq)</th>
                                <th>EPD Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Orlando, FL</td>
                                <td>Orlando | 6000 PSI at 28 days</td>
                                <td>370</td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td>San Francisco, CA</td>
                                <td>San Francisco | 5500 PSI at 28 Days</td>
                                <td>267</td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td>Orlando, FL</td>
                                <td>Orlando | 6000 PSI at 28 days</td>
                                <td>370</td>
                                <td>No</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <form method="POST" id="createForm" class="createForm" action="#">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="text-left">
                                    <h4>Product Selection</h4>
                                </div>
                                @csrf
                                {{-- Select Product --}}
                                <div class="form-group">
                                    <label for="product">{{__('Select Product')}}</label>
                                    <select name="product" id="product" placeholder="{{__('Select Product')}}" class="form-control custom-select-design">
                                        <option value="Orlando | 6000 PSI at 28 days" @if (old('product') == 'Orlando | 6000 PSI at 28 days') selected @endif>Orlando | 6000 PSI at 28 days</option>
                                        <option value="San Francisco | 5500 PSI at 28 Days" @if (old('product') == 'San Francisco | 5500 PSI at 28 Days') selected @endif>San Francisco | 5500 PSI at 28 Days</option>
                                    </select>
                                    @error('product')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-left mt-2 form-group">
                                    <h5 id="productHeading">Orlando | 6000 PSI at 28 days</h5>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="name">{{__('Name')}}</label>
                                            <input id="name" class="form-control" type="text" name="name" placeholder="{{__('Name')}}" value="{{old('name')}}" autofocus autocomplete="name" />
                                            @error('name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Role -->
                                        <div class="col-md-6">
                                            <label for="role">{{__('Your Role')}}</label>
                                            <input id="role" class="form-control" type="text" name="role" placeholder="{{__('Role')}}" value="{{old('role')}}" autofocus autocomplete="role" />
                                            @error('role')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <label for="data"><b>{{__('Data')}}</b></label>
                                        </div>
                                        
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn-link btn" id="addMoreDataBtn">
                                                {{ __('+ Add More') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="dataDiv">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input id="variable_name" class="form-control variable_name" type="text" name="variable_name[1]" value="{{old('variable_name')}}" data-id="1" required autofocus autocomplete="variable_name" placeholder="Variable Name" />
                                                {{-- <x-input-error :messages="$errors->get('variable_name')" class="mt-2" /> --}}
                                                @error('variable_name')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <input id="data_type" class="form-control data_type" type="text" name="data_type[1]" value="{{old('data_type')}}" data-id="1" required autofocus autocomplete="data_type" placeholder="Data Type" />
                                                {{-- <x-input-error :messages="$errors->get('data_type')" class="mt-2" /> --}}
                                                @error('data_type')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <div class="removeBtn"><a class="btn btn-danger hidden removeDataBtn" >X</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12 mt-3">
                                        <button type="button" class="btn btn-primary" id="addMoreDataBtn">
                                            {{ __('Add More +') }}
                                        </button>
                                    </div> --}}

                                </div>

                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <button type="reset" class="btn btn-outline cancel-btn">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn submit-btn" id="submitBtn">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>



    <script type="text/javascript">
        $(document).ready(function() {
            // Do anything
            $("#createForm").validate({
                rules: {
                    product:{
                        required:true
                    },
                    name:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    role: {
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'variable_name[1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'data_type[1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                },
                messages: {
                    product:{
                        required:"Please select product",
                    },
                    name:{
                        required:"Please enter name"
                    },
                    role: {
                        required: "Please enter role",
                    },
                    'variable_name[1]':{
                        required:"Please enter variable name",
                    },
                    'data_type[1]':{
                        required:"Please enter data type"
                    },
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#submitBtn').prop('disabled', true);
                    form.submit();
                    //submit via ajax
                },
                errorPlacement: function(error, element) {
                    // Customize the placement of error messages
                    error.insertAfter(element);
                },
                success: function(label, element) {
                    // Hide the error message label
                    label.hide();
                },
            });
        
            $("#product").change( function(){
                $('#productHeading').html($(this).val());
            })
                    
        });
    </script>


    <script>
        // scm div
        $("#addMoreDataBtn").click(function (e) {
            e.preventDefault();
            console.log($("#dataDiv .row:last-child .variable_name").data("id"));
            let id = parseInt($("#dataDiv .row:last-child .variable_name").data("id")) + 1;
            $("#dataDiv").append('<div class="row mt-2"><div class="col-md-6"><input class="form-control variable_name" data-id="'+id+'" type="text" name="variable_name['+id+']" required="required" autofocus="autofocus" autocomplete="variable_name" placeholder="Variable Name"></div><div class="col-md-5"><input class="form-control data_type" type="text" name="data_type['+id+']" autofocus="autofocus" autocomplete="data_type" placeholder="Data Type"></div><div class="removeBtn col-md-1"><a class="btn btn-danger removeDataBtn">X</a></div></div>')
            if($("#dataDiv .row").length > 1){
                $(".removeDataBtn").removeClass('hidden');
            }
            else{
                $(".removeDataBtn").addClass('hidden');
            }

            $(".variable_name").each(function() {
                $(this).rules("add", {
                    required: true, // Add your desired validation rules
                    // More validation rules can be added here
                    messages: {
                    required: "Please enter variable name." // Custom error message for required rule
                    // More custom error messages can be added here
                    }
                });
                });
            $(".data_type").each(function() {
                $(this).rules("add", {
                    required: true, // Add your desired validation rules
                    // More validation rules can be added here
                    messages: {
                    required: "Please enter data type." // Custom error message for required rule
                    // More custom error messages can be added here
                    }
                });
            });


        });

        $(document).on('click',".removeDataBtn",function(e){
            e.preventDefault();
            //  console.log("jere",$(this).closest('.row'));
            $(this).closest('.row').remove();
            if($("#dataDiv .row").length > 1){
                $(".removeDataBtn").removeClass('hidden');
            }
            else{
                $(".removeDataBtn").addClass('hidden');
            }
        });

        $("#tblInventory").DataTable({
            "displayLength": 10,
            "order": [[ 1, "asc" ]]
        });

    </script>
</x-app-layout>
