<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo mb-5">
                <a href="{{route('login')}}">MatFlo</a>
            </div>
    <form method="POST" id="formSignUp" action="{{ route('register') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="role">Role</label>
            <p>
                <select name="role" id="userRoles" class="form-control custom-select-design" placeholder="Select Role">
                    <option value="">Select Role</option>
                    <option value="PRODUCER">Producer</option>
                    <option value="CALCULATOR">Calculator</option>
                    <option value="VERIFIER">Verifier</option>
                </select>
            </p>
        </div>
        <div class="form-group mb-3">
            <label for="name">Full Name</label>
            <p>
                <input  id="userName" class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="Enter Full Name">
            </p>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <p>
                <input  id="email" class="form-control" type="email" name="email" value="{{old('email')}}" placeholder="Email Address">
            </p>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <p>
                <input  id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
                <span class="passwordBtn"><img src="{{asset('img/eye.svg')}}" alt="Eye Image"></span>
            </p>
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">{{__('Confirm Password')}}</label>
            <p>
                <input id="password_confirmation" class="form-control"  type="password" name="password_confirmation" placeholder="{{__('Confirm Password')}}">
                <span class="passwordBtn"><img src="{{asset('img/eye.svg')}}" alt="Eye Image"></span>
            </p>
        </div>

        <input type="hidden" class="form-control" id="wallet" name="wallet">


        <!-- Name -->

        <div class="row">
            <div class="col-12 mt-4">
                <button class="btn btn-primary form-control">Sign Up</button>
            </div>
          </div>
    </form>
        </div>
    </div>
    {{-- <script type="text/javascript" src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script> --}}
    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>
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
            $("#formSignUp").validate({
                rules: {
                    role:{
                        required:true
                    },
                    name:{
                        required:true
                    },
                    email: {
                        required: true,
                        email:true
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
                    role:{
                        required:"Please select role."
                    },
                    name:{
                        required:"Please enter name."
                    },
                    email: {
                        required: "Please enter email id.",
                        email:"Please enter valid email id."
                    },
                    password:{
                        required:"Please enter password."
                    },
                    password_confirmation:{
                        required:"Please enter password confirmation."
                    },
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#submitBtn').prop('disabled', true);
                    //signUp();
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
