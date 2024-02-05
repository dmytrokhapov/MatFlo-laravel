<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo">
                <a href="{{route('login')}}">MatFlo</a>
            </div>
          <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
          {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
            @if(session('error'))
                <div class="alert alert-danger text-danger" style="color:red;">
                    {{ session('error') }}
                </div>
            @endif
          <form method="POST" id="forgotpasswordform" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group mb-3">
              <p><input type="email" id="email" class="form-control" name="email" :value="old('email')" required placeholder="Email"></p>

            </div>
            <div class="row">
              <div class="col-12 mt-3 mb-2">
                <button type="submit" class="btn btn-primary btn-block">Request New Password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mt-3 mb-1 text-center">
            <a href="{{route('login')}}" class="text-white">Login</a>
          </p>
          {{-- <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p> --}}
        </div>
        <!-- /.login-card-body -->
      </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Do anything
            $("#forgotpasswordform").validate({
                rules: {
                    email: {
                        required: true,
                        email:true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email id",
                        email:"Please enter valid email id"
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
</x-guest-layout>
