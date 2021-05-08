<?php
    // Create the selects for the select form
    function createSelect($list, $table, $itemId, $itemName, $viewAllString, $global_id) {
?>
        <select class="form-control" name="<?=$table . "Id"?>" id="<?=$table . "-select"?>">
            <option value=""><?= $viewAllString ?></option>
            <?php
                if(!empty($list)) {
                    foreach($list as $item) {
                        $id = $item[$itemId];
                        $name = $item[$itemName];
            ?>
            <option value="<?= $id ?>"
            <?php
                if(!empty($global_id) && $global_id == $id) {
            ?>
                selected
            <?php
                }
            ?>
            ><?= $name ?></option>
            <?php
                    }
                }
            ?>
        </select>
<?php
    }
?>