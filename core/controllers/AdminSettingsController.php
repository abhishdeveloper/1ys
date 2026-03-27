<?php
// core/controllers/AdminSettingsController.php

class AdminSettingsController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin') {
            redirect('/login');
        }
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSettings();
        }

        $stmt = $this->db->query("SELECT * FROM settings");
        $settingsRaw = $stmt->fetchAll();
        $settings = [];
        foreach ($settingsRaw as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $pageTitle = "Site Settings | Admin Panel";
        require_once __DIR__ . '/../views/admin/settings/index.php';
    }

    private function saveSettings() {
        $keys = [
            'promo_banner_1', 'promo_banner_2', 'promo_banner_3',
            'contact_whatsapp', 'contact_email',
            'smtp_host', 'smtp_port', 'smtp_user', 'smtp_password',
            'smtp_encryption', 'smtp_from_email', 'smtp_from_name',
            'shiprocket_email', 'shiprocket_password',
            'razorpay_key_id', 'razorpay_key_secret'
        ];

        try {
            $this->db->beginTransaction();

            // Handle text settings
            // Use INSERT ... ON DUPLICATE KEY UPDATE to ensure new keys are saved even if missing from DB initially
            $stmt = $this->db->prepare("
                INSERT INTO settings (setting_key, setting_value)
                VALUES (:key, :val)
                ON DUPLICATE KEY UPDATE setting_value = :val
            ");

            foreach ($keys as $key) {
                if (isset($_POST[$key])) {
                    $val = sanitize($_POST[$key]);
                    // Only save password if it is not empty, so we don't overwrite with a blank
                    if (in_array($key, ['smtp_password', 'shiprocket_password']) && empty($val)) {
                        continue;
                    }
                    $stmt->execute(['val' => $val, 'key' => $key]);
                }
            }

            // Handle logo upload
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $safeFileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['site_logo']['name']));
                $fileName = 'logo_' . time() . '_' . $safeFileName;
                $targetFile = $uploadDir . $fileName;

                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $targetFile)) {
                        $imageUrl = '/uploads/' . $fileName;
                        $stmt->execute(['val' => $imageUrl, 'key' => 'site_logo']);
                    }
                }
            }

            $this->db->commit();
            setFlashMessage('success', 'Settings updated successfully.');
        } catch (Exception $e) {
            $this->db->rollBack();
            setFlashMessage('error', 'Error updating settings.');
        }

        redirect('/admin/settings');
    }
}
?>