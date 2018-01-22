<?php
require_once ("module/dbc.php");

$mysqli = dbc();
$re = $mysqli->query("SELECT * FROM floors");
$floors = array();
while ($re && $row = $re->fetch_assoc()) {
    $floors[$row["id"]] = $row;
}

?>

<form method="post" class="form-horizontal" role="form">
	<p class="text-danger">註︰一樓是預設樓層，無法刪除</p>
	<div>
		<table class="table">
			<thead>
				<tr>
					<td>刪除</td>
					<td>ID</td>
					<td>名稱</td>
					<td>開放訂購</td>
				</tr>
			</thead>
			<tbody class="floor-list">
			<?php foreach($floors as $floor) {?>
				<tr data-uid="<?=$floor["id"]?>" class="floor">
					<td><input type="checkbox" class="delete-check"></td>
					<td><?=$floor["id"]?></td>
					<td><input type="text" value="<?=$floor["name"]?>"
						class="floor-name form-control" placeholder="輸入名稱"></td>
					<td><input type="checkbox" class="floor-open"
						<?=(int)$floor["open"]?"checked":""?>></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<p class="text-right">
		<button class="btn btn-default add-floor" type="button">新增樓層</button>
	</p>
	<div class="btn-group">
		<a href="control.php" class="btn btn-default">返回</a>
		<button class="btn btn-default submit">儲存</button>
	</div>
</form>