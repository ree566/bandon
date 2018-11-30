<?php
require_once("module/dbc.php");
require_once("module/operator_func.php");

$PDO = dbc();
$user_id = $_SESSION["uid"];

?>
<form method="post" class="" role="form">
    <div class="form-group form-inline">
        <input type="text" class="form-control" placeholder="請輸入工號" id="user_id">
        <input type="text" class="form-control" placeholder="請輸入名字" id="user_name">
        <input type="button" class="btn btn-default submit" value="查詢">
    </div>

    <table id="searchResult" class="table table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>使用者</th>
            <th>項目</th>
            <th>金額</th>
            <th>訂購日期</th>
            <th>異動人員</th>
            <th>異動日期</th>
            <th>備註</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="btn-group">
        <a href="view.php" class="btn btn-default">返回</a>
    </div>

</form>