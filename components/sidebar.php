<?php

require_once ROOT_DIR . '/utils/is_active_page.php';

$primary_links = array(
    array('name' => 'Matches', 'icon' => 'favorite', 'url' => '/pages/app/matches.php'),
    array('name' => 'Chats', 'icon' => 'forum', 'url' => '/pages/app/chats.php'),
);
$secondary_links = array(
    array('name' => 'Notifications', 'icon' => 'notifications', 'url' => '/pages/app/notifications.php'),
    array('name' => 'Profile', 'icon' => 'account_circle', 'url' => '/pages/app/profile.php'),
);

function generateNavSidebarButtons($links)
{
    $buttons = array();

    foreach ($links as $link) {
        $isActive = isActivePage($link['url']);
        $href = BASE_URL . $link['url'];
        $icon = $link['icon'];
        $name = $link['name'];
        $isFilled = $isActive == 'active' ? 'material-symbols-rounded-filled' : '';

        $buttons[] = <<< HTML
        <a class="sidebar-nav-btn $isActive" href="$href">
            <span class="sidebar-nav-btn-icon material-symbols-rounded $isFilled">$icon</span>
            <!-- <span class="sidebar-nav-btn-text">$name</span> -->
        </a>
        HTML;
    }

    return implode('', $buttons);
}


?>

<nav class="sidebar-nav">
    <div class="logo-container">
        <img src="<?php echo BASE_URL; ?>/public/images/logo-black.png" alt="Phira logo" class="logo">
    </div>
    <div class="primary-buttons">
        <?php echo generateNavSidebarButtons($primary_links); ?>
    </div>
    <div class="secondary-buttons">
        <?php echo generateNavSidebarButtons($secondary_links); ?>
    </div>
</nav>
