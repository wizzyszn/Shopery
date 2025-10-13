<?php
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));

// Initialize breadcrumb first
require_once __DIR__ . '/../../config/config.php';
$breadcrumb = new BreadCrumb();
$breadcrumb->add("Home", BASE_URL)
    ->add("Login", BASE_URL . "/auth/login");

// Include header
$header = __DIR__ . '/../../includes/header.php';
if (file_exists($header)) {
    require_once $header;
} else {
    error_log("Missing header include: $header");
    echo '<!-- header not found: ' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>

    <?php
    $footer = __DIR__ . '/../../includes/footer.php';
    if (file_exists($footer)) {

        require_once $footer;
    } else {
        error_log("Missing footer include: $footer");
        echo '<!-- header not found: ' . htmlspecialchars($footer, ENT_QUOTES, 'UTF-8') . ' -->';
    }
    ?>
