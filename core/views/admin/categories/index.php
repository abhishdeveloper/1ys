<?php
// core/views/admin/categories/index.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Categories</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all product categories.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/categories/add" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add Category</a>
    </div>
</div>

<div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Slug</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?php echo sanitize($cat['name']); ?></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo sanitize($cat['slug']); ?></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php if($cat['status']): ?>
                                        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Active</span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="/admin/categories/edit?id=<?php echo $cat['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <form action="/admin/categories/delete?id=<?php echo $cat['id']; ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>