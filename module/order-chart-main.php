<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();
$user_id = $_SESSION["uid"];

?>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-datepicker.css">
<script src="lib/bootstrap/js/bootstrap-datepicker.min.js"></script>
<form method="post" class="" role="form">
    <div class="form-group form-inline">
        <div class="input-group input-daterange">
            <input type="text" class="form-control datepicker" placeholder="請輸入開始日期" id="startDate" readonly>
            <div class="input-group-addon">to</div>
            <input type="text" class="form-control datepicker" placeholder="請輸入結束日期" id="endDate" readonly>
        </div>
        <input type="button" class="btn btn-default submit" value="查詢">
    </div>

    <table id="searchResult" class="group table text-left sortable table-striped table-hover">
        <thead>
        <tr>
            <th>id</th>
            <th>使用者</th>
            <th>cnt</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="btn-group">
        <a href="view.php" class="btn btn-default">返回</a>
    </div>

</form>