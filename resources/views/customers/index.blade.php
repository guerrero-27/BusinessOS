<x-app-layout>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">
            {{ session('success')}}
        </div>
    @endif

    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Customers</h1>
            <div class="flex justify-between items-center gap-3">

                <form action="{{ route('customers.index')}}" method="GET">
                    <input type="text" name="search" value=" {{ request('search')}}" placeholder="Search by Name..." class="border-gray-300 rounded-lg shadow-sm w-64">
                    <button type="sumbmit" class="bg-gray-200 px-4 py-2 rounded-lg">Search</button>
                </form>

                <a href="{{ route('customers.create')}}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Add Customer
                </a>
            </div>
            
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-600  text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($customers as $customer)
                        <tr class="{{$loop->even ? 'bg-gray50' : 'bg-white'}} hover:bg-blue-50 transition">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{$customer->first_name}}</td>
                            <td class="px-4 py-3">{{$customer->email}}</td>
                            <td class="px-4 py-3 text-right gap-5">
                                <a href="{{ route('customers.edit', $customer)}}" class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('customers.destroy', $customer)}}" method="POST" onsubmit="return confirm('Remove this customer?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>

                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-6">
                                No customers yet. <a href="{{ route('customers.create')}}" class="text-blue-600 underline">Add your first one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>