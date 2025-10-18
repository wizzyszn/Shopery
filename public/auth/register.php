<?php
//Include Components, Configs, Libraries etc....
require_once __DIR__ . "/../shared/components/button.php";
require_once __DIR__ . "/../shared/components/input.php";
require_once __DIR__ . "/../../config/config.php";

//Custom pre-rendered assinged style variables
$body_classes = ["nav-theme-dark"];
$body_class = implode(' ', array_filter($body_classes));

?>
<?php
// Set server States
$errors = [];
$success = '';

// Server-side validation on form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';

    // ** Validate Form Fields
    // Validate first name
    if (empty($fname)) {
        $errors['fname'] = "First name is required";
    } elseif (strlen($fname) < 2) {
        $errors['fname'] = "First name must be at least 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $fname)) {
        $errors['fname'] = "First name can only contain letters, spaces, hyphens, and apostrophes";
    }

    // Validate last name
    if (empty($lname)) {
        $errors['lname'] = "Last name is required";
    } elseif (strlen($lname) < 2) {
        $errors['lname'] = "Last name must be at least 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $lname)) {
        $errors['lname'] = "Last name can only contain letters, spaces, hyphens, and apostrophes";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/", $password)) {
        $errors['password'] = "Password must contain uppercase, lowercase, number, and special character";
    }

    // Validate confirm password
    if (empty($cpassword)) {
        $errors['cpassword'] = "Please confirm your password";
    } elseif ($password !== $cpassword) {
        $errors['cpassword'] = "Passwords do not match";
    }

    // If no errors, process registration
    if (empty($errors)) {
        // TODO: Add database logic here to register the user
        // Hash password: password_hash($password, PASSWORD_DEFAULT)
        $success = "Registration successful! You can now login.";
        // Redirect to login page after successful registration
        // header("Location: " . BASE_URL . "/auth/login.php");
        // exit();
    }
}


