<?php

//Include Components, Configs, Libraries etc....
require_once __DIR__ . "/../shared/components/button.php";
require_once __DIR__ . "/../shared/components/input.php";
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../shared/components/alert.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../shared/components/breadcrumb.php';
//Custom pre-rendered assinged style variables
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));

// Set server States
$errors = [];
$success = "";
$redirect = false;
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

        $stmt = $pdo->prepare("SELECT id,password,first_name,last_name,email FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!empty($user)) {
            $hashed_password = $user["password"];
            if (!password_verify($password, $hashed_password)) {
                $errors['credentials'] = "Invalid email or password";
                exit();
            }
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_fname"] = $user["first_name"];
            $_SESSION["user_lname"] = $user["last_name"];
            $success = "Login Successful";
            $redirect = true;
        } else {
            $errors['credentials'] = "Invalid email or password";
        }
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

    // Initialize Alert Components
    $alert_success = new Alert("success");
    $alert_error = new Alert("danger");
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
            <?php
            $successContent = '
                <div class="success-content">
                    <svg class="success-icon" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="3" fill="none" />
                        <path d="M14 24L20 30L34 16" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3 class="success-title">' . htmlspecialchars($success, ENT_QUOTES, 'UTF-8') . '</h3>';

            if (isset($redirect) && $redirect) {
                $successContent .= '
                    <p class="redirect-text">Taking you to your dashboard...</p>
                    <div class="spinner-container">';
                ob_start();
                require __DIR__ . '/../shared/components/spinner.php';
                $successContent .= ob_get_clean();
                $successContent .= '
                    </div>';
            }

            $successContent .= '
                </div>';

            echo $alert_success->setContent($successContent)->setAllowHtml(true)->render();
            ?>
        <?php endif ?>

        <?php if (!empty($errors)): ?>
            <?php
            $errorContent = '<strong>Oops! There were some issues:</strong><ul>';
            foreach ($errors as $error) {
                $errorContent .= '<li>' . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . '</li>';
            }
            $errorContent .= '</ul>';

            echo $alert_error->setContent($errorContent)->setAllowHtml(true)->render();
            ?>
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
<?php if (isset($redirect) && $redirect): ?>
    <script>
        setTimeout(function() {
            window.location.href = '<?php echo BASE_URL; ?>/public/index.php';
        }, 3000);
    </script>
<?php endif ?>

<?php
$footer = __DIR__ . '/../../includes/footer.php';
if (file_exists($footer)) {

    require_once $footer;
} else {
    error_log("Missing footer include: $footer");
    echo '<!-- header not found: ' . htmlspecialchars($footer, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>