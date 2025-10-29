# Shopery - Online Grocery Store

A modern, feature-rich online grocery store web application built with PHP, featuring user authentication, shopping cart functionality, order management, and an admin panel for product management.

## 🚀 Features

### Customer Features
- **User Authentication**: Secure registration and login system with password hashing
- **Product Browsing**: Browse products organized by categories
- **Shopping Cart**: Add, update, and remove items from cart
- **Checkout Process**: Complete order placement with shipping details
- **Order Tracking**: View order history and status
- **User Profile**: Manage personal information and addresses

### Admin Features
- **Product Management**: Add, edit, and delete products
- **Order Management**: View and manage customer orders
- **Category Management**: Organize products into categories
- **Admin Dashboard**: Overview of store operations

## 🛠️ Technology Stack

### Backend
- **PHP 7.4+**: Server-side scripting language
- **MySQL**: Relational database management system
- **PDO**: PHP Data Objects for secure database interactions

### Frontend
- **HTML5**: Markup language
- **CSS3**: Styling with custom component-based architecture
- **JavaScript**: Client-side interactivity
- **Google Fonts**: Typography (Poppins font family)

### Architecture
- **MVC-inspired structure**: Separation of concerns with organized directories
- **Component-based UI**: Reusable PHP components for buttons, inputs, alerts
- **Session Management**: Secure user session handling
- **Prepared Statements**: SQL injection prevention

## 📁 Project Structure

```
Shopery/
├── assets/                    # Static assets
│   ├── css/                  # Stylesheets
│   │   ├── base/            # Base styles
│   │   ├── components/      # Component styles
│   │   ├── layout/          # Layout styles
│   │   ├── pages/           # Page-specific styles
│   │   ├── utilities/       # Utility classes
│   │   └── style.css        # Main stylesheet
│   ├── images/              # Images and graphics
│   └── js/                  # JavaScript files
│       └── scripts.js
├── config/                   # Configuration files
│   ├── config.php           # Application configuration
│   └── db.php               # Database connection
├── includes/                 # Shared includes
│   ├── header.php           # Page header
│   ├── footer.php           # Page footer
│   ├── navbar.php           # Navigation bar
│   ├── logo.php             # Logo component
│   ├── cart-overview.php    # Cart widget
│   ├── cart_fucntions.php   # Cart helper functions
│   └── functions.php        # General helper functions
├── public/                   # Public-facing pages
│   ├── admin/               # Admin panel
│   │   ├── index.php       # Admin dashboard
│   │   ├── add_product.php # Add new product
│   │   ├── edit_product.php# Edit product
│   │   ├── view_orders.php # Order management
│   │   └── login.php       # Admin login
│   ├── auth/                # Authentication pages
│   │   ├── login.php       # User login
│   │   ├── register.php    # User registration
│   │   └── logout.php      # User logout
│   ├── shared/              # Shared components
│   │   ├── components/     # Reusable UI components
│   │   │   ├── alert.php   # Alert component
│   │   │   ├── breadcrumb.php # Breadcrumb navigation
│   │   │   ├── button.php  # Button component
│   │   │   ├── input.php   # Input component
│   │   │   └── spinner.php # Loading spinner
│   │   └── pages/          # Shared page templates
│   │       └── 404.php     # Not found page
│   ├── index.php            # Homepage
│   ├── product.php          # Product details
│   ├── cart.php             # Shopping cart
│   ├── checkout.php         # Checkout page
│   └── order_success.php    # Order confirmation
├── sql/                      # Database schemas
│   ├── grocery_store.sql    # Complete database setup
│   ├── User.sql             # User table schema
│   ├── Products.sql         # Products table schema
│   ├── Categories.sql       # Categories table schema
│   ├── Cart_Items.sql       # Cart items table schema
│   ├── Orders.sql           # Orders table schema
│   ├── Order_Items.sql      # Order items table schema
│   └── Admins.sql           # Admin users table schema
├── .env                      # Environment variables (git ignored)
├── .htaccess                 # Apache configuration
└── README.md                 # This file
```

## 🗄️ Database Schema

The application uses a relational database with the following main tables:

