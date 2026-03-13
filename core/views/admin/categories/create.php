<?php
// core/views/admin/categories/create.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Add New Category</h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/categories" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">Back</a>
    </div>
</div>

<form action="/admin/categories/add" method="POST" class="space-y-8 divide-y divide-gray-200 bg-white p-8 rounded-lg shadow">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-6">
                    <label for="name" class="block text-sm font-medium text-gray-700"> Category Name </label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700"> Description </label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Save Category</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>