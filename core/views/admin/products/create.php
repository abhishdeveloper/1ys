<?php
// core/views/admin/products/create.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Add New Product</h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/products" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">Back</a>
    </div>
</div>

<form action="/admin/products/add" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200 bg-white p-8 rounded-lg shadow">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700"> Product Name </label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700"> Category </label>
                    <div class="mt-1">
                        <select id="category_id" name="category_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo sanitize($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="price" class="block text-sm font-medium text-gray-700"> Price ($) </label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="price" id="price" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700"> Stock Quantity </label>
                    <div class="mt-1">
                        <input type="number" name="stock_quantity" id="stock_quantity" value="0" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700"> Description </label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="image" class="block text-sm font-medium text-gray-700"> Product Image </label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="image" name="image" accept="image/*" class="shadow-sm block w-full sm:text-sm border-gray-300 p-2">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG, GIF, WEBP up to 2MB.</p>
                </div>

            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Save Product</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>