### User
Stores customer information
- `id`: Primary key
- `first_name`, `last_name`: User name
- `email`: Unique email address
- `password`: Hashed password
- `phone`, `address`, `city`, `postal_code`, `country`: Contact details
- `created_at`: Registration timestamp

### Products
Store inventory
- `id`: Primary key
- `category_id`: Foreign key to Categories
- `name`: Product name
- `description`: Product details
- `price`: Product price (DECIMAL)
- `stock`: Available quantity
- `image_url`: Product image path
- `is_featured`: Featured product flag
- `created_at`: Creation timestamp

### Categories
Product categories
- `id`: Primary key
- `name`: Unique category name
- `description`: Category description

### Cart_Items
Shopping cart storage
- `id`: Primary key
- `user_id`: Foreign key to User
- `product_id`: Foreign key to Products
- `quantity`: Item quantity
- `added_at`: Addition timestamp

### Orders
Customer orders
- `id`: Primary key
- `user_id`: Foreign key to User
- `total_amount`: Order total (DECIMAL)
- `order_status`: ENUM (Pending, Shipped, Delivered, Processing, Cancelled)
- `payment_method`: ENUM (Card, BankTransfer)
- `shipped_address`, `city`, `postal_code`, `country`: Shipping details
- `created_at`: Order timestamp

### Order_Items
Order line items
- `id`: Primary key
- `order_id`: Foreign key to Orders
- `product_id`: Foreign key to Products
- `quantity`: Item quantity
- `price`: Price at time of order
- `created_at`: Creation timestamp

### Admins
Administrative users
- `id`: Primary key
- `name`: Admin name
- `email`: Admin email
- `password`: Hashed password
- `created_at`: Creation timestamp

