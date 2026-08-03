<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-xl font-semibold text-[#111111]">Customers</h1>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <form action="{{ route('customers.index') }}" method="GET" class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name..."
                    class="w-full sm:w-56 rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]"
                >
                <button type="submit" class="px-3 py-2 bg-white border border-black/10 rounded-lg text-sm text-gray-700 hover:bg-[#F4F5F7] transition whitespace-nowrap">
                    Search
                </button>
            </form>

            <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center gap-1 rounded-lg border border-[#111111] bg-[#111111] px-4 py-2 text-sm font-medium text-white transition hover:bg-black whitespace-nowrap">
                + Add Customer
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
        {{-- Desktop table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F4F5F7] border-b border-black/10 text-[#6B7280] uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($customers as $customer)
                        <tr class="transition hover:bg-[#F4F5F7]">
                            <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $customer->email }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-5 py-3">
                                @if ($customer->is_active)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 border border-green-200 rounded-full">Active</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-[#2f7b35] hover:text-[#1f5a25] text-sm font-medium">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Remove this customer?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-10 text-sm">
                                No customers found.
                                <a href="{{ route('customers.create') }}" class="text-[#2f7b35] hover:underline ml-1">Add one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile card list --}}
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse ($customers as $customer)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                            <p class="text-gray-500 text-xs mt-0.5">{{ $customer->email }}</p>
                            @if ($customer->phone)
                                <p class="text-gray-500 text-xs">{{ $customer->phone }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            @if ($customer->is_active)
                                <span class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Active</span>
                            @else
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-4 mt-3">
                        <a href="{{ route('customers.edit', $customer) }}" class="text-[#2f7b35] hover:text-[#1f5a25] text-sm font-medium">Edit</a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Remove this customer?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-10 text-sm">
                    No customers found.
                    <a href="{{ route('customers.create') }}" class="text-[#2f7b35] hover:underline ml-1">Add one</a>
                </div>
            @endforelse
        </div>
    </div>

    @if ($customers->hasPages())
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    @endif
</x-app-layout>
