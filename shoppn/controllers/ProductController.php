<?php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductClass();
    }

    public function getAllBrands() {
        return $this->productModel->getAllBrands();
    }

    public function getAllCategories() {
        return $this->productModel->getAllCategories();
    }
}
