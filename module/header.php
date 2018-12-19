<h1 id="title">
    <?= $TITLE ?>
    <small class="today-hot">
        <?php if (isset($PERMISSION) && $PERMISSION < 2 && $PAGE == "view") { ?>
            <br/>
            <span class="today-hot-head">
			今日熱門︰
		</span>
            <ul class="today-hot-list">

            </ul>
            <script src="today-hot.js"></script>
        <?php } else { ?>

            <?php
            require_once("module/dbc.php");
            require_once("module/operator_func.php");

            $floor_id = $_SESSION["floor_id"];
            $floor = get_floor($floor_id);
            $floor_name = array_key_exists("name", $floor) ? $floor["name"] : 'Error!!';

            echo $floor_name;
            ?>

        <?php } ?>
    </small>
</h1>
