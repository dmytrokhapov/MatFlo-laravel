<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo">
                <a href="{{route('dashboard')}}">MatFlo</a>
            </div>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>
    <script>
        postSignUp("{{\Auth::user()->wallet}}", "{{\Auth::user()->role}}", "");
    </script>
</x-guest-layout>
