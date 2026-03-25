<?php
// core/views/admin/products/edit.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Edit Product: <?php echo sanitize($product['name']); ?></h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/products" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">Back</a>
    </div>
</div>

<form action="/admin/products/edit?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200 bg-white p-8 rounded-lg shadow">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700"> Product Name </label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="<?php echo sanitize($product['name']); ?>" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700"> Category </label>
                    <div class="mt-1">
                        <select id="category_id" name="category_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo sanitize($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="price" class="block text-sm font-medium text-gray-700"> Price ($) </label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="price" id="price" value="<?php echo $product['price']; ?>" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700"> Stock Quantity </label>
                    <div class="mt-1">
                        <input type="number" name="stock_quantity" id="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700"> Description </label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"><?php echo sanitize($product['description']); ?></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700"> Current Image </label>
                    <div class="mt-2 flex items-center">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo sanitize($product['image_url']); ?>" alt="" class="h-32 w-32 object-cover rounded-md border border-gray-200">
                        <?php else: ?>
                            <span class="text-sm text-gray-500">No image uploaded.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="image" class="block text-sm font-medium text-gray-700"> Upload New Image </label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="image" name="image" accept="image/*" class="shadow-sm block w-full sm:text-sm border-gray-300 p-2">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG, GIF up to 2MB. Leave blank to keep current image.</p>
                </div>

                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2"> Current Additional Images </label>
                    <?php
                    $additionalImages = $product['additional_images'] ? json_decode($product['additional_images'], true) : [];
                    if (!empty($additionalImages)): ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <?php foreach ($additionalImages as $idx => $imgUrl): ?>
                                <div class="relative group">
                                    <img src="<?php echo sanitize($imgUrl); ?>" class="h-24 w-24 object-cover rounded-md border border-gray-200">
                                    <div class="absolute top-1 left-1">
                                        <input type="checkbox" name="remove_additional_images[]" value="<?php echo htmlspecialchars($imgUrl); ?>" id="remove_img_<?php echo $idx; ?>" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer">
                                        <label for="remove_img_<?php echo $idx; ?>" class="sr-only">Remove this image</label>
                                    </div>
                                    <div class="mt-1 text-xs text-red-600 font-medium">Check to remove</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="text-sm text-gray-500 block mb-4">No additional images uploaded.</span>
                    <?php endif; ?>
                </div>

                <div class="sm:col-span-6">
                    <label for="additional_images" class="block text-sm font-medium text-gray-700"> Upload Additional Images </label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="additional_images" name="additional_images[]" accept="image/*" multiple class="shadow-sm block w-full sm:text-sm border-gray-300 p-2">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Select multiple images to add to the gallery.</p>
                </div>

                <div class="sm:col-span-6">
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="is_active" name="is_active" type="checkbox" <?php echo $product['is_active'] ? 'checked' : ''; ?> class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Active</label>
                            <p class="text-gray-500">Product is visible on the public storefront.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Save Changes</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>