<?php

require_once __DIR__ . '/../init.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe App</title>
    <style>
        <?= file_get_contents(__DIR__ . '/../../css/styles.css') ?>
    </style>
</head>

<body>
    <div class="header-bar">
        <form class="content" action="/">
            <input type="text" name="search" id="search" class="search" placeholder="Search for..."
                value="<?= $_GET['search'] ?? '' ?>">
            <?php if ($account): ?>
                <a href="/?user=<?= $account->user_id ?>"></a>
            <?php else: ?>
                <a href="/register">REGISTER</a>
                <a href="/login">LOG IN</a>
            <?php endif ?>
        </form>

        <input type="checkbox" name="hamburger" id="hamburger" class="hamburger">

        <nav class="menu">
            <a href="/">HOME</a>
            <?php if ($account): ?>
                <a href="/basket">BASKET</a>
                <a href="/favourites">FAVOURITES</a>
                <a href="/user/<?= $account->user_id ?>">ACCOUNT</a>
                <a href="/logout">LOG OUT</a>
            <?php endif ?>
        </nav>
    </div>