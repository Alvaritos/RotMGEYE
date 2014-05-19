<?php
/**
 * index.php
 * Created at 5/19/14
 */

include 'engine/engine.php';
include 'layout/header.html';

$cache = new Cache('news', 60);

if ($cache->hasExpired()) {

    $news = $db->simpleQuery('SELECT * FROM news ORDER BY id DESC');
    $cache->setContent($news);

} else {

    $news = $cache->loadCache();
}

if (isset($_GET['page'])) {

    $page = (int)$_GET['page'];

} else {

    $page = 0;
}

$total_news = count($news);
$row_news = $total_news / $config['news_per_page'];
$page_amount = ceil($total_news / $config['news_per_page']);
$current = $config['news_per_page'] * $page;

for ($i = $current; $i < $current + $config['news_per_page']; $i++) {

    if (isset($news[$i])) {

        echo '<h1>'.$news[$i]['title'].'</h1><hr><p>'.$news[$i]['text'].'</p>';
    }
}

echo '<div class="pagination"><select name="newspage" onchange="location = this.options[this.selectedIndex].value;">';

for ($i = 0; $i < $page_amount; $i++) {

    if ($i == $page) {

        echo '<option value="index.php?page='.$i.'" selected>Page '.$i.'</option>';

    } else {

        echo '<option value="index.php?page='.$i.'">Page '.$i.'</option>';
    }
}

echo '</select></div> ';

include 'layout/footer.html';