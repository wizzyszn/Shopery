<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../shared/components/button.php';
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));

try {
    $back_home_btn = new Button("Back to Home");
} catch (InvalidArgumentException $e) {
    error_log($e);
}
?>


<?php
// Include header
$header = __DIR__ . '/../../../includes/header.php';
if (file_exists($header)) {
    require_once $header;
} else {
    error_log("Missing header include: $header");
    echo '<!-- header not found: ' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>
<section class="error-page-container">
    <div>
        <img src="<?= IMG_URL ?>/Illustration.png" alt="404">

        <div>
            <h1>Oops! page not found</h1>
            <p>Ut consequat ac tortor eu vehicula. Aenean accumsan purus eros. Maecenas sagittis tortor at metus mollis</p>
            <?php echo $back_home_btn->render() ?>
        </div>

    </div>

</section>
<?php
$footer = __DIR__ . '/../../../includes/footer.php';
if (file_exists($footer)) {

    require_once $footer;
} else {
    error_log("Missing footer include: $footer");
    echo '<!-- header not found: ' . htmlspecialchars($footer, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>