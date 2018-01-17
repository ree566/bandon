<h1 id="title">
	<?=$TITLE?>
	<small class="today-hot">
	<?php if(isset($PERMISSION) && $PERMISSION < 2 && $PAGE != "account"){ ?>
		<br />
		<span class="today-hot-head">
			今日熱門︰
		</span>
		<ul class="today-hot-list">

		</ul>
		<script src="today-hot.js"></script>
	<?php }else{ ?>
	
	<?php
		require_once("module/dbc.php");

		$mysqli = dbc();
		$floor_id = $_SESSION["floor_id"];
		$floor_name = null;
		if($re = $mysqli->query("SELECT * FROM floors WHERE floors.id = $floor_id")){
			$floor_name = $re->fetch_assoc()["name"];
			$re->close();
		}
		$mysqli->close();
		echo $floor_name;
	?>
		
	<?php } ?>
	</small>
</h1>
