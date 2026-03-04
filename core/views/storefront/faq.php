<?php
// core/views/storefront/faq.php
require_once __DIR__ . '/partials/header.php';

$faqs = [
    [
        'q' => 'What is your return policy?',
        'a' => 'We offer a 30-day money-back guarantee on all unused items in their original packaging. Please contact our support team to initiate a return.'
    ],
    [
        'q' => 'How long does shipping take?',
        'a' => 'Standard shipping typically takes 3-5 business days within the contiguous US. Expedited shipping options are available at checkout.'
    ],
    [
        'q' => 'Do you ship internationally?',
        'a' => 'Currently, we only ship within the United States and Canada. We are working on expanding our international shipping options soon.'
    ],
    [
        'q' => 'How can I track my order?',
        'a' => 'Once your order has shipped, you will receive an email with a tracking link. You can also view the status of your order in your account Dashboard.'
    ],
    [
        'q' => 'Can I change or cancel my order?',
        'a' => 'Orders can be changed or cancelled within 1 hour of placement. After that, the order enters our processing queue and cannot be modified.'
    ]
];
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Frequently Asked Questions</h1>
        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Can't find the answer you're looking for? Reach out to our <a href="/contact" class="text-primary hover:underline">customer support</a> team.</p>
    </div>

    <div class="space-y-8">
        <?php foreach ($faqs as $faq): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white"><?php echo sanitize($faq['q']); ?></h3>
                <p class="mt-2 text-base text-gray-500 dark:text-gray-400"><?php echo sanitize($faq['a']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>