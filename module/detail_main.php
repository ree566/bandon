<div id="order-detail" class="container">
    <div class="panel panel-default sortable">
        <div class="panel-heading">所有訂單</div>
        <div class=" table-responsive">
            <table class="detail-list table table-bordered table-hover">
                <thead>
                <tr>
                    <th>樓層</th>
                    <th>工號</th>
                    <th>姓名</th>
                    <th>店家</th>
                    <th>項目</th>
                    <th>細項</th>
                    <th>價格</th>
                    <th>數量</th>
                    <th>訂購時間</th>
                </tr>
                </thead>
                <tbody class="order-list"></tbody>
            </table>
        </div>
    </div>


    <div class="panel panel-default sortable">
        <div class="panel-heading">每人支付統計</div>
        <table class="person-list table table-bordered table-hover">
            <thead>
            <tr>
                <th>樓層</th>
                <th>工號</th>
                <th>姓名</th>
                <th>支付</th>
            </tr>
            </thead>
            <tbody class="price-list"></tbody>
        </table>
    </div>


    <div class="btn-group">
        <a href="control.php" class="btn btn-default">返回</a> <a
                href="javascript: window.print()" class="btn btn-default print">列印</a>
    </div>
</div>
<script src="detail_css_mod.js"></script>
