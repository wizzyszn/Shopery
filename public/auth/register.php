<?php
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));
require_once __DIR__ . "/../shared/components/button.php";
require_once __DIR__ . "/../shared/components/input.php";
require_once __DIR__ . "/../../config/config.php";

$breadcrumb = new BreadCrumb();
$breadcrumb->add("Home", url: BASE_URL)->add("Signup", BASE_URL . "/auth/register")
?>
<?php
$header = __DIR__ . '/../../includes/header.php';
if (file_exists($header)) {
    require_once $header;
} else {
    error_log("Missing header include: $header");
    echo '<!-- header not found: ' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . ' -->';
}

try {
    $fname_input = new Input();
    $fname_input->setName("fname")->setPlaceHolder("Enter First Name")->setAttribute('id', "fname");
    $lname_input = new Input();
    $lname_input->setName("lname")->setPlaceHolder("Enter Last Name")->setAttribute('id', "lname");
    $email_input = new Input();
    $email_input->setName("email")->setPlaceHolder("Enter your Email")->setAttribute("id", "email");

    $password_input = new Input("password");
    $email_input->setName("password")->setPlaceHolder("Enter your password")->setAttribute("id", "password");
} catch (InvalidArgumentException $e) {
    error_log($e);
}
?>
<div class="register-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Create Account</h1>
        <div>
            <div class="input-container">
                <label for="fname">First Name:</label>
                <?php echo $fname_input->render() ?>
            </div>

            <div class="input-container">
                <label for="lname">Last Name:</label>
                <?php echo $lname_input->render() ?>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <?php echo $email_input->render() ?>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <?php echo $password_input->render() ?>
            </div>
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