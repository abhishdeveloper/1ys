<?php
// core/views/storefront/checkout.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10">
        <!-- Order Summary Column -->
        <div class="lg:col-span-5 bg-gray-50 dark:bg-gray-800 p-8 rounded-xl border border-gray-200 dark:border-gray-700 order-2 lg:order-1 sticky top-24">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Summary</h2>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($cartItems as $item):
                    $product = $item['product'];
                ?>
                    <li class="flex py-4">
                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?php echo sanitize($product['name']); ?>
                                </h3>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    $<?php echo number_format($item['total'], 2); ?>
                                </p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Qty <?php echo $item['quantity']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <dl class="mt-8 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo number_format($subtotal, 2); ?></dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600 dark:text-gray-400">Shipping Estimate</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo number_format($shipping, 2); ?></dd>
                </div>
                <?php if (isset($discountAmount) && $discountAmount > 0): ?>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-green-600 dark:text-green-400">
                        Discount (<?php echo sanitize($_SESSION['coupon']['code']); ?>)
                    </dt>
                    <dd class="text-sm font-medium text-green-600 dark:text-green-400">-$<?php echo number_format($discountAmount, 2); ?></dd>
                </div>
                <?php endif; ?>
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                    <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">$<?php echo number_format($total, 2); ?></dd>
                </div>
            </dl>
        </div>

        <!-- Checkout Form Column -->
        <div class="lg:col-span-7 order-1 lg:order-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Checkout</h1>

            <!-- Map Styles & Scripts -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <style>
                #map { height: 300px; width: 100%; z-index: 10; }
            </style>

            <!-- Coupon Code Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mb-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Have a Coupon?</h2>
                <?php if (isset($_SESSION['coupon'])): ?>
                    <div class="flex items-center justify-between bg-green-50 dark:bg-green-900/30 p-4 rounded-md border border-green-200 dark:border-green-800">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-green-800 dark:text-green-300 font-medium">
                                <?php echo sanitize($_SESSION['coupon']['code']); ?> applied!
                            </span>
                        </div>
                        <form action="/coupon/remove" method="POST">
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium focus:outline-none">
                                Remove
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <form action="/coupon/apply" method="POST" class="flex gap-4">
                        <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                        <input type="text" name="coupon_code" placeholder="Enter coupon code (e.g., WELCOME10)" required
                            class="flex-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm uppercase">
                        <button type="submit" class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary font-medium text-sm">
                            Apply
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <form action="/checkout/process" method="POST" id="checkout-form" class="space-y-8">
                <!-- Shipping Details -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shipping Information</h2>
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pinpoint Your Exact Location</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Drag the marker or click on the map to set your exact delivery location.</p>
                            <div id="map" class="rounded-md border border-gray-300 dark:border-gray-600 shadow-sm mb-4"></div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-xs font-medium text-gray-500 dark:text-gray-400">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" readonly class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 rounded-md shadow-sm py-2 px-3 sm:text-xs focus:outline-none">
                                </div>
                                <div>
                                    <label for="longitude" class="block text-xs font-medium text-gray-500 dark:text-gray-400">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" readonly class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 rounded-md shadow-sm py-2 px-3 sm:text-xs focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                            <input type="text" id="address" name="address" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                            <input type="text" id="city" name="city" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ZIP / Postal Code</label>
                            <input type="text" id="zip" name="zip" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for Razorpay response -->
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                <!-- Payment Info -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment</h2>
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-4 sm:gap-x-4">
                        <div class="sm:col-span-4 bg-gray-50 dark:bg-gray-700/50 p-4 mb-4 rounded-md border border-gray-200 dark:border-gray-600 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-primary dark:text-gray-300 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-900 dark:text-white font-medium">Secure Payment</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pay safely via Razorpay (Credit/Debit Card, UPI, NetBanking)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-8 flex justify-end">
                    <button type="button" id="pay-button" class="bg-primary text-white px-6 py-3 border border-transparent rounded-md shadow-sm hover:bg-primary_hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary font-medium text-base shadow-[0_4px_14px_0_rgb(28,49,37,0.39)] flex items-center">
                        <span id="pay-btn-text">Proceed to Pay</span>
                        <svg id="pay-btn-spinner" class="hidden animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Initialize Leaflet Map
document.addEventListener('DOMContentLoaded', function() {
    // Default coordinates (e.g. center of India)
    let defaultLat = 20.5937;
    let defaultLng = 78.9629;

    // Try to get user's location, else use default
    const map = L.map('map').setView([defaultLat, defaultLng], 4);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

    function updateInputs(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }

    // Set initial values
    updateInputs(defaultLat, defaultLng);

    // Update inputs on marker drag
    marker.on('dragend', function (e) {
        updateInputs(marker.getLatLng().lat, marker.getLatLng().lng);
    });

    // Update marker and inputs on map click
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
    });

    // Ask for browser geolocation
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            map.setView([userLat, userLng], 13);
            marker.setLatLng([userLat, userLng]);
            updateInputs(userLat, userLng);
        });
    }
});
</script>

<!-- Razorpay Checkout JS -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('pay-button').addEventListener('click', async function(e) {
    e.preventDefault();

    const form = document.getElementById('checkout-form');

    // Basic frontend validation
    if (!form.reportValidity()) {
        return;
    }

    const btnText = document.getElementById('pay-btn-text');
    const btnSpinner = document.getElementById('pay-btn-spinner');

    // Disable button and show spinner
    this.disabled = true;
    btnText.textContent = 'Processing...';
    btnSpinner.classList.remove('hidden');

    try {
        // Collect form data
        const formData = new FormData(form);

        // Step 1: Initialize Payment (Create Razorpay Order on Backend)
        const response = await fetch('/checkout/init', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.message || 'Failed to initialize payment');
        }

        // Step 2: Configure Razorpay Options
        const options = {
            "key": data.key_id, // Enter the Key ID generated from the Dashboard
            "amount": data.order.amount, // Amount is in currency subunits.
            "currency": data.order.currency,
            "name": "<?php echo sanitize($settings['site_title'] ?? 'AAYU CARE'); ?>",
            "description": "Order Payment",
            "image": "<?php echo sanitize($settings['site_logo'] ?? 'https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png'); ?>",
            "order_id": data.order.id, // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function (response){
                // Step 4: Handle success, inject IDs into form and submit
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;

                // Change button text to indicate finalizing
                btnText.textContent = 'Finalizing Order...';

                // Submit the form to the backend process URL
                form.submit();
            },
            "prefill": {
                "name": "<?php echo sanitize($_SESSION['name'] ?? ''); ?>",
                "email": "<?php echo sanitize($_SESSION['email'] ?? ''); ?>"
            },
            "theme": {
                "color": "#1c3125" // theme primary color
            },
            "modal": {
                "ondismiss": function(){
                    // Enable button and hide spinner if modal is closed
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-btn-text').textContent = 'Proceed to Pay';
                    document.getElementById('pay-btn-spinner').classList.add('hidden');
                }
            }
        };

        // Step 3: Open Razorpay Modal
        const rzp1 = new Razorpay(options);

        rzp1.on('payment.failed', function (response){
            alert("Payment Failed. Reason: " + response.error.description);
            // Reset button
            document.getElementById('pay-button').disabled = false;
            document.getElementById('pay-btn-text').textContent = 'Proceed to Pay';
            document.getElementById('pay-btn-spinner').classList.add('hidden');
        });

        rzp1.open();

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'An error occurred while processing the payment. Please try again.');
        // Reset button
        this.disabled = false;
        btnText.textContent = 'Proceed to Pay';
        btnSpinner.classList.add('hidden');
    }
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>