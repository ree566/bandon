

<form method="post" class="form-horizontal" role="form">
	<h2>細項</h2>
	<div class="clearfix">
		<div class="detail-list"></div>
		<input type="button" value="新增細項"
			class="pull-right add-detail btn btn-default" />
	</div>
	<div class="clearfix"></div>
	<h2>項目與細項關聯</h2>
	<div class="table-responsive">
		<table class="item-detail"></table>
	</div>
	<p class="status-info text-danger">注意！儲存時會重建訂購資料。還未清除訂購資料前，修改細項可能會很耗時！</p>
	<div class="btn-group">
		<a href="control.php" class="btn btn-default">返回</a> <input
			type="submit" value="儲存" class="btn btn-default" /> <a
			href="menu.php" class="btn btn-default">修改菜單</a>
	</div>
</form>