<x-app-layout>
    <style>
        .removeParentBtn{
            margin-top: 30px;
        }
    </style>
    {{-- <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Workflows</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Workflow</a></li>
                <li class="breadcrumb-item active">Add Wrokflow</li>
              </ol>
            </div>
          </div>
        </div>
      </section> --}}

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pt-4 pb-4">
            <div class="workflow-card">
                <h3 class="heading">Add Workflow</h3>
                {{-- <div class="card-header">
                </div> --}}
                <!-- /.card-header -->
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
                    {{-- <div class="text-right">
                        <a href="{{route('dashboard')}}" class="btn btn-primary">Workflows</a>
                    </div> --}}
                    <form method="POST" id="createForm" class="createForm" action="#">
                        @csrf
                        {{-- Name --}}
                        <div class="form-group">
                            <label for="name">{{__('Name')}}</label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="{{__('Enter Workflow Name')}}" value="{{old('name')}}" required autofocus autocomplete="name" />
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Roles --}}
                        <div class="form-group">
                            <label for="role">{{__('Roles')}}</label>
                            <select name="role" id="role" placeholder="{{__('Roles')}}" class="form-control custom-select-design">
                                <option value="">Choose Roles</option>
                                <option value="PRODUCER" @if (old('role') == 'PRODUCER') selected @endif>Producer</option>
                                <option value="CALCULATOR" @if (old('role') == 'CALCULATOR') selected @endif>Calculator</option>
                                <option value="VERIFIER" @if (old('role') == 'VERIFIER') selected @endif>Verifier</option>
                            </select>
                            @error('role')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Data --}}

                        <div id="stepsDiv">
                            <div class="stepContent" data-id="1">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group mb-0"><h4><label>Step 1</label></h4></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control step_role" type="text" name="step_name[1]" placeholder="{{__('Enter Name')}}" value="{{old('step_name[1]')}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label >{{__('Role')}}</label>
                                                    <select name="step_role[1]" placeholder="{{__('Select Role')}}" class="form-control step_role custom-select-design">
                                                        <option value="">Select Role</option>
                                                        <option value="PRODUCER" @if (old('step_role[1]') == 'PRODUCER') selected @endif>Producer</option>
                                                        <option value="CALCULATOR" @if (old('step_role[1]') == 'CALCULATOR') selected @endif>Calculator</option>
                                                        <option value="VERIFIER" @if (old('step_role[1]') == 'VERIFIER') selected @endif>Verifier</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-1 "><a class="btn btn-danger removeParentBtn float-right">X</a></div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label>Data</label>
                                                    <a href="javascript:void(0);" class="float-right addchildRow">+ Add Data</a>
                                                </div>
                                            </div>
                                            <div class="childRow col-md-12">
                                                <div class="row" data-c_id="1">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input class="form-control step_variable_name" type="text" name="step_variable_name[1][1]" placeholder="{{__('Variable Name')}}" value="{{old('step_variable_name[1][1]')}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input class="form-control step_data_type" type="text" name="step_data_type[1][1]" placeholder="{{__('Data type')}}" value="{{old('step_data_type[1][1]')}}" />
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-1"><a class="btn btn-warning removechildRow float-right">X</a></div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary add-step-btn" id="add_main_step">+ Add Step</button>
                        </div>

                        <div class="flex float-right items-center justify-end mt-4">
                            <button type="reset" class="btn btn-outline cancel-btn">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn submit-btn" id="submitBtn">
                                {{ __('Save') }}
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

            $(document).on('click',"#add_main_step",function(e){
                var p_id = Number($("#stepsDiv .stepContent:last-child").attr('data-id')) + 1;
                var c_id = 1;
                //console.log(p_id,c_id);
                $("#stepsDiv").append('<div class="stepContent" data-id="'+p_id+'"><div class="card"><div class="card-body"><div class="form-group mb-0"><h4><label>Step '+p_id+'</label></h4></div><div class="row"><div class="col-md-6"><div class="form-group"><label>Name</label><input class="form-control step_name" type="text" name="step_name['+p_id+']" placeholder="{{__("Enter Name")}}" value="{{old("step_name['+p_id+']")}}" /></div></div><div class="col-md-6"><div class="form-group"><label >{{__("Role")}}</label><select name="step_role['+p_id+']" placeholder="{{__("Select Role")}}" class="form-control step_role custom-select-design"><option value="">Select Role</option><option value="PRODUCER" @if (old("step_role['+p_id+']") == "PRODUCER") selected @endif>Producer</option><option value="CALCULATOR" @if (old("step_role['+p_id+']") == "CALCULATOR") selected @endif>Calculator</option><option value="VERIFIER" @if (old("step_role['+p_id+']") == "VERIFIER") selected @endif>Verifier</option></select></div><div class="removeBtn custom-step-btn"><a class="btn btn-danger removeParentBtn">X</a></div></div><div class="row full-width-row"><div class="col-md-12"><div class="form-group mb-0"><label>Data</label><a href="javascript:void(0);" class="float-right addchildRow">+ Add Data</a></div><div class="childRow col-md-12 pl-0 pr-0"><div class="row" data-c_id="1"><div class="col-md-6"><div class="form-group"><input class="form-control step_variable_name" type="text" name="step_variable_name['+p_id+']['+c_id+']" placeholder="{{__("Variable Name")}}" value="{{old("step_variable_name['+p_id+']['+c_id+']")}}" /></div></div><div class="col-md-6"><div class="form-group"><input class="form-control step_data_type" type="text" name="step_data_type['+p_id+']['+c_id+']" placeholder="{{__("Data type")}}" value="{{old("step_data_type['+p_id+']['+c_id+']")}}" /></div></div></div></div></div></div></div></div>')
                $(".step_name").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });

                $(".step_role").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please select step role." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });

                $(".step_variable_name").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter variable name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });


                    $(".step_data_type").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter data type." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                });
            });

            $(document).on('click',".removeParentBtn",function(e){
                $(this).closest(".stepContent").remove();
            });

            $(document).on('click',".addchildRow",function(e){
               // console.log();
                var p_id = $(this).closest('.stepContent').attr('data-id');
               // var p_id = $(this).parent().closest('.row').find('.').data('id');
            //    // console.log($(this).parent().closest('.row').find('.childRowDiv .row:last-child .measure_value'));
                var c_id = Number($(this).closest('.row').find('.childRow .row:last-child').attr('data-c_id'))+1;
                //console.log(p_id);

                $(this).closest('.row').find('.childRow').append('<div class="row" data-c_id="'+c_id+'"><div class="col-md-6"><div class="form-group"><input class="form-control step_variable_name" type="text" name="step_variable_name['+p_id+']['+c_id+']" placeholder="{{__("Variable Name")}}" value="{{old("step_variable_name['+p_id+']['+c_id+']")}}" /></div></div><div class="col-md-5"><div class="form-group"><input class="form-control step_data_type" type="text" name="step_data_type['+p_id+']['+c_id+']" placeholder="{{__("Data type")}}" value="{{old("step_data_type['+p_id+']['+c_id+']")}}" /></div></div><div class="removeBtn col-md-1"><a class="btn btn-warning removechildRow">X</a></div></div>');

                //console.log($(this).closest('.row').find('.childRow .row'));
                if($(this).closest('.row').find('.childRow .row').length > 1){
                    $(this).closest('.row').find('.childRow .row .removechildRow').removeClass('hidden');
                }
                else{
                    $(this).closest('.row').find('.childRow .row .removechildRow').addClass('hidden');
                }

                $(".step_variable_name").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter variable name." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });


                    $(".step_data_type").each(function() {
                   // console.log($(this));
                    $(this).rules("add", {
                        required: true, // Add your desired validation rules
                        normalizer: function( value ) {
                            return $.trim( value );
                        },
                        // More validation rules can be added here
                        messages: {
                        required: "Please enter data type." // Custom error message for required rule
                        // More custom error messages can be added here
                        }
                    });
                    });




            });

            $(document).on('click',".removechildRow",function(e){
                e.preventDefault();
              //  console.log("jere",$(this).closest('.row'));
                var childRowDiv = $(this).closest('.childRow');
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
            // Do anything
            $("#createForm").validate({
                rules: {
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
                    'step_name[1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'step_role[1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'step_variable_name[1][1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    'step_data_type[1][1]':{
                        required: true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                },
                messages: {
                    name:{
                        required:"Please enter workflow name."
                    },
                    role: {
                        required: "Please select role."
                    },
                    'step_name[1]':{
                        required:"Please enter name.",
                    },
                    'step_role[1]':{
                        required:"Please enter role."
                    },
                    'step_variable_name[1][1]':{
                        required: "Please enter variable name."
                    },
                    'step_data_type[1][1]':{
                        required: "Please enter data type."
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
        });
    </script>
</x-app-layout>
