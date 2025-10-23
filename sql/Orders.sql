CREATE TABLE Orders(
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
total_amount DECIMAL(10,2) NOT NULL,
order_status ENUM("Pending","Shipped","Delivered","Processing","Cancelled") DEFAULT "Pending",
payment_method ENUM("Card","BankTransfer") DEFAULT "Card",
shipped_address VARCHAR(255),
city VARCHAR(50),
postal_code VARCHAR(20),
country VARCHAR(50),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);