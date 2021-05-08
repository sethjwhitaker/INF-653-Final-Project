<?php
    if(!empty($quotes)) {
?>
    <table class="table">
        <tr>
            <th>Quote</th>
            <th>Author</th>
            <th>Category</th>
        </tr>
<?php
        foreach($quotes as $quote) {
?>
        <tr>
            <td><?=$quote["quote"];?></td>
            <td><?=$quote["author"];?></td>
            <td><?=$quote["category"];?></td>
        </tr>
<?php } ?>
    </table>
<?php } else { ?>
    <h3>No quotes to display.</h3>
<?php } ?>
