<aside class="w-64 bg-white border-r border-gray-200 min-h-screen">

    <div class="p-6">

        <h1 class="text-2xl font-bold text-indigo-600">BusinessOS</h1>

    </div>

    <nav class="px-4 space-y-2">

        <a href="{{ route('dashboard')}}" class="{{ request()->is('dashboard')
            ? 'bg-indigo-600 text-white'
            : 'hover:bg-indigo-50 hover:text-indigo-600'}} block rounded-lg px-4 py-3">
            Dashboard
        </a>

        <a href="{{ route('customers.index')}}" class="{{ request()->is('customers') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 hover:text-indigo-600'}} block rounded-lg px-4 py-3">
            Customers
        </a>

        <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 hover:text-indigo-600' }} block rounded-lg px-4 py-3">
            Products
        </a>

        <a href="{{ route('categories.index') }}" class="{{ request()->is('categories*') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 hover:text-indigo-600' }} block rounded-lg px-4 py-3">
            Categories
        </a>

        <a href="/inventory" class="block rounded-lg px-4 py-3 hover:bg-indigo-50 hover:text-indigo-600">
            Inventory
        </a>

        <a href="/suppliers" class="block rounded-lg px-4 py-3 hover:bg-indigo-50 hover:text-indigo-600">
            Suppliers
        </a>

        <a href="/reports" class="block rounded-lg px-4 py-3 hover:bg-indigo-50 hover:text-indigo-600">
            Reports
        </a>

        <a href="/settings" class="block rounded-lg px-4 py-3 hover:bg-indigo-50 hover:text-indigo-600">
            Settings
        </a>

    </nav>
    
</aside>