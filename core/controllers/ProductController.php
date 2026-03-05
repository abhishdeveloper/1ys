<?php
// core/controllers/ProductController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController {
    private $db;
    private $productModel;
    private $categoryModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    /**
     * Display the product catalog (All products or filtered by category)
     */
    public function index($categorySlug = null) {
        $filters = [];
        $currentCategory = null;

        // Fetch all active categories for the sidebar
        $categories = $this->categoryModel->getAllActive();

        if ($categorySlug) {
            $currentCategory = $this->categoryModel->findBySlug($categorySlug);
            if ($currentCategory) {
                $filters['category_id'] = $currentCategory['id'];
                $pageTitle = sanitize($currentCategory['name']) . " | AAYU CARE";
                $metaDescription = "Explore our premium Ayurvedic range of " . sanitize($currentCategory['name']) . ". " . sanitize($currentCategory['description']);
            } else {
                // Category not found
                http_response_code(404);
                $pageTitle = "Category Not Found";
                require_once __DIR__ . '/../views/storefront/404.php';
                exit();
            }
        } else {
            $pageTitle = "All Ayurvedic Products | AAYU CARE";
            $metaDescription = "Browse our complete catalog of authentic Ayurvedic medicines, herbal oils, and natural skincare products.";
        }

        // Fetch products based on filters
        $products = $this->productModel->getProducts($filters);

        // Load the catalog view
        require_once __DIR__ . '/../views/storefront/products/index.php';
    }

    /**
     * Display a single product details page
     */
    public function show($productSlug) {
        if (!$productSlug) {
            redirect('/products');
        }

        $product = $this->productModel->findBySlug($productSlug);

        if (!$product) {
            http_response_code(404);
            $pageTitle = "Product Not Found";
            require_once __DIR__ . '/../views/storefront/404.php';
            exit();
        }

        $pageTitle = sanitize($product['name']) . " | AAYU CARE";
        $metaDescription = mb_strimwidth(sanitize($product['description']), 0, 150, "...");
        $ogImage = sanitize($product['image_url']);

        // Fetch related products (same category)
        $relatedProducts = $this->productModel->getProducts(['category_id' => $product['category_id']]);
        // Filter out the current product and limit to 4
        $relatedProducts = array_filter($relatedProducts, function($p) use ($product) {
            return $p['id'] !== $product['id'];
        });
        $relatedProducts = array_slice($relatedProducts, 0, 4);

        // Load the product details view
        require_once __DIR__ . '/../views/storefront/products/show.php';
    }

    /**
     * Display a full page of search results
     */
    public function searchResults() {
        // Enforce string type to prevent array-injection TypeError in sanitize() or PDO
        $query = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';
        $filters = [];

        if (!empty($query)) {
            $filters['search'] = $query; // Do not sanitize before DB query
        }

        $categories = $this->categoryModel->getAllActive();
        $products = $this->productModel->getProducts($filters);

        $pageTitle = "Search Results | AAYU CARE";

        // We reuse the product catalog index view
        require_once __DIR__ . '/../views/storefront/products/index.php';
    }

    /**
     * AJAX Endpoint for the intelligent search bar
     */
    public function search() {
        // Output JSON
        header('Content-Type: application/json');

        $query = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';

        if (strlen($query) < 2) {
            echo json_encode([]);
            exit();
        }

        // Do not sanitize before database query; PDO handles SQL injection.
        // We will sanitize the output in the JSON or on the frontend.
        $searchParam = '%' . $query . '%';

        // Use a direct query for search to limit results for the dropdown
        $stmt = $this->db->prepare("
            SELECT id, name, slug, price, image_url
            FROM products
            WHERE (name LIKE :search1 OR description LIKE :search2)
            AND is_active = 1
            ORDER BY name ASC
            LIMIT 5
        ");
        $stmt->execute([
            'search1' => $searchParam,
            'search2' => $searchParam
        ]);
        $results = $stmt->fetchAll();

        // Sanitize output
        foreach ($results as &$result) {
            $result['name'] = sanitize($result['name']);
            if (!empty($result['image_url'])) {
                $result['image_url'] = sanitize($result['image_url']);
            }
        }

        echo json_encode($results);
        exit();
    }
}
?>