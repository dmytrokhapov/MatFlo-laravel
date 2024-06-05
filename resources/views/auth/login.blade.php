<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <a href="{{route('login')}}">MatFlo</a>
            </div>
            <h3>Sign In</h3>
            <p class="">Welcome back to MatFlo Platform</p>
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
            @endif
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    <span>{{ $errors->first('password') }}</span>
                </div>
            @endif
            {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
            <form method="POST" id="loginform" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-2">
                    <label for="email">Username</label>
                    <p><img src="{{asset('img/user.svg')}}" alt="User Image"> <input id="email" class="form-control"
                            type="email" name="email"
                            value="@if(\Cookie::get('user_email') !== null){{ \Cookie::get('user_email') }}@else{{ old('email') }}@endif"
                            placeholder="Enter Email" autocomplete="email"> </p>
                </div>
                <div class="form-group mb-2">
                    <label for="password">Password</label>
                    <p class="password">
                        <img src="{{asset('img/password.svg')}}" alt="Password Image">
                        <input id="password" class="form-control" type="password" id="password" name="password" required
                            value="@if(\Cookie::get('user_password') !== null){{ \Cookie::get('user_password') }}@endif"
                            placeholder="Enter Password">
                        <span class="passwordBtn"><img src="{{asset('img/eye.svg')}}" alt="Eye Image"></span>
                    </p>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" @if(\Cookie::get('user_email') !==null)
                                checked @endif>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6 forgot-pwd">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12 mt-5 mb-5">
                        <button class="btn btn-primary form-control">Sign In</button>
                    </div>
                </div>
            </form>
            <p class="mb-0 text-center">
                Don't have an account?<a href="{{route('register')}}" class="text-white">Signup</a>
            </p>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {

        $(".passwordBtn").click(function(e) {
            // console.log($(this).parent().find('input'));
            if ($(this).parent().find('input').attr("type") === "password") {
                $(this).parent().find('input').attr("type", "text");
                $(this).find('img').attr("src",
                    "{{asset('img/eye-off.svg')}}"); // Change image to eye-off.svg
            } else {
                $(this).parent().find('input').attr("type", "password");
                $(this).find('img').attr("src",
                    "{{asset('img/eye.svg')}}"); // Change image back to eye.svg
            }
        });
        // Do anything
        $("#loginform").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter email id",
                    email: "Please enter valid email id"
                },
                password: {
                    required: "Please enter password"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                $('#submitBtn').prop('disabled', true);
                // signIn();
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
