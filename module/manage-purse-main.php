<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");
include "module/locker.php";

$PDO = dbc();
$floor_id = $_SESSION["floor_id"];
$purses = get_purses($floor_id);

?>
<?php if ($LOCKER == false) { ?>
    <div class='alert alert-danger'>開放訂購中無法異動餘額</div>
<?php } else { ?>
    <form method="post" class="" role="form">
        <div class="panel panel-default">
            <div class="panel-heading">異動使用者餘額(備註為必填)</div>
            <table class="group table text-left sortable table-striped table-hover">
                <thead>
                <tr>
                    <td>purse_id</td>
                    <td>user_id</td>
                    <td>user_name</td>
                    <td>amount</td>
                    <td>異動值</td>
                    <td>備註</td>
                </tr>
                </thead>
                <tbody class="purse-list">
                <?php foreach ($purses as $purse) { ?>
                    <tr data-uid="<?= $purse["purse_id"] ?>" class="purse">
                        <td class="purse_id"><?= $purse["purse_id"] ?></td>
                        <td class="user_id"><?= $purse["user_id"] ?></td>
                        <td class="user_name"><?= $purse["user_name"] ?></td>
                        <td class="amount"><?= $purse["amount"] ?></td>
                        <td class="adjust"><input type="number" class="adjust_num form-control" value="0"></td>
                        <td class="remark"><input type="text" class="order-remark form-control" placeholder="輸入備註"/>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        </p>
        <div class="btn-group">
            <a href="control.php" class="btn btn-default">返回</a>
            <button class="btn btn-default submit" type="button">儲存</button>
        </div>
    </form>
<?php } ?>