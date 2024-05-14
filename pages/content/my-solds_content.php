<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../../pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../../templates/account.tpl.php');
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/product.class.php');
    require_once(__DIR__ . '/../../database/user.class.php');

    $db = getDatabaseConnection();
    
    $username = $session->getUsername();
    $user = User::getUserByUsername($db, $username);
    $address = Address::getAddressById($db, $user->addressId);
    $solds = Order::getSoldsByUsername($db, $username);

    drawTransactions($db, $solds, 'solds');
?>