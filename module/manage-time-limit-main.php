<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");
include "module/locker.php";

$PDO = dbc();
$floor_id = $_SESSION["floor_id"];
$floor_groups = get_groups($floor_id, false, false);

?>
<script>
    var floor_id = <?= $floor_id ?>;
</script>
<script src="lib/moment/moment.js"></script>
<link rel="stylesheet" href="lib/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<script src="lib/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<form method="post" class="" role="form">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>店家id</td>
            <td>店家名稱</td>
            <td>時限</td>
        </tr>
        </thead>
        <tbody class="group-list">
        <?php foreach ($floor_groups as $group) { ?>
            <tr data-uid="<?= $group["id"] ?>" class="group">
                <td class="group_id"><?= $group["id"] ?></td>
                <td class="group_name"><?= $group["name"] ?></td>
                <td class="time_limit">
                    <div class="input-daterange input-group date">
                        <input type="text" class="form-control"
                               value="<?= isset($group["time_limit"]) ? $group["time_limit"] : null ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </p>
    <div class="btn-group">
        <a href="control.php" class="btn btn-default">返回</a>
        <button class="btn btn-default submit" type="button">儲存</button>
    </div>
</form>
