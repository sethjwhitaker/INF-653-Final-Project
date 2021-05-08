<?php
    require("view/select.php");
?>
<form class="form-group" action="." method="GET">
    <input type="hidden" name="action" value="home">
    <?php
        createSelect($authors, "author", "id", "author", "View All Authors", $authorId);
        createSelect($categories, "category", "id", "category", "View All Categories", $categoryId);
    ?>
    <br>
    <button class="btn-primary" type="submit">Submit</button>
</form>