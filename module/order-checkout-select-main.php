<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");
include "module/locker.php";

$PDO = dbc();
$floor_id = $_SESSION["floor_id"];
$groups = get_groups($floor_id, null, null);

?>
    <script src="lib/jquery-redirect/jquery.redirect.js"></script>
<?php if ($LOCKER == false) { ?>
    <div class='alert alert-danger'>請結束訂購後再進行資料結算</div>
    <div class="btn-group">
        <a href="control.php" class="btn btn-default">返回</a>
    </div>
<?php } else { ?>
    <?php if (empty($groups)) { ?>
        <h3>無可結算店家</h3>
        <a href="control.php" class="btn btn-default">返回</a>
    <?php } else { ?>
        <form method="post" class="" role="form">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>店家id</th>
                    <th>店家名稱</th>
                    <th>店家時限</th>
                    <th>
                        <input type="checkbox" id="check-all" />
                        <label for="check-all">全選</label>
                    </th>
                </tr>
                </thead>
                <tbody class="group-list">
                <?php foreach ($groups as $group) { ?>
                    <tr data-uid="<?= $group["id"] ?>" class="group">
                        <td class="group_id"><?= $group["id"] ?></td>
                        <td class="name"><?= $group["name"] ?></td>
                        <td class="time_limit"><?= $group["time_limit"] == 0 ? "無時限" : $group["time_limit"] ?></td>
                        <td class="remark"><input type="checkbox" class="group-check "
                                                  value="<?= $group["id"] ?>"/></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            </p>
            <div class="btn-group">
                <button class="btn btn-default submit" type="button">下一步</button>
            </div>
        </form>
    <?php } ?>
<?php } ?>