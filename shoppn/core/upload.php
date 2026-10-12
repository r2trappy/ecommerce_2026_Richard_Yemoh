<?php
function save_product_image($file) {
    if (!isset($file) || !is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['filename' => null, 'error' => null];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            return ['filename' => null, 'error' => 'The image is too large. Maximum size is 2MB.'];
        }
        return ['filename' => null, 'error' => 'The image could not be uploaded.'];
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return ['filename' => null, 'error' => 'The image is too large. Maximum size is 2MB.'];
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        return ['filename' => null, 'error' => 'The image could not be uploaded.'];
    }

    $info = @getimagesize($file['tmp_name']);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if ($info === false || !isset($allowed[$info['mime']])) {
        return ['filename' => null, 'error' => 'Only JPG, PNG, GIF and WEBP images are allowed.'];
    }

    $ext = $allowed[$info['mime']];
    $base = pathinfo(basename($file['name']), PATHINFO_FILENAME);
    $base = preg_replace('/[^A-Za-z0-9_-]/', '_', $base);
    $base = substr($base, 0, 60);
    if ($base === '') {
        $base = 'image';
    }

    $filename = uniqid() . '_' . $base . '.' . $ext;
    $dir = __DIR__ . '/../images/products/';

    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $dir . $filename)) {
        return ['filename' => null, 'error' => 'The image could not be saved on the server.'];
    }

    return ['filename' => $filename, 'error' => null];
}
