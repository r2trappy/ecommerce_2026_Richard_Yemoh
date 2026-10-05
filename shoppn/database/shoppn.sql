

CREATE TABLE IF NOT EXISTS brands (
  brand_id INT AUTO_INCREMENT PRIMARY KEY,
  brand_name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS categories (
  cat_id INT AUTO_INCREMENT PRIMARY KEY,
  cat_name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS customer (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100) NOT NULL,
  customer_email VARCHAR(50) NOT NULL UNIQUE,
  customer_pass VARCHAR(255) NOT NULL,
  customer_country VARCHAR(100) DEFAULT NULL,
  customer_city VARCHAR(100) DEFAULT NULL,
  customer_contact VARCHAR(20) DEFAULT NULL,
  customer_image VARCHAR(255) DEFAULT NULL,
  user_role INT NOT NULL DEFAULT 2,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS shoppn_products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  product_cat INT NOT NULL,
  product_brand INT NOT NULL,
  product_title VARCHAR(150) NOT NULL,
  product_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  product_desc TEXT,
  product_image VARCHAR(255) DEFAULT NULL,
  product_keywords VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_cat) REFERENCES categories(cat_id),
  FOREIGN KEY (product_brand) REFERENCES brands(brand_id)
);

CREATE TABLE IF NOT EXISTS cart (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  p_id INT NOT NULL,
  customer_id INT DEFAULT NULL,
  ip_add VARCHAR(45) NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (p_id) REFERENCES shoppn_products(product_id)
);

CREATE TABLE IF NOT EXISTS orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  invoice_no VARCHAR(20) NOT NULL,
  order_date DATETIME NOT NULL,
  order_status VARCHAR(20) NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE IF NOT EXISTS orderdetails (
  orderdetail_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (product_id) REFERENCES shoppn_products(product_id)
);


INSERT INTO brands (brand_name) VALUES ('Generic'), ('Nike'), ('Samsung');
INSERT INTO categories (cat_name) VALUES ('Uncategorized'), ('Electronics'), ('Clothing');
