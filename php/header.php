<?php
//u24611400- Anke de Frey
//hover over button highlight
require_once __DIR__ . "/path_helper.php";

$navItems = [
    ['file' => 'index.php', 'label' => 'Book Flights', 'href' =>  '/index.php', 'class' => 'site-nav-link'],
    ['file' => 'bookings.php', 'label' => 'Bookings', 'href' => '/bookings.php', 'class' => 'site-nav-link'],
    ['file' => 'planes.php', 'label' => 'Planes', 'href' => '/planes.php', 'class' => 'site-nav-link'],
    ['file' => 'favourites.php', 'label' => 'Favourite Planes', 'href' => '/favourites.php', 'class' => 'site-nav-link'],
    ['file' => 'login.php', 'label' => 'Login', 'href' => '/php/login.php', 'class' => 'site-nav-link-login-register', 'itemClass' => 'site-nav-auth-start', 'id' => 'site-nav-login-item'],
    ['file' => 'signup.php', 'label' => 'Register', 'href' => '/php/signup.php', 'class' => 'site-nav-link-login-register', 'id' => 'site-nav-register-item'],
];
?>
<ul class="site-nav">
    <?php foreach ($navItems as $item): ?>
        <?php
        $itemClass = $item['itemClass'] ?? '';
        $itemId = $item['id'] ?? '';
        $linkClass = $item['class'];
        if ($currentPage === $item['file']) {
            $linkClass .= ' active';
        }
        ?>
        <li<?= $itemClass !== '' ? ' class="' . $itemClass . '"' : '' ?><?= $itemId !== '' ? ' id="' . $itemId . '"' : '' ?>>
            <a class="<?= $linkClass ?>" href="<?= $item['href'] ?>"><?= $item['label'] ?></a>
        </li>
    <?php endforeach; ?>
    <li id="site-nav-logout-item" class="site-nav-auth-start" hidden>
        <a class="site-nav-link-login-register" href="<?= $basePath ?>/php/logout.php">Logout</a>
    </li>
    <li class="site-nav-logo">
        <img src="<?= $basePath ?>/img/Company_name.png" alt="company name">
    </li>
</ul>
<script>
    window.PA4_BASE_PATH = <?= json_encode($basePath) ?>;
</script>
<script src="<?= $basePath ?>/js/auth-nav.js?v=<?= $authNavJsVersion ?>"></script>
