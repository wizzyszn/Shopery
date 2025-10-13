<?php

$config_file = __DIR__ . "/../config/config.php";
if (file_exists($config_file)) {
    require_once $config_file;
} {
    error_log("Missing config include: $config_file");
    echo '<!-- header not found: ' . htmlspecialchars($config_file, ENT_QUOTES, 'UTF-8') . ' -->';
}


if (!isset($breadcrumb)) {
    $breadcrumb = new BreadCrumb();
    $breadcrumb->add('Home', BASE_URL);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopery - Online Grocery Store</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body class="<?= htmlspecialchars($body_class ?? "", ENT_QUOTES, "UTF-8") ?>">
    <section>
        <?php
        $navbar = __DIR__ . '/../includes/navbar.php';
        if (file_exists($navbar)) {

            require_once $navbar;
        } else {
            error_log("Missing header include: $navbar");
            echo '<!-- header not found: ' . htmlspecialchars($navbar, ENT_QUOTES, 'UTF-8') . ' -->';
        }
        ?>
        <section class="header-section">
            <?php include "logo.php" ?>
            <div class="search-bar">
                <input type="search" name="search" id="search" placeholder="search">
                <button>search</button>
            </div>
            <?php include "cart-overview.php" ?>
        </section>
        <div class="nav-links-container">
            <div class="nav-links">
                <?php foreach (NAV_LINKS as $nav_link): ?>
                    <a href=" <?php echo $nav_link["link"]  ?>">
                        <?php echo $nav_link["name"]; ?>
                    </a>
                <?php endforeach ?>
            </div>

            <div class="phone-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M17.4359 4.375C18.9193 4.77396 20.2718 5.55567 21.358 6.64184C22.4441 7.72801 23.2258 9.08051 23.6248 10.5639" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16.5306 7.75684C17.4205 7.99622 18.2318 8.46518 18.8833 9.11675C19.5349 9.76832 20.0039 10.5796 20.2433 11.4695" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.115 13.6522C11.0224 15.5078 12.5263 17.0053 14.3859 17.9047C14.522 17.9692 14.6727 17.997 14.8229 17.9855C14.9731 17.974 15.1178 17.9235 15.2425 17.839L17.9812 16.0138C18.1022 15.933 18.2414 15.8837 18.3862 15.8702C18.5311 15.8568 18.677 15.8797 18.8107 15.9368L23.9339 18.133C24.1079 18.207 24.2532 18.3354 24.3479 18.4991C24.4426 18.6627 24.4815 18.8527 24.4589 19.0404C24.2967 20.3074 23.6784 21.4718 22.7196 22.3158C21.7608 23.1597 20.5273 23.6253 19.25 23.6254C15.3049 23.6254 11.5214 22.0582 8.73179 19.2686C5.94218 16.479 4.375 12.6955 4.375 8.75041C4.37512 7.4732 4.84074 6.23982 5.68471 5.28118C6.52867 4.32254 7.6931 3.70437 8.96 3.54241C9.14771 3.51977 9.33769 3.55873 9.50134 3.65342C9.66499 3.7481 9.79345 3.89339 9.86738 4.06741L12.0654 9.19491C12.1219 9.32739 12.1449 9.47178 12.1322 9.61527C12.1195 9.75875 12.0716 9.89688 11.9928 10.0174L10.1728 12.7982C10.0901 12.9234 10.0414 13.0679 10.0313 13.2175C10.0212 13.3672 10.05 13.517 10.115 13.6522V13.6522Z" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>(219) 555-0114</span>
            </div>
        </div>
        <div class="bread-crumbs-container">
            <?php
            echo $breadcrumb->render();
            ?>
        </div>
    </section>