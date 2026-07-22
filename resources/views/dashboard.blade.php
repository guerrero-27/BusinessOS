<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Customers</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Inactive</p>
            <p class="text-3xl font-bold text-gray-400 mt-1">{{ $stats['inactive'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">New This Month</p>
            <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $stats['new'] }}</p>
        </div>
    </div>

    {{-- Recent Customers --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">Recent Customers</h2>
            <a href="{{ route('customers.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">View all →</a>
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recent as $customer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $customer->email }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-5 py-3">
                                @if ($customer->is_active)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 border border-green-200 rounded-full">Active</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-400 text-xs">{{ $customer->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                No customers yet. <a href="{{ route('customers.create') }}" class="text-indigo-600 hover:underline">Add one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse ($recent as $customer)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $customer->email }}</p>
                        </div>
                        @if ($customer->is_active)
                            <span class="text-xs font-medium bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">Active</span>
                        @else
                            <span class="text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 px-2 py-0.5 rounded-full">Inactive</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $customer->created_at->format('M d, Y') }}</p>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">
                    No customers yet. <a href="{{ route('customers.create') }}" class="text-indigo-600 hover:underline">Add one</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
