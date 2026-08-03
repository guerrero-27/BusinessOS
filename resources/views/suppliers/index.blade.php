<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-[#111111]">Suppliers</h1>
            <p class="text-sm text-gray-500 mt-1">Manage supplier records for purchases and vendor relationships.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center flex-wrap">
            <form action="{{ route('suppliers.index') }}" method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search supplier..."
                    class="w-full sm:w-56 rounded-lg border border-black/10 shadow-sm text-sm focus:border-[#4CAF50] focus:ring-[#4CAF50]">
                <button type="submit" class="rounded-lg border border-black/10 bg-white px-3 py-2 text-sm text-gray-700 transition hover:bg-[#F4F5F7]">
                    Filter
                </button>
                @if (request('search'))
                    <a href="{{ route('suppliers.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
                @endif
            </form>

            <button onclick="openCreate()"
                class="inline-flex items-center justify-center gap-1 rounded-lg border border-[#111111] bg-[#111111] px-4 py-2 text-sm font-medium text-white transition hover:bg-black whitespace-nowrap">
                + Add Supplier
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white shadow-sm">
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F4F5F7] border-b border-black/10 text-[#6B7280] uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-5 py-3">Supplier</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="transition hover:bg-[#F4F5F7]">
                            <td class="px-5 py-3">
                                <div class="font-medium text-gray-800">{{ $supplier->name }}</div>
                                @if ($supplier->tax_id)
                                    <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $supplier->tax_id }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $supplier->contact_person ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $supplier->email ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $supplier->phone ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $supplier->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                    {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <button onclick="openEdit({{ $supplier->id }})" class="text-[#2f7b35] hover:text-[#1f5a25] text-sm font-medium">Edit</button>
                                    <button onclick="openDelete({{ $supplier->id }}, '{{ addslashes($supplier->name) }}')" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-10 text-sm">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="sm:hidden divide-y divide-gray-100">
            @forelse ($suppliers as $supplier)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $supplier->name }}</p>
                            @if ($supplier->contact_person)
                                <p class="text-gray-500 text-xs mt-0.5">{{ $supplier->contact_person }}</p>
                            @endif
                            @if ($supplier->email)
                                <p class="text-gray-400 text-xs mt-0.5">{{ $supplier->email }}</p>
                            @endif
                        </div>
                        <span class="inline-block px-2 py-0.5 text-xs font-medium border rounded-full {{ $supplier->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                            {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="flex gap-4 mt-3">
                        <button onclick="openEdit({{ $supplier->id }})" class="text-[#2f7b35] hover:text-[#1f5a25] text-sm font-medium">Edit</button>
                        <button onclick="openDelete({{ $supplier->id }}, '{{ addslashes($supplier->name) }}')" class="text-red-500 text-sm font-medium">Delete</button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-10 text-sm">No suppliers found.</div>
            @endforelse
        </div>
    </div>

    @if ($suppliers->hasPages())
        <div class="mt-4">{{ $suppliers->links() }}</div>
    @endif

    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Add Supplier</h2>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @include('suppliers._form')
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" class="rounded-lg border border-[#111111] bg-[#111111] px-5 py-2 text-sm font-medium text-white transition hover:bg-black">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-delete" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-800 text-center">Delete Supplier</h3>
                <p class="text-sm text-gray-500 text-center mt-1">Are you sure you want to delete <span id="delete-supplier-name" class="font-medium text-gray-800"></span>?</p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="closeDelete()" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Cancel</button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">Delete</button>
                </form>
            </div>
        </div>
    </div>

    @foreach ($suppliers as $supplier)
        <div id="modal-edit-{{ $supplier->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Edit: {{ $supplier->name }}</h2>
                    <button onclick="document.getElementById('modal-edit-{{ $supplier->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
                </div>
                <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    @include('suppliers._form', ['supplier' => $supplier])
                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('modal-edit-{{ $supplier->id }}').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                        <button type="submit" class="rounded-lg border border-[#111111] bg-[#111111] px-5 py-2 text-sm font-medium text-white transition hover:bg-black">Update Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        function openCreate() {
            const modal = document.getElementById('modal-create');
            const form = modal?.querySelector('form');
            if (form) form.reset();
            modal?.classList.remove('hidden');
        }

        function openEdit(id) {
            document.getElementById('modal-edit-' + id).classList.remove('hidden');
        }

        function openDelete(id, name) {
            document.getElementById('delete-supplier-name').textContent = name;
            document.getElementById('delete-form').action = '/suppliers/' + id;
            document.getElementById('modal-delete').classList.remove('hidden');
        }

        function closeDelete() {
            document.getElementById('modal-delete').classList.add('hidden');
        }
    </script>
</x-app-layout>