## 🔧 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server (with mod_rewrite enabled)
- Composer (optional, for future dependency management)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/wizzyszn/Shopery.git
   cd Shopery
   ```

2. **Configure web server**
   - Set document root to the project directory
   - Ensure `.htaccess` is enabled
   - Example Apache virtual host:
     ```apache
     <VirtualHost *:80>
         ServerName shopery.local
         DocumentRoot /path/to/Shopery
         <Directory /path/to/Shopery>
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
     ```

3. **Create database**
   ```bash
   mysql -u root -p
   CREATE DATABASE SHOPERY;
   exit;
   ```

4. **Import database schema**
   ```bash
   mysql -u root -p SHOPERY < sql/grocery_store.sql
   ```
   
   Or import individual table schemas:
   ```bash
   mysql -u root -p SHOPERY < sql/User.sql
   mysql -u root -p SHOPERY < sql/Categories.sql
   mysql -u root -p SHOPERY < sql/Products.sql
   mysql -u root -p SHOPERY < sql/Cart_Items.sql
   mysql -u root -p SHOPERY < sql/Orders.sql
   mysql -u root -p SHOPERY < sql/Order_Items.sql
   mysql -u root -p SHOPERY < sql/Admins.sql
   ```

5. **Configure database connection**
   
   Edit `config/db.php` and update with your database credentials:
   ```php
   $host = "127.0.0.1";
   $dbname = "SHOPERY";
   $username = "root";
   $password = "your_password_here";
   ```
   
   **Note**: For production, use environment variables instead of hardcoded credentials.

6. **Set up environment file** (optional)
   
   Create a `.env` file for environment-specific configuration:
   ```
   DB_HOST=127.0.0.1
   DB_NAME=SHOPERY
   DB_USER=root
   DB_PASS=your_password
   ```

7. **Set permissions**
   ```bash
   chmod 755 public/
   chmod 644 public/*.php
   ```

8. **Access the application**
   - Open your browser and navigate to: `http://localhost/Shopery/public/index.php`
   - Or if using virtual host: `http://shopery.local/public/index.php`

## ⚙️ Configuration

### Application Settings
Edit `config/config.php` to customize:
- Base URL and asset paths (auto-configured based on server)
- Navigation links
- Application constants

### Database Settings
Edit `config/db.php` to configure:
- Database host
- Database name
- Username and password
- PDO options

### Navigation Links
Customize navigation menu in `config/config.php`:
```php
define("NAV_LINKS", [
    ['name' => "Home", 'link' => "#"],
    ['name' => "Shop", 'link' => "#"],
    // Add more links...
]);
```

## 📖 Usage Guide

### For Customers

1. **Registration**
   - Navigate to Sign Up page
   - Fill in required information (first name, last name, email, password)
   - Submit form to create account

2. **Login**
   - Navigate to Sign In page
   - Enter email and password
   - Click Login button

3. **Shopping**
   - Browse products on homepage
   - Click on products to view details
   - Add items to cart
   - Adjust quantities in cart

4. **Checkout**
   - Review cart items
   - Enter shipping information
   - Select payment method
   - Submit order

5. **Order Management**
   - View order history
   - Track order status

### For Administrators

1. **Admin Login**
   - Navigate to `/public/admin/login.php`
   - Enter admin credentials

2. **Product Management**
   - Add new products with details
   - Edit existing products
   - Manage product inventory
   - Set featured products

3. **Order Management**
   - View all customer orders
   - Update order status
   - Process shipments

## 🏗️ Development

### Component System

The application uses a component-based approach for UI elements:

**Button Component** (`public/shared/components/button.php`)
```php
$button = new Button("Click Me", "primary");
$button->setAttribute("id", "myButton");
echo $button->render();
```

**Input Component** (`public/shared/components/input.php`)
```php
$input = new Input("email");
$input->setName("email")
      ->setPlaceHolder("Enter email")
      ->setRequired();
echo $input->render();
```

**Alert Component** (`public/shared/components/alert.php`)
```php
$alert = new Alert("success");
$alert->setContent("Operation successful!");
echo $alert->render();
```

**Breadcrumb Component** (`public/shared/components/breadcrumb.php`)
```php
$breadcrumb = new BreadCrumb();
$breadcrumb->add("Home", BASE_URL)
           ->add("Products", BASE_URL . "/products");
echo $breadcrumb->render();
```

### Security Features

- **Password Hashing**: Uses `password_hash()` and `password_verify()`
- **Prepared Statements**: PDO prepared statements prevent SQL injection
- **Input Sanitization**: `trim()` and validation on all user inputs
- **HTML Encoding**: `htmlspecialchars()` prevents XSS attacks
- **Session Management**: Secure session handling for authentication
- **CSRF Protection**: (Recommended to implement for production)

### Code Style Guidelines

- Use PSR-12 coding standards for PHP
- Class names use PascalCase
- Method names use camelCase
- File names match class names
- Indent with 4 spaces
- Always escape output with `htmlspecialchars()`
- Use prepared statements for database queries

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Errors**
   - Verify database credentials in `config/db.php`
   - Ensure MySQL service is running
   - Check database exists and user has proper permissions

2. **404 Errors on Page Navigation**
   - Ensure `.htaccess` is enabled
   - Verify `mod_rewrite` is enabled in Apache
   - Check file paths in configuration

3. **Session Issues**
   - Ensure `session_start()` is called before any output
   - Check PHP session configuration
   - Verify session storage directory has write permissions

4. **CSS/JS Not Loading**
   - Verify asset paths in `config/config.php`
   - Check BASE_URL configuration matches your setup
   - Ensure asset files exist in correct directories

## 📝 Future Enhancements

- Implement product search functionality
- Add product filtering and sorting
- Integrate payment gateway (Stripe, PayPal)
- Email notifications for orders
- Product reviews and ratings
- Wishlist functionality
- Inventory alerts for low stock
- Admin analytics dashboard
- Mobile responsive design improvements
- RESTful API for mobile app integration

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is available for educational purposes. Please add appropriate license if needed.

## 👥 Authors

- **wizzyszn** - Initial work

## 📞 Contact

For questions or support, please open an issue on the GitHub repository.

---

**Note**: This application is a demonstration project and should undergo security hardening before production deployment. Consider implementing:
- Environment-based configuration management
- CSRF token protection
- Rate limiting on authentication endpoints
- Input validation library
- Logging system
- Error handling middleware
- Automated testing suite
