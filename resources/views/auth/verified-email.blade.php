<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo">
                <a href="{{route('dashboard')}}">MatFlo</a>
            </div>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Verification is successful and you can now login.') }}
        </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>
</x-guest-layout>
