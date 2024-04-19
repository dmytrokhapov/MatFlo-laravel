<x-app-layout>
    <section>
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Profile</h1>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
                <div class="card ml-2 mr-2 col-xs-12 col-md-8">
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 >Change Profile</h4>
                        <hr>
                        @if(session('profile-status'))
                            <div class="alert alert-success">
                                {{ session('profile-status') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="post" id="profile-form" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <!-- Avatar -->
                            <div class="form-group">
                                <label for="image">{{__('Avatar')}}</label>
                                <br />
                                <img src="{{$user->image}}" id="blah" width="100" />
                                <p></p>
                                <input id="image" style="line-height: 1.2;" class="form-control" type="file" name="image" autocomplete="image" value="{{old('image', $user->image)}}" onChange="chooseFile()" />
                                @error('image')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="user_name">{{__('Name')}}</label>
                                <input id="user_name" class="form-control" type="text" name="user_name" autocomplete="user_name"  value="{{old('name', $user->user_name)}}"/>
                                @error('user_name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="email">{{__('Email')}}</label>

                                <input id="email" class="form-control"
                                                type="text"
                                                name="email"
                                                required value="{{old('email', $user->email)}}" />

                                    @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800">
                                            {{ __('Your email address is unverified.') }}

                                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="btn btn-success" id="submitBtn1">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                        




                        <br>
                        <br>
                        <h4 >Change Password</h4>
                        <hr>
                        @if(session('success-password'))
                            <div class="alert alert-success">
                                {{ session('success-password') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="post" id="updatepasswordform" class="createForm" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <!-- Name -->
                            <div class="form-group">
                                <label for="current_password">{{__('Current Password')}}</label>
                                <input id="current_password" class="form-control" type="password" name="current_password" autocomplete="current_password" />
                                @error('current_password')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">{{__('Password')}}</label>

                                <input id="password" class="form-control"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />


                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation">{{__('Confirm Password')}}</label>

                                <input id="password_confirmation" class="form-control"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />


                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="btn btn-success" id="submitBtn2">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                  </div>
              <!-- /.row -->
            </div>
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
            <!-- /.container-fluid -->
          </section>
<section>




    <script type="text/javascript">
        $(document).ready(function() {
            // Do anything
            $("#profile-form").validate({
                rules: {
                    email: {
                        required: true,
                        email:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                    name:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email id",
                        email:"Please enter valid email id"
                    },
                    name:{
                        required:"Please enter name"
                    }
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#submitBtn1').prop('disabled', true);
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

            $("#updatepasswordform").validate({
                rules: {
                    current_password: {
                        required: true,
                    },
                    password:{
                        required:true,
                        minlength:8
                    },
                    password_confirmation:{
                        required:true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Please enter current password.",
                    },
                    password:{
                        required:"Please enter password"
                    },
                    password_confirmation:{
                        required:"Please enter password confirmation",
                       // equalTo:"Password confirmation not match with pa"
                    }
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#submitBtn2').prop('disabled', true);
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

        function chooseFile(event) {
            const [file] = image.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

</x-app-layout>
