<?php
//Custom pre-rendered assinged style variables
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));
require_once __DIR__ . '/../config/config.php';
?>

<?php
require_once __DIR__ . '/shared/components/breadcrumb.php';
try {
    $breadcrumb = new BreadCrumb();
    $breadcrumb->add("Home", BASE_URL,);
} catch (InvalidArgumentException $e) {
    error_log($e);
}

?>
<?php
require_once __DIR__ . '/../includes/header.php'; ?>
<section class="homepage-section">
    <div class="hero-section">
        <div class="hero-cards">
            <div class="main-bannar">
                <img src="<?php echo BASE_URL ?>/assets/images/Bannar Big.png" alt="woman holding groceries">
                <div>
                    <h1>Fresh & Healthy
                        Organic Food
                    </h1>
                    <div>
                        <h4>Sale up to <span>30% OFF</span></h4>
                        <small>Free shipping on all your order.</small>
                    </div>
                    <button>Shop now
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="14" viewBox="0 0 17 14" fill="none">
                            <path d="M15.75 6.77502H0.75" stroke="#00B307" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.70001 0.75L15.75 6.774L9.70001 12.799" stroke="#00B307" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <div><img src="<?php echo BASE_URL ?>/assets/images/Bannar2.png" alt="Summer sale">
                </div>
                <div><img src="<?php echo BASE_URL ?>/assets/images/Bannar3.png" alt="Deal of the month"></div>
            </div>
        </div>
    </div>
</section>
<?php
require_once __DIR__ . "/../includes/footer.php";
?>