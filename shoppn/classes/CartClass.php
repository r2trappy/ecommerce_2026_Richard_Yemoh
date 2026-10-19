<?php
require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database {

    public function isInCart($product_id, $ip) {
        $stmt = $this->conn->prepare('SELECT cart_id FROM shoppn_cart WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('is', $product_id, $ip);
        $stmt->execute();
        $found = $stmt->get_result()->num_rows > 0;
        $stmt->close();
        return $found;
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        $stmt = $this->conn->prepare('INSERT INTO shoppn_cart (p_id, ip_add, qty, customer_id) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isii', $product_id, $ip, $qty, $customer_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getCartItems($ip) {
        $stmt = $this->conn->prepare('SELECT c.cart_id, c.p_id, c.qty, p.product_title, p.product_price, p.product_image FROM shoppn_cart c JOIN shoppn_products p ON c.p_id = p.product_id WHERE c.ip_add = ? ORDER BY c.cart_id ASC');
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows ? $rows : [];
    }

    public function getCartCount($ip) {
        $stmt = $this->conn->prepare('SELECT COUNT(*) AS total FROM shoppn_cart WHERE ip_add = ?');
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return (int)$row['total'];
    }

    public function getCartTotal($ip) {
        $total = 0.0;
        foreach ($this->getCartItems($ip) as $item) {
            $total += (int)$item['qty'] * (float)$item['product_price'];
        }
        return (float)$total;
    }

    public function removeFromCart($product_id, $ip) {
        $stmt = $this->conn->prepare('DELETE FROM shoppn_cart WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('is', $product_id, $ip);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateQty($product_id, $new_qty, $ip) {
        if ($new_qty < 1) {
            return false;
        }
        $stmt = $this->conn->prepare('UPDATE shoppn_cart SET qty = ? WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('iis', $new_qty, $product_id, $ip);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
