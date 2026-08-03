<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-[#111111]">Settings</h1>
            <p class="mt-1 text-sm text-[#6B7280]">Manage your profile, password, and account preferences.</p>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white p-4 shadow-sm sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
