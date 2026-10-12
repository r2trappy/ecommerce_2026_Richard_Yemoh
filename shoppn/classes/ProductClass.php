<?php
require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database {

    public function addBrand($name) {
        $stmt = $this->conn->prepare('INSERT INTO brands (brand_name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getAllBrands() {
        $result = $this->conn->query('SELECT * FROM brands ORDER BY brand_name ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getBrandById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM brands WHERE brand_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ? $row : false;
    }

    public function updateBrand($id, $name) {
        $stmt = $this->conn->prepare('UPDATE brands SET brand_name = ? WHERE brand_id = ?');
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function addCategory($name) {
        $stmt = $this->conn->prepare('INSERT INTO categories (cat_name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getAllCategories() {
        $result = $this->conn->query('SELECT * FROM categories ORDER BY cat_name ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getCategoryById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM categories WHERE cat_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ? $row : false;
    }

    public function updateCategory($id, $name) {
        $stmt = $this->conn->prepare('UPDATE categories SET cat_name = ? WHERE cat_id = ?');
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function addProduct($cat, $brand, $title, $price, $desc, $image, $keywords) {
        $stmt = $this->conn->prepare('INSERT INTO shoppn_products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('iisdsss', $cat, $brand, $title, $price, $desc, $image, $keywords);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords) {
        $stmt = $this->conn->prepare('UPDATE shoppn_products SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?, product_desc = ?, product_image = ?, product_keywords = ? WHERE product_id = ?');
        $stmt->bind_param('iisdsssi', $cat, $brand, $title, $price, $desc, $image, $keywords, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare('SELECT p.*, c.cat_name, b.brand_name FROM shoppn_products p JOIN categories c ON p.product_cat = c.cat_id JOIN brands b ON p.product_brand = b.brand_id WHERE p.product_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ? $row : false;
    }

    public function getAllProducts() {
        $result = $this->conn->query('SELECT p.*, c.cat_name, b.brand_name FROM shoppn_products p JOIN categories c ON p.product_cat = c.cat_id JOIN brands b ON p.product_brand = b.brand_id ORDER BY p.product_id DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getFeaturedProducts($limit = 6) {
        $stmt = $this->conn->prepare('SELECT * FROM shoppn_products ORDER BY RAND() LIMIT ?');
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows ? $rows : [];
    }

    public function getProductsByCategory($cat_id) {
        $stmt = $this->conn->prepare('SELECT * FROM shoppn_products WHERE product_cat = ? ORDER BY product_id DESC');
        $stmt->bind_param('i', $cat_id);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows ? $rows : [];
    }

    public function getProductsByBrand($brand_id) {
        $stmt = $this->conn->prepare('SELECT * FROM shoppn_products WHERE product_brand = ? ORDER BY product_id DESC');
        $stmt->bind_param('i', $brand_id);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows ? $rows : [];
    }

    public function searchProducts($query) {
        $like = '%' . addcslashes($query, '%_\\') . '%';
        $stmt = $this->conn->prepare('SELECT * FROM shoppn_products WHERE product_title LIKE ? OR product_keywords LIKE ? ORDER BY product_id DESC');
        $stmt->bind_param('ss', $like, $like);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows ? $rows : [];
    }
}
