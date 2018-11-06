<form method="post" class="form-horizontal" role="form">
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#remove" role="tab" data-toggle="tab" class="tab-delete">刪除</a></li>
		<li><a href="#add" role="tab" data-toggle="tab" class="tab-add">匯入</a></li>
	</ul>
	
	<div class="tab-content text-left">
		<div class="tab-pane active fade in" id="remove">
			<p>你無法刪除權限比你高的人與自己。</p>
			<p>
			<table class="table sortable">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>樓層</th>
						<th>姓名</th>
						<th>權限</th>
					</tr>
				</thead>
				<tbody class="user-list">
				</tbody>
			</table>
			<div class="btn-group">
				<button class="btn btn-default delete-user">刪除勾選</button>
				<!-- <button class="btn btn-default upgrade-user">將勾選設為管理者</button> -->
			</div>
			</p>
		</div>
		<div class="tab-pane fade" id="add">
			<p>輸入資料以加入。格式為每行一筆<code>帳號 姓名 權限 樓層</code>（樓層可不填）。權限<code>1</code>為一般使用者，權限<code>2</code>為管理者，若無指定權限則預設為<code>1</code></p>
			<p>Example: <code>U-13579 王小明 1</code></p>
			<p>
				<textarea class="form-control add-user-list" rows="20"></textarea>
			</p>
			<button class="btn btn-default add-user" type="button">匯入</button>
		</div>
	</div>
	
	<div class="btn-group"><a href="control.php" class="btn btn-default">返回</a></div>
</form>