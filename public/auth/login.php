<?php
require_once __DIR__ . "/../shared/components/button.php";
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

$login_btn = new Button("Login", 'primary', [
    'type' => 'submit',
]);
$email = $password = "";
$emailErr = $passwordErr = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}

?>
<div class="sign-in-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Sign In</h1>
        <div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Email" class="<?php echo !$emailErr ?: 'input-danger' ?>" value="<?php echo $email ?>">
                <?= "<span class='error-response'>{$emailErr}</span>"; ?>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password"
                    class="<?php echo !$passwordErr ?: 'input-danger' ?>"
                    value="<?php echo $password ?>">
                <?= "<span class='error-response'>{$passwordErr}</span>"; ?>
            </div>
            <div class="rememberme-container">
                <div>
                    <input type="checkbox" name="remember-me" id="remember-me">
                    <p>Remember me</p>
                </div>
                <a href="#">Forget Password</a>
            </div>
            <?php echo $login_btn->setAttribute('name', 'submit')->render() ?>
        </div>

    </form>
</div>

<?php
$footer = __DIR__ . '/../../includes/footer.php';
if (file_exists($footer)) {

    require_once $footer;
} else {
    error_log("Missing footer include: $footer");
    echo '<!-- header not found: ' . htmlspecialchars($footer, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>