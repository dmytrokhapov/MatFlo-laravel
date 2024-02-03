<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo">
                <a href="{{route('login')}}">MatFlo</a>
            </div>
          <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
          <form method="POST" id="resetpasswordform" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="form-group mb-3">

                <p><input id="email" class="form-control" type="email" name="email" readonly value="{{old('email', $request->email)}}"></p>
            </div>
            <div class="form-group mb-3">
                <p>
                    <input  id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
                    <span class="passwordBtn"><img src="{{asset('img/eye.svg')}}" alt="Eye Image"></span>
                </p>
            </div>
            <div class="form-group mb-3">
              <p><input id="password_confirmation" class="form-control"
              type="password"
              name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password"> <span class="passwordBtn"><img src="{{asset('img/eye.svg')}}" alt="Eye Image"></span></p>

            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Change password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mt-3 mb-1 text-center">
            <a href="{{route('login')}}" class="text-white">Login</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".passwordBtn").click(function(e){
                //console.log($(this).parent().find('input'));
                if ($(this).parent().find('input').attr("type") === "password") {
                    $(this).parent().find('input').attr("type", "text");
                    $(this).find('img').attr("src", "{{asset('img/eye-off.svg')}}"); // Change image to eye-off.svg
                } else {
                    $(this).parent().find('input').attr("type", "password");
                    $(this).find('img').attr("src", "{{asset('img/eye.svg')}}"); // Change image back to eye.svg
                }
            });
            // Do anything
            $("#resetpasswordform").validate({
                rules: {
                    // email: {
                    //     required: true,
                    //     email:true
                    // },
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
                    // email: {
                    //     required: "Please enter email id",
                    //     email:"Please enter valid email id"
                    // },
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
</x-guest-layout>
