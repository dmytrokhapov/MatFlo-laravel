<x-app-layout>
<section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid pt-4 pb-4">
            <div class="workflow-card verifier">
                <h3 class="heading">Change Password</h3>
                <!-- /.card-header -->
                <div class="card-body">
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

                        <div class="text-right mt-4">
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
            // Do anything
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
</section>
</x-app-layout>
