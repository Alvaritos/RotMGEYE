<?php
/**
 * index.php
 * Created at 5/19/14
 */

include 'engine/engine.php';
include 'layout/header.html';

$cache = new Cache('latest_deaths', 60);

if ($cache->hasExpired()) {

    $latest_deaths = $db->simpleQuery('SELECT * FROM death ORDER BY time');
    $cache->setContent($latest_deaths);

} else {

    $latest_deaths = $cache->loadCache();
}

if (isset($_GET['page'])) {

    $page = (int)$_GET['page'];

} else {

    $page = 0;
}

$total_latest_deaths = count($latest_deaths);
$row_latest_deaths = $total_latest_deaths / $config['deaths_per_page'];
$page_amount = ceil($total_latest_deaths / $config['deaths_per_page']);
$current = $config['deaths_per_page'] * $page;

for ($i = $current; $i < $current + $config['deaths_per_page']; $i++) {

    if (isset($latest_deaths[$i])) {
        
        echo '<h1>'.$latest_deaths[$i]['name'].'</h1><hr><p>Fame: '.$latest_deaths[$i]['totalFame'].'</p>';
    }
}

echo '<div class="pagination"><select name="deaths" onchange="location = this.options[this.selectedIndex].value;">';

for ($i = 0; $i < $page_amount; $i++) {

    if ($i == $page) {

        echo '<option value="latest_deaths.php?page='.$i.'" selected>Page '.$i.'</option>';

    } else {

        echo '<option value="latest_deaths.php?page='.$i.'">Page '.$i.'</option>';
    }
}

echo '</select></div> ';

include 'layout/footer.html';