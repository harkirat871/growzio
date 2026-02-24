<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-medium" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full border-gray-300 focus:border-blue-600 focus:ring-blue-600" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-medium" />
            
            <div class="relative">
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full border-gray-300 focus:border-blue-600 focus:ring-blue-600 pr-10"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                />
                <button 
                    type="button"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-blue-600 mt-1"
                    onclick="togglePassword()"
                    aria-label="Toggle password visibility"
                >
                    <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-600" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 py-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>

    <style>

        /* Minimal CSS for this page only */
        .border-gray-300 {
            border-color: #d1d5db;
        }
        .text-gray-700 {
            color: #374151;
        }
        .text-gray-800 {
            color: #1f2937;
        }
        .text-blue-600 {
            color: #2563eb;
        }
        .hover\:text-blue-800:hover {
            color: #1e40af;
        }
        .bg-blue-600 {
            background-color: #2563eb;
        }
        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }
        .focus\:border-blue-600:focus {
            border-color: #2563eb;
        }
        .focus\:ring-blue-600:focus {
            --tw-ring-color: rgba(37, 99, 235, 0.5);
        }
        
        /* Custom styles */
        input[type="email"], 
        input[type="password"], 
        input[type="text"] {
            border-radius: 0.375rem;
            border-width: 1px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        input[type="email"]:focus, 
        input[type="password"]:focus, 
        input[type="text"]:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.5);
        }
        button[type="button"] {
            cursor: pointer;
            background: transparent;
            border: none;
        }
        #eye-icon {
            transition: color 0.15s ease;
        }
    </style>
</x-guest-layout>