try {
    $breadcrumb = new BreadCrumb();
    $breadcrumb->add("Home", url: BASE_URL)->add("Signup", BASE_URL . "/auth/register");
    $submit_btn = new Button("Register", 'primary', [
        'type' => 'submit',
    ]);
    $fname_input = new Input();
    $fname_input->setName("fname")
        ->setPlaceHolder("Enter First Name")
        ->setAttribute('id', "fname")
        ->setAttribute('minlength', '2')
        ->setAttribute('maxlength', '50')
        ->setAttribute('pattern', "[a-zA-Z\s'-]+")
        ->setAttribute('title', "Only letters, spaces, hyphens, and apostrophes allowed")
        ->setRequired()
        ->setValue($_POST['fname'] ?? '');

    $lname_input = new Input();
    $lname_input->setName("lname")
        ->setPlaceHolder("Enter Last Name")
        ->setAttribute('id', "lname")
        ->setAttribute('minlength', '2')
        ->setAttribute('maxlength', '50')
        ->setAttribute('pattern', "[a-zA-Z\s'-]+")
        ->setAttribute('title', "Only letters, spaces, hyphens, and apostrophes allowed")
        ->setRequired()
        ->setValue($_POST['lname'] ?? '');

    $email_input = new Input("email");
    $email_input->setName("email")
        ->setPlaceHolder("Enter your Email")
        ->setAttribute("id", "email")
        ->setAttribute('maxlength', '100')
        ->setRequired()
        ->setValue($_POST['email'] ?? '');


    $password_input = new Input("password");
    $password_input->setName("password")
        ->setPlaceHolder("Enter your password")
        ->setAttribute("id", "password")
        ->setAttribute('minlength', '8')
        ->setAttribute('maxlength', '128')
        ->setAttribute('pattern', "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$")
        ->setAttribute('title', "Password must be at least 8 characters with uppercase, lowercase, number, and special character")
        ->setRequired();

    $confirm_password_input = new Input("password");
    $confirm_password_input->setName("cpassword")
        ->setPlaceHolder("Confirm Password")
        ->setAttribute("id", "cpassword")
        ->setAttribute('minlength', '8')
        ->setRequired();
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
<div class="register-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" novalidate>
        <h1>Create Account</h1>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Oops! There were some issues:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div>
            <div class="input-container">
                <label for="fname">First Name: <span class="required">*</span></label>
                <?php echo $fname_input->render() ?>
                <?php if (isset($errors['fname'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errors['fname'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
            </div>

            <div class="input-container">
                <label for="lname">Last Name: <span class="required">*</span></label>
                <?php echo $lname_input->render() ?>
                <?php if (isset($errors['lname'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errors['lname'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
            </div>

            <div class="input-container">
                <label for="email">Email: <span class="required">*</span></label>
                <?php echo $email_input->render() ?>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
            </div>

            <div class="input-container">
                <label for="password">Password: <span class="required">*</span></label>
                <?php echo $password_input->render() ?>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>

                <!-- Password strength indicator -->
                <div class="password-requirements">
                    <small class="requirement-title">Password must contain:</small>
                    <div class="requirement-list">
                        <div class="requirement" id="req-length">
                            <span class="req-icon">○</span>
                            <span class="req-text">At least 8 characters</span>
                        </div>
                        <div class="requirement" id="req-lowercase">
                            <span class="req-icon">○</span>
                            <span class="req-text">One lowercase letter (a-z)</span>
                        </div>
                        <div class="requirement" id="req-uppercase">
                            <span class="req-icon">○</span>
                            <span class="req-text">One uppercase letter (A-Z)</span>
                        </div>
                        <div class="requirement" id="req-number">
                            <span class="req-icon">○</span>
                            <span class="req-text">One number (0-9)</span>
                        </div>
                        <div class="requirement" id="req-special">
                            <span class="req-icon">○</span>
                            <span class="req-text">One special character (@$!%*?&)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="input-container">
                <label for="cpassword">Confirm Password: <span class="required">*</span></label>
                <?php echo $confirm_password_input->render() ?>
                <?php if (isset($errors['cpassword'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errors['cpassword'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
                <!-- Password match indicator -->
                <div class="password-match-indicator" id="password-match-indicator" style="display: none;">
                    <span class="match-icon"></span>
                    <span class="match-text"></span>
                </div>
            </div>

            <div class="form-actions">
                <?php echo $submit_btn->render() ?>
            </div>

            <div class="form-footer">
                <p>Already have an account? <a href="<?php echo BASE_URL; ?>/public/auth/login.php">Login here</a></p>
            </div>
        </div>
    </form>
</div>

<script>
    // Client-side validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.register-form form');

        // Get password inputs - they might be inside wrapper divs
        const passwordWrapper = document.querySelector('#password')?.closest('.password-field-wrapper');
        const confirmPasswordWrapper = document.querySelector('#cpassword')?.closest('.password-field-wrapper');

        const passwordInput = passwordWrapper ? passwordWrapper.querySelector('input[type="password"], input[type="text"]') : document.getElementById('password');
        const confirmPasswordInput = confirmPasswordWrapper ? confirmPasswordWrapper.querySelector('input[type="password"], input[type="text"]') : document.getElementById('cpassword');

        const matchIndicator = document.getElementById('password-match-indicator');

        if (!passwordInput || !confirmPasswordInput) {
            console.error('Password fields not found');
            return;
        }

        // Password strength requirements
        const requirements = {
            length: {
                element: document.getElementById('req-length'),
                test: (password) => password.length >= 8
            },
            lowercase: {
                element: document.getElementById('req-lowercase'),
                test: (password) => /[a-z]/.test(password)
            },
            uppercase: {
                element: document.getElementById('req-uppercase'),
                test: (password) => /[A-Z]/.test(password)
            },
            number: {
                element: document.getElementById('req-number'),
                test: (password) => /\d/.test(password)
            },
            special: {
                element: document.getElementById('req-special'),
                test: (password) => /[@$!%*?&]/.test(password)
            }
        };

        // Check password requirements in real-time
        function checkPasswordStrength() {
            const password = passwordInput.value;
            let allValid = true;

            for (const [key, requirement] of Object.entries(requirements)) {
                if (requirement.element) {
                    const isValid = requirement.test(password);
                    const icon = requirement.element.querySelector('.req-icon');

                    if (isValid) {
                        requirement.element.classList.add('valid');
                        requirement.element.classList.remove('invalid');
                        if (icon) icon.textContent = '✓';
                    } else {
                        requirement.element.classList.remove('valid');
                        if (password.length > 0) {
                            requirement.element.classList.add('invalid');
                            if (icon) icon.textContent = '✗';
                        } else {
                            requirement.element.classList.remove('invalid');
                            if (icon) icon.textContent = '○';
                        }
                        allValid = false;
                    }
                }
            }

            return allValid;
        }

        // Real-time password match validation
        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    confirmPasswordInput.setCustomValidity('');

                    // Show success indicator
                    if (matchIndicator) {
                        matchIndicator.style.display = 'flex';
                        matchIndicator.classList.remove('mismatch');
                        matchIndicator.classList.add('match');
                        const icon = matchIndicator.querySelector('.match-icon');
                        const text = matchIndicator.querySelector('.match-text');
                        if (icon) icon.textContent = '✓';
                        if (text) text.textContent = 'Passwords match';
                    }
                    return true;
                } else {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');

                    // Show error indicator
                    if (matchIndicator) {
                        matchIndicator.style.display = 'flex';
                        matchIndicator.classList.remove('match');
                        matchIndicator.classList.add('mismatch');
                        const icon = matchIndicator.querySelector('.match-icon');
                        const text = matchIndicator.querySelector('.match-text');
                        if (icon) icon.textContent = '✗';
                        if (text) text.textContent = 'Passwords do not match';
                    }
                    return false;
                }
            } else {
                confirmPasswordInput.setCustomValidity('');

                // Hide indicator
                if (matchIndicator) {
                    matchIndicator.style.display = 'none';
                    matchIndicator.classList.remove('match', 'mismatch');
                }
                return true;
            }
        }

        // Attach event listeners
        passwordInput.addEventListener('input', function() {
            checkPasswordStrength();
            validatePasswordMatch(); // Also check match when password changes
        });

        passwordInput.addEventListener('keyup', checkPasswordStrength);
        passwordInput.addEventListener('blur', checkPasswordStrength);

        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        confirmPasswordInput.addEventListener('keyup', validatePasswordMatch);
        confirmPasswordInput.addEventListener('blur', validatePasswordMatch);

        // Form submission - allow native HTML5 validation
        form.addEventListener('submit', function(e) {
            // Validate password match before submission
            validatePasswordMatch();

            // If form is invalid, prevent submission and show validation messages
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                // Show browser validation messages
                form.reportValidity();

                return false;
            }

            // Form is valid, allow submission
            return true;
        });

        // Initial check on page load (for pre-filled values)
        if (passwordInput.value.length > 0) {
            checkPasswordStrength();
        }
        if (confirmPasswordInput.value.length > 0) {
            validatePasswordMatch();
        }
    });
</script>

<?php
$footer = __DIR__ . '/../../includes/footer.php';
if (file_exists($footer)) {
    require_once $footer;
} else {
    error_log("Missing footer include: $footer");
    echo '<!-- header not found: ' . htmlspecialchars($footer, ENT_QUOTES, 'UTF-8') . ' -->';
}
?>