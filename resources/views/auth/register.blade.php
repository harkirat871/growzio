<x-guest-layout>
    <div style="margin-bottom: 1.75rem;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">Create your account</h1>
        <p style="font-size: 0.9375rem; color: #64748b; margin-top: 0.25rem;">Join us — it only takes a minute.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="e.g. John Doe"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business name</label>
            <input id="business_name" type="text" name="business_name" value="{{ old('business_name') }}" autocomplete="organization"
                placeholder="e.g. ABC Traders"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('business_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="gst_number" class="block text-sm font-medium text-gray-700 mb-1">GST number <span class="text-gray-500 font-normal">(optional, 15-character GSTIN)</span></label>
            <input id="gst_number" type="text" name="gst_number" value="{{ old('gst_number') }}"
                placeholder="e.g. 22AABCU9603R1Z5"
                pattern="[0-9]{2}[A-Za-z]{5}[0-9]{4}[A-Za-z][1-9A-Za-z]Z[0-9A-Za-z]"
                title="15-character GSTIN: 2 digits + 5 letters + 4 digits + 1 letter + 1 char + Z + 1 char (e.g. 22AABCU9603R1Z5)"
                maxlength="20"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('gst_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
            <input id="contact_number" type="tel" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="tel"
                placeholder="e.g. 9876543210 or +91 9876543210"
                pattern="(\+91)?[6-9][0-9]{9}"
                title="10-digit Indian mobile number (starting with 6, 7, 8 or 9)"
                maxlength="14"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('contact_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="e.g. you@example.com"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Min. 8 characters"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Re-enter password"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
        </div>

        <div>
            <label for="referred_by" class="block text-sm font-medium text-gray-700 mb-1">Referred by <span class="text-gray-400 font-normal">(optional)</span></label>
            <input id="referred_by" type="text" name="referred_by" value="{{ old('referred_by') }}"
                placeholder="Name or code of referrer"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            @error('referred_by')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Already have an account? Sign in</a>
            <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                Create account
            </button>
        </div>
    </form>
    <script>
        document.getElementById('gst_number')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/\s/g, '');
        });
    </script>
</x-guest-layout>
