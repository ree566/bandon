<?php
include "module/locker.php";
?>

<div class="lock-info hidden-print">
    <?php if ($LOCKER) { ?>
        <div class='alert alert-danger'>關閉訂購中</div>
    <?php } else { ?>
        <div class='alert alert-success'>開放訂購中</div>
    <?php } ?>
</div>

<div class="groups-detail">

</div>


<p class="system-status">
</p>

<div class="btn-group">
    <a href="manage-group.php" class="btn btn-default">管理菜單</a>
    <a href="select-group.php" class="btn btn-default">匯入菜單</a>
    <a href="manage-time-limit.php" class="btn btn-default">菜單限時</a>
    <a href="detail.php" class="btn btn-default">檢視詳細</a>
    <a href="order-checkout.php" class="btn btn-default">結算</a>
    <a href="javascript: window.print()" class="btn btn-default">列印</a>
</div>
