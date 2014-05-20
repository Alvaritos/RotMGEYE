<?php
/**
 * index.php
 * Created at 5/19/14
 */

include 'engine/engine.php';
include 'layout/header.html';

echo '<h1>Latest deaths</h1><hr>';

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

$item_list = include 'engine/misc/renders.php';
$character_list = include 'engine/misc/characters.php';
$total_latest_deaths = count($latest_deaths);
$row_latest_deaths = $total_latest_deaths / $config['deaths_per_page'];
$page_amount = ceil($total_latest_deaths / $config['deaths_per_page']);
$current = $config['deaths_per_page'] * $page;

echo '<table class="table table-condensed"><thead>
<tr><td><b>#</b></td><td></td><td><b>Name</b></td><td><b>Died on</b></td><td><b>BF</b></td><td><b>TF</b></td><td><b>Equipment</b></td><td><b>Killed by</b></td></tr></thead><tbody>';

for ($i = $current; $i < $current + $config['deaths_per_page']; $i++) {

    if (isset($latest_deaths[$i])) {

        $value = $i + 1;
        //$current_char = $character_list[$latest_deaths[$i]['charType']];

        echo '<tr><td>'.$value.'</td>
        <td>
        <span id="i0'.$value.'3WF47B" class="character" style="" data-class="'.$latest_deaths[$i]['charType'].'" data-skin="0" data-dye1="'.$latest_deaths[$i]['tex1'].'" data-dye2="'.$latest_deaths[$i]['tex2'].'" data-accessory-dye-id="0" data-clothing-dye-id="0" data-original-title="" title=""></span>
        </td>
        <td>'.$latest_deaths[$i]['name'].'</td><td>'.$latest_deaths[$i]['time'].'</td><td>'.$latest_deaths[$i]['fame'].'</td><td>'.$latest_deaths[$i]['totalFame'].'</td><td>';

        foreach (explode(',', $latest_deaths[$i]['items']) as $items) {

            if (trim($items) != -1 && isset($item_list[trim($items)][3])) {

                $image = $item_list[trim($items)];

                echo '<span class="item" data-container="body" data-toggle="popover" data-placement="bottom" data-content="'.$image[0].'." style="background-position: -'.$image[3].'px '.$image[4].'px;"></span>';
            }
        }

        echo '</td><td>'.$latest_deaths[$i]['killer'].'</td></tr>';

    }
}


echo '</tbody></table><div class="pagination"><select name="deaths" onchange="location = this.options[this.selectedIndex].value;">';

for ($i = 0; $i < $page_amount; $i++) {

    if ($i == $page) {

        echo '<option value="latest_deaths.php?page='.$i.'" selected>Page '.$i.'</option>';

    } else {

        echo '<option value="latest_deaths.php?page='.$i.'">Page '.$i.'</option>';
    }
}

echo '</select></div> ';

include 'layout/footer.html';