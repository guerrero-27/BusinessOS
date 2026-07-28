<x-app-layout>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Categories</h1>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
            class="inline-flex items-center gap-1 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
            + Add Category
        </button>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        {{-- Desktop --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Slug</th>
                        <th class="px-5 py-3">Products</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                            <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $category->products_count }}</td>
                            <td class="px-5 py-3">
                                @if ($category->is_active)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 border border-green-200 rounded-full">Active</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <button onclick="openEdit({{ $category->id }})"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</button>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Delete this category?');" class="inline">
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
                                No categories yet.
                                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                                    class="text-indigo-600 hover:underline ml-1">Add one</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse ($categories as $category)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $category->name }}</p>
                            <p class="text-gray-400 text-xs font-mono mt-0.5">{{ $category->slug }}</p>
                            <p class="text-gray-500 text-xs mt-0.5">{{ $category->products_count }} products</p>
                        </div>
                        @if ($category->is_active)
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 border border-green-200 rounded-full shrink-0">Active</span>
                        @else
                            <span class="inline-block px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200 rounded-full shrink-0">Inactive</span>
                        @endif
                    </div>
                    <div class="flex gap-4 mt-3">
                        <button onclick="openEdit({{ $category->id }})" class="text-indigo-600 text-sm font-medium">Edit</button>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                            onsubmit="return confirm('Delete this category?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-10 text-sm">No categories yet.</div>
            @endforelse
        </div>
    </div>

    @if ($categories->hasPages())
        <div class="mt-4">{{ $categories->links() }}</div>
    @endif

    {{-- Create Modal --}}
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Add Category</h2>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @include('categories._form')
                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modals --}}
    @foreach ($categories as $category)
        <div id="modal-edit-{{ $category->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-800">Edit: {{ $category->name }}</h2>
                    <button onclick="document.getElementById('modal-edit-{{ $category->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
                </div>
                <form action="{{ route('categories.update', $category) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    @include('categories._form', ['category' => $category])
                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('modal-edit-{{ $category->id }}').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        function resetCreateForm() {
            const modal = document.getElementById('modal-create');
            const form = modal?.querySelector('form');

            if (!form) return;

            form.reset();

            const nameField = form.querySelector('input[name="name"]');
            if (nameField) nameField.value = '';

            const slugField = form.querySelector('input[name="slug"]');
            if (slugField) slugField.value = '';

            const descriptionField = form.querySelector('textarea[name="description"]');
            if (descriptionField) descriptionField.value = '';

            const activeField = form.querySelector('input[name="is_active"]');
            if (activeField) activeField.checked = true;
        }

        function openCreate() {
            resetCreateForm();
            document.getElementById('modal-create').classList.remove('hidden');
        }

        function openEdit(id) {
            document.getElementById('modal-edit-' + id).classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any() && session('edit_category_id'))
                openEdit({{ session('edit_category_id') }});
            @elseif ($errors->any())
                document.getElementById('modal-create').classList.remove('hidden');
            @endif
        });
    </script>
</x-app-layout>
