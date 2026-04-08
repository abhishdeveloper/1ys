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
                    <label for="how_to_use" class="block text-sm font-medium text-gray-700"> How To Use </label>
                    <div class="mt-1">
                        <textarea id="how_to_use" name="how_to_use" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"><?php echo sanitize($product['how_to_use'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="ingredients" class="block text-sm font-medium text-gray-700"> Ingredients </label>
                    <div class="mt-1">
                        <textarea id="ingredients" name="ingredients" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"><?php echo sanitize($product['ingredients'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="benefits" class="block text-sm font-medium text-gray-700"> Benefits </label>
                    <div class="mt-1">
                        <textarea id="benefits" name="benefits" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"><?php echo sanitize($product['benefits'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2"> Product Badges </label>
                    <div class="flex gap-4">
                        <?php
                        $badges = !empty($product['badges']) ? json_decode($product['badges'], true) : [];
                        if (!is_array($badges)) $badges = [];
                        ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="badges[]" value="Bestseller" <?php echo in_array('Bestseller', $badges) ? 'checked' : ''; ?> class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2">Bestseller</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="badges[]" value="New Arrival" <?php echo in_array('New Arrival', $badges) ? 'checked' : ''; ?> class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2">New Arrival</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="badges[]" value="Vegan" <?php echo in_array('Vegan', $badges) ? 'checked' : ''; ?> class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2">Vegan</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="badges[]" value="Cruelty-Free" <?php echo in_array('Cruelty-Free', $badges) ? 'checked' : ''; ?> class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2">Cruelty-Free</span>
                        </label>
                    </div>
                </div>

                <div class="sm:col-span-6 border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-lg font-medium text-gray-700"> FAQ Section </label>
                        <button type="button" id="add-faq" class="text-sm bg-gray-100 px-3 py-1 rounded border hover:bg-gray-200">Add FAQ</button>
                    </div>
                    <div id="faq-container" class="space-y-4">
                        <?php
                        $faqs = !empty($product['faqs']) ? json_decode($product['faqs'], true) : [];
                        if (is_array($faqs)):
                            foreach($faqs as $faq):
                        ?>
                            <div class="flex gap-4 items-start border p-4 rounded bg-gray-50">
                                <div class="flex-1 space-y-2">
                                    <input type="text" name="faq_questions[]" value="<?php echo sanitize($faq['question']); ?>" placeholder="Question" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                    <textarea name="faq_answers[]" rows="2" placeholder="Answer" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border"><?php echo sanitize($faq['answer']); ?></textarea>
                                </div>
                                <button type="button" class="remove-btn text-red-600 hover:text-red-800 font-medium text-sm px-2 py-1">Remove</button>
                            </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <div class="sm:col-span-6 border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-lg font-medium text-gray-700"> Product Variants (Sizes/Volumes) </label>
                        <button type="button" id="add-variant" class="text-sm bg-gray-100 px-3 py-1 rounded border hover:bg-gray-200">Add Variant</button>
                    </div>
                    <div id="variant-container" class="space-y-4">
                        <?php
                        // Fetch existing variants
                        global $db;
                        $stmt = $db->prepare("SELECT * FROM product_variants WHERE product_id = :id");
                        $stmt->execute(['id' => $product['id']]);
                        $variants = $stmt->fetchAll();
                        foreach ($variants as $variant):
                        ?>
                            <div class="grid grid-cols-5 gap-4 items-end border p-4 rounded bg-gray-50">
                                <div class="col-span-1">
                                    <input type="hidden" name="variant_id[]" value="<?php echo $variant['id']; ?>">
                                    <label class="block text-xs text-gray-500 mb-1">Name (e.g. 50g)</label>
                                    <input type="text" name="variant_name[]" value="<?php echo sanitize($variant['name']); ?>" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs text-gray-500 mb-1">SKU</label>
                                    <input type="text" name="variant_sku[]" value="<?php echo sanitize($variant['sku']); ?>" class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs text-gray-500 mb-1">Price</label>
                                    <input type="number" step="0.01" name="variant_price[]" value="<?php echo $variant['price']; ?>" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs text-gray-500 mb-1">Stock</label>
                                    <input type="number" name="variant_stock[]" value="<?php echo $variant['stock_quantity']; ?>" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
                                </div>
                                <div class="col-span-1 flex justify-end pb-1">
                                    <button type="button" class="remove-btn text-red-600 hover:text-red-800 font-medium text-sm">Remove</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">If you add variants, the base price and stock above will be ignored on the storefront.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqContainer = document.getElementById('faq-container');
    const addFaqBtn = document.getElementById('add-faq');

    addFaqBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'flex gap-4 items-start border p-4 rounded bg-gray-50';
        div.innerHTML = `
            <div class="flex-1 space-y-2">
                <input type="text" name="faq_questions[]" placeholder="Question" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                <textarea name="faq_answers[]" rows="2" placeholder="Answer" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border"></textarea>
            </div>
            <button type="button" class="remove-btn text-red-600 hover:text-red-800 font-medium text-sm px-2 py-1">Remove</button>
        `;
        faqContainer.appendChild(div);
    });

    const variantContainer = document.getElementById('variant-container');
    const addVariantBtn = document.getElementById('add-variant');

    addVariantBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'grid grid-cols-5 gap-4 items-end border p-4 rounded bg-gray-50';
        div.innerHTML = `
            <div class="col-span-1">
                <label class="block text-xs text-gray-500 mb-1">Name (e.g. 50g)</label>
                <input type="text" name="variant_name[]" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
            </div>
            <div class="col-span-1">
                <label class="block text-xs text-gray-500 mb-1">SKU</label>
                <input type="text" name="variant_sku[]" class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
            </div>
            <div class="col-span-1">
                <label class="block text-xs text-gray-500 mb-1">Price</label>
                <input type="number" step="0.01" name="variant_price[]" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
            </div>
            <div class="col-span-1">
                <label class="block text-xs text-gray-500 mb-1">Stock</label>
                <input type="number" name="variant_stock[]" value="0" required class="block w-full border-gray-300 rounded-md sm:text-sm p-2 border">
            </div>
            <div class="col-span-1 flex justify-end pb-1">
                <input type="hidden" name="variant_id[]" value="">
                <button type="button" class="remove-btn text-red-600 hover:text-red-800 font-medium text-sm">Remove</button>
            </div>
        `;
        variantContainer.appendChild(div);
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-btn')) {
            e.target.closest('div.border.p-4').remove();
        }
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>