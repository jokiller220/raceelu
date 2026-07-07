<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';
$db = new Database();
$db->query('DESCRIBE orders');
print_r($db->resultSet());
$db->query('DESCRIBE order_items');
print_r($db->resultSet());
