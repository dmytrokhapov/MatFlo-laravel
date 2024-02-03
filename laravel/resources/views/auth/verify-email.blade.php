<x-guest-layout>
    <div class="card">
        <div class="card-body login-card-body register-card-body">
            <div class="login-logo">
                <a href="{{route('login')}}">MatFlo</a>
            </div>
    <div class="mb-4 text-sm text-gray-600 text-center">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="">
                <button class="btn btn-primary btn-block">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>
        <br>
        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="btn btn-info btn-block">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
        </div>
    </div>
</x-guest-layout>
