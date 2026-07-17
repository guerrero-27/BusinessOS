<x-app-layout>

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold">Customers</h1>

            <p class="mt-2 text-gray-600">Manage all customer Records.</p>
        </div>

        <x-button>
            + Add Customer
        </x-button>

    </div>

    <div class="mt-8">
        <x-card>
            No Customers Found.
        </x-card>
    </div>

</x-app-layout>