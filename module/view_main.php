<?php
require_once "dbc.php";
require_once "settings.php";
include "module/locker.php";

$user_id = $_SESSION["uid"];
$purse = get_purse($user_id);
?>

<script>
    //Param for low-purse-lock.js
    var amount = <?= $purse["amount"] ?>;
    var purse_min_allow = <?= $purse_min_allow ?>;
    var user_id = '<?= $user_id ?>';
    var floor_id = '<?= $_SESSION["floor_id"] ?>';
</script>
<div class="col-md-9 menus">
    <h2>菜單</h2>
    <p class="hidden">
        <select class="floors form-control"></select>
    </p>
    <div class="groups"></div>
</div>
<div class="col-md-3 orders">
    <div class="orders-wrap">
        <div class="orders-inner">
        </div>
        <p class="price-showoff">
            共<span class="price"></span>元
        </p>
        <button type="button" class="btn btn-default submit"></button>
    </div>
</div>
<script src="lib/moment/moment.js"></script>
<script src="low-purse-lock.js"></script>
<?php if ($LOCKER == false) { ?>
    <script src="time-limit-lock.js"></script>
<?php } ?>
<img src="images/limit-icon.jpg" class="limit-icon" style="width: 50px; height: 50px; float:right;" hidden>