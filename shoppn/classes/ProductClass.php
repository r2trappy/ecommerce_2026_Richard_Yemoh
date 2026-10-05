<?php
require_once __DIR__ . '/../core/db_class.php';


class ProductClass extends Database {

    public function getAllBrands() {
        $result = $this->conn->query('SELECT * FROM brands ORDER BY brand_name ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllCategories() {
        $result = $this->conn->query('SELECT * FROM categories ORDER BY cat_name ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
