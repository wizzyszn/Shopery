<?php

//Include Components, Configs, Libraries etc....
require_once __DIR__ . "/../shared/components/button.php";
require_once __DIR__ . "/../shared/components/input.php";
require_once __DIR__ . '/../../config/config.php';

//Custom pre-rendered assinged style variables
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));

// Set server States
$errors = [];
$success = "";
// Server-side validation on form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Sanitize inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST["password"] ?? "";

    // ** Validate Form Fields
    // Validate Email Field
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate Password - Only check if it's provided (no complexity validation for login)
    if (empty($password)) {
        $errors["password"] = "Password is required";
    }

    if (empty($errors)) {
        // TODO: Add database logic here to verify user credentials
        // Example: Check email exists and verify password using password_verify($password, $hashed_password_from_db)

        $errors['credentials'] = "Invalid email or password";

        // When database is connected, on successful login:
        // $_SESSION['user_id'] = $user['id'];
        // $_SESSION['user_email'] = $user['email'];
        // header("Location: " . BASE_URL . "/index.php");
        // exit();
    }
}

try {
    //Intialize Custom Components
    $login_btn = new Button("Login", 'primary', [
        'type' => 'submit',
    ]);
    $breadcrumb = new BreadCrumb();
    $breadcrumb->add("Home", BASE_URL)
        ->add("Login", BASE_URL . "/auth/login");

    $email_input = new Input("email");
    $email_input->setName('email')
        ->setValue($_POST["email"] ?? "")
        ->setPlaceHolder("Enter your Email")
        ->setAttribute("id", "email")
        ->setAttribute("maxlength", "100")
        ->setAttribute('autocomplete', 'email')
        ->setRequired();

    $password_input = new Input("password");
    $password_input->setName("password")
        ->setPlaceHolder("Enter your password")
        ->setAttribute("id", "password")
        ->setAttribute('autocomplete', 'current-password')
        ->setRequired();
    // Note: No password complexity validation for login - users enter their existing password
} catch (InvalidArgumentException $e) {
    error_log($e);
}

?>




<?php
// Include header
$header = __DIR__ . '/../../includes/header.php';
if (file_exists($header)) {
    require_once $header;
} else {
    error_log("Missing header include: $header");
    echo '<!-- header not found: ' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . ' -->';
}

?>
<!--Form -->
<div class="sign-in-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Sign In</h1>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Oops! There were some issues:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li>
                            <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <div>
            <div class="input-container">
                <label for="email">Email: <span class="required">*</span></label>
                <?php echo $email_input->render() ?>
                <?php if (isset($errors["email"])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors["email"], ENT_QUOTES, "UTF-8") ?>
                    </span>
                <?php endif ?>
            </div>

            <div class="input-container">
                <label for="password">Password: <span class="required">*</span></label>
                <?php echo $password_input->render() ?>
                <?php if (isset($errors["password"])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors["password"], ENT_QUOTES, "UTF-8") ?>
                    </span>
                <?php endif ?>
            </div>

            <div class="rememberme-container">
                <div>
                    <input type="checkbox" name="remember-me" id="remember-me">
                    <p>Remember me</p>
                </div>
                <a href="#">Forgot Password?</a>
            </div>

            <div class="form-actions">
                <?php echo $login_btn->setAttribute('name', 'submit')->render() ?>
            </div>

            <div class="form-footer">
                <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/public/auth/register.php">Sign up here</a></p>
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