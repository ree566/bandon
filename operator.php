<?php
$PERMISSION = 1;
include "module/session.php";
include "module/locker.php";

$json = array();

if(isset($_POST["command"])){
	if(isset($_POST["data"])){
		@$data = json_decode($_POST["data"], true);
		if($data){
			$json = $data;
		}
	}
	
	require_once "module/dbc.php";
	$MYSQLI = dbc();

	require_once "module/operator_func.php";
	// todat hot
	if($_POST["command"] == "get-today-hot"){
		$json["items"] = get_items_hot($json["count"]);
	}
	
	// view page
	if($_POST["command"] == "get-floors"){
		$json["floors"] = get_floors(true);
	}
	
	if($_POST["command"] == "get-floor"){
		$json["floor"] = get_floor($_SESSION["floor_id"], true);
	}

	if($_POST["command"] == "get-user"){
		$json["user"] = get_user($_SESSION["uid"]);
	}
	
	if($_POST["command"] == "set-orders"){
		$json = set_orders($json);
	}
	
	// account page
	if($_POST["command"] == "set-user"){
		$json = set_user($json);
	}
	
	if($_SESSION["permission"] >= 2){
		// manage groups page
		if($_POST["command"] == "get-groups"){
			$json["groups"] = get_groups(null, false);
		}

		if($_POST["command"] == "get-group"){
			$json["group"] = get_group($json["group_id"], true);
		}
		
		if($_POST["command"] == "set-group"){
			$json = set_group($json);
		}
		
		if($_POST["command"] == "set-detail"){
			$json = set_detail($json);
		}
		
		// select group page
		if($_POST["command"] == "set-floor-group"){
			$json = set_floor($json);
		}
		
		// manage users page
		if($_POST["command"] == "get-users"){
			if($_SESSION["permission"] >= 3){
				$json["users"] = get_users();
			}else{
				$json["users"] = get_users($_SESSION["floor_id"]);
			}
		}

		if($_POST["command"] == "set-users"){
			$json = set_users($json);
		}
		
		// control page
		if($_POST["command"] == "get-orders"){
			$json["orders"] = get_orders(null, $_SESSION["floor_id"]);
		}
	}
	
	if($_SESSION["permission"] >= 3){
		// manage floor page
		if($_POST["command"] == "get-floors-only"){
			$json["floors"] = get_floors(false);
		}

		if($_POST["command"] == "set-floors"){
			$json = set_floors($json);
		}
	}
}

$json = set_state($json);
$json = json_encode($json);
echo $json;
/*
if($_SESSION["permission"] >= 1){
	
	if($_POST["command"] == "get-group" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		
		$group_id = (int)$json->group->id;
		
		// get group info
		$re = $mysqli->query("SELECT * FROM groups WHERE id = $group_id");
		if($re->num_rows){
			$row = $re->fetch_assoc();
			$json->group->name = $row["name"];
		}else{
			die;
		}
		
		// get items
		$re = $mysqli->query("SELECT * FROM items WHERE group_id = $group_id");
		$json->group->items = array();
		while($re && $row = $re->fetch_assoc()){
			$json->group->items[] = $row;
			
			$item_id = $row["id"];
			
			// get kinds
			$re2 = $mysqli->query("SELECT * FROM kinds WHERE item_id = $item_id");
			$row["kinds"] = array();
			while($re2 && $row2 = $re2->fetch_assoc()){
				$row["kinds"][] = $row2;
			}
		}

		// get details
		$json->group->details = array();
		$re = $mysqli->query("SELECT * FROM details WHERE group_id = $group_id");
		while($re && $row = $re->fetch_assoc()){
			$detail_id = $row["id"];
			
			// get options
			$row["options"] = array();
			$re2 = $mysqli->query("SELECT * FROM options WHERE detail_id = $detail_id");
			while($re2 && $row2 = $re2->fetch_assoc()){
				$row["options"][] = $row2;
			}
			
			$json->group->details[] = $row;
		}
		
		// get item_detail
		$json->group->item_detail = array();
		$re = $mysqli->query("SELECT item_detail.* FROM item_detail, items WHERE item_detail.item_id = items.id && items.group_id = $group_id");
		while($re && $r = $re->fetch_assoc()){
			$item_id = $r["item_id"];
			$detail_id = $r["detail_id"];
			
			$json->group->item_detail["$item_id,$detail_id"] = $r;
		}
		
		$json->state = $mysqli->error ? $mysqli->error : "success";
		
		echo json_encode($json);
		
		$mysqli->close();
	}

	if($_POST["command"] == "get-detail" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		
		$group_id = (int)$json->group->id;

		$json->group->details = array();
		$re = $mysqli->query("SELECT * FROM details WHERE group_id = $group_id");
		while($re && $row = $re->fetch_assoc()){
			$json->group->details[] = $row;
			
			$detail_id = $row["id"];
			
			$row["options"] = array();
			$re2 = $mysqli->query("SELECT * FROM options WHERE detail_id = $detail_id");
			while($re2 && $row2 = $re2->fetch_assoc()){
				$row["options"][] = $row2;
			}
		}
		
		$json->state = $mysqli->error ? $mysqli->error : "success";
		
		echo json_encode($json);
		
		$mysqli->close();
	}

	if($_POST["command"] == "order"){
		$json = json_decode($_POST["data"]);
		
		if(!$json){
			echo "error";
			die;
		}
		
		if($LOCKER){
			echo "關閉訂購中！";
			die;
		}
		
		require_once "module/dbc.php";
		$mysqli = dbc();
		
		$uid = $_SESSION["uid"];
		$mysqli->query("DELETE FROM orders WHERE user_id = '$uid'");
		
		$check_item = array();
		$check_kind = array();
		$check_option = array();
		
		$re = $mysqli->query("SELECT id FROM items");
		while($re && $row = $re->fetch_assoc()){
			$check_item[] = $row["id"];
		}
		
		$re = $mysqli->query("SELECT id FROM kinds");
		while($re && $row = $re->fetch_assoc()){
			$check_kind[] = $row["id"];
		}

		$re = $mysqli->query("SELECT id FROM options");
		while($re && $row = $re->fetch_assoc()){
			$check_option[] = $row["id"];
		}

		foreach($json->orderList as $order){
			$kind_id = (int)$order->kind_id;
			$number = (int)$order->number;
			$item_id = (int)$order->item_id;
			$option_ids = explode(",", $mysqli->escape_string($order->option_ids));
			for($i = 0; $i < count($option_ids); $i++){
				if($option_ids[$i] == "0" || !in_array($option_ids[$i], $check_option)){
					unset($option_ids[$i]);
				}
			}
			$option_ids = implode(",", $option_ids);
			$option_ids = $mysqli->escape_string($option_ids);
			
			if(in_array($item_id, $check_item) && in_array($kind_id, $check_kind)){
				$mysqli->query("
					INSERT INTO orders (user_id, kind_id, item_id, option_ids, number) VALUES ('$uid', $kind_id, $item_id, '$option_ids', $number)");
			}
		}
		
		echo "success" . $mysqli->error;
		$mysqli->close();
		die;
	}

	if($_POST["command"] == "account"){

		if(!isset($_POST["json"])){
			echo "error";
			die;
		}
		
		$json = json_decode($_POST["json"]);

		require_once "module/dbc.php";
		$mysqli = dbc();
		
		$old_hash = pw_hash($json->oldPass);
		$new_hash = pw_hash($json->newPass);
		$uid = $_SESSION["uid"];
		
		$re = $mysqli->query("SELECT * FROM users WHERE id='$uid' AND pass_hash='$old_hash'");
		if(!$re->num_rows){
			echo "wrong_old_pass";
			die;
		}else if($mysqli->query("UPDATE users SET pass_hash='$new_hash' WHERE id='$uid'")){
			echo "success";
			die;
		}else{
			echo "error";
			die;
		}

	}

}

// admin
if($_SESSION["permission"] >= 2){
	if($_POST["command"] == "menu" && isset($_POST["data"])){
		// save to  db
		$json = $_POST["data"];
		$json = json_decode($json);
		
		require_once "module/dbc.php";
		$mysqli = dbc();
		
		// performance issue?
		// http://stackoverflow.com/questions/17762361/truncate-table-taking-very-long-time-is-it-normal
		// http://stackoverflow.com/questions/392024/why-delete-from-table-takes-a-long-time-when-truncate-table-takes-0-time
		
		// $mysqli->query("TRUNCATE TABLE groups");
		// $mysqli->query("TRUNCATE TABLE items");
		
		$mysqli->query("DELETE FROM groups");
		$mysqli->query("DELETE FROM items");
		$mysqli->query("DELETE FROM kinds");
		
		$group_ids = array();
		$item_ids = array();
		foreach($json->groupList as $group){
			$gid = (int)$group->id;
			$gn = $mysqli->escape_string($group->name);
			$hidden = (int)$group->hidden;
			
			if($gid){
				$mysqli->query("INSERT INTO groups (id, name, hidden) VALUES ($gid, '$gn', $hidden)");
				$group_ids[] = $gid;
			}
		}
		
		foreach($json->itemList as $item){
			$iid = (int)$item->id;
			$gid = (int)$item->group_id;
			$name = $mysqli->escape_string($item->name);
			
			if($iid && in_array($gid, $group_ids)){
				$mysqli->query("INSERT INTO items (id, group_id, name) VALUES ($iid, $gid, '$name')");
				$item_ids[] = $iid;
			}
		}
		
		foreach($json->kindList as $extra){
			$eid = (int)$extra->id;
			$name = $mysqli->escape_string($extra->name);
			$price = (int)$extra->price;
			$item_id = (int)$extra->item_id;
			
			if(in_array($item_id, $item_ids)){
				$mysqli->query("INSERT INTO kinds (id, name, price, item_id) VALUES ($eid, '$name', $price, $item_id)");
			}
		}
		
		$mysqli->query("DELETE item_detail FROM item_detail LEFT JOIN items ON item_detail.item_id = items.id WHERE items.id IS NULL");
		$mysqli->query("DELETE orders FROM orders LEFT JOIN items ON orders.item_id = items.id WHERE items.id IS NULL");
		$mysqli->query("DELETE orders FROM orders LEFT JOIN kinds ON orders.kind_id = kinds.id WHERE kinds.id IS NULL");
		
		echo "success".$mysqli->error;
		$mysqli->close();
		die;
	}
	
	if($_POST["command"] == "extra" && isset($_POST["data"])){
		// save to  db
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		
		// performance issue?
		// http://stackoverflow.com/questions/17762361/truncate-table-taking-very-long-time-is-it-normal
		// http://stackoverflow.com/questions/392024/why-delete-from-table-takes-a-long-time-when-truncate-table-takes-0-time
		
		// $mysqli->query("TRUNCATE TABLE groups");
		// $mysqli->query("TRUNCATE TABLE items");
		
		$mysqli->query("DELETE FROM details");
		$mysqli->query("DELETE FROM options");
		$mysqli->query("DELETE FROM item_detail");
		
		$detail_ids = array();
		foreach($json->detailList as $group){
			$gid = (int)$group->id;
			$gn = $mysqli->escape_string($group->name);
			$price = (int)$group->price;
			
			$mysqli->query("INSERT INTO details (id, name, price) VALUES ($gid, '$gn', $price)");
			$detail_ids[] = $gid;
		}
		
		$check_option = array();
		foreach($json->optionList as $item){
			$id = (int)$item->id;
			$detail_id = (int)$item->detail_id;
			$name = $mysqli->escape_string($item->name);
			
			$mysqli->query("INSERT INTO options (id, detail_id, name) VALUES ($id, $detail_id, '$name')");
			$check_option[] = $id;
		}
		
		$item_ids = array();
		$re = $mysqli->query("SELECT id FROM items");
		while($re && $row = $re->fetch_assoc()){
			$item_ids[] = $row["id"];
		}
		
		foreach($json->itemDetailList as $extra){
			$item_id = (int)$extra->item_id;
			$detail_id = (int)$extra->detail_id;
			
			if(in_array($item_id, $item_ids) && in_array($detail_id, $detail_ids)){
				$mysqli->query("INSERT INTO item_detail (item_id, detail_id) VALUES ($item_id, $detail_id)");
			}
		}
		
		// clean up orders.... performance issue?
		// ensure the user selected option is in option list AND that option's detail is belong the item (in item_detail)
		// maybe we should change array structure in mysql :q (Ex. |A|B|C|, "A"B"C"... so we could search with "like '%|A|%'")
		$re = $mysqli->query("SELECT * FROM orders");
		$orders = array();
		while($re && $row = $re->fetch_assoc()){
			$order_id = $row["id"];
			$options = explode(",", $row["option_ids"]);
			$alter = false;
			foreach($options as $i => $oid){
				if(!in_array($oid, $check_option)){
					unset($options[$i]);
					$alter = true;
					continue;
				}
				// echo "$oid is in option";
				$did = $json->optionList->{$oid}->detail_id;
				$iid = $row["item_id"];
				if(!isset($json->itemDetailList->{"$iid,$did"})){
					unset($options[$i]);
					$alter = true;
					continue;
				}
				// echo "$did is in $iid,$did";
			}
			$user_id = $row["user_id"];
			$item_id = (int)$row["item_id"];
			$kind_id = (int)$row["kind_id"];
			$number = (int)$row["number"];
			$option_ids = $mysqli->escape_string(implode(",", $options));
			
			$id = "$user_id-$item_id-$kind_id-$option_ids";
			if(isset($orders[$id])){
				$orders[$id]["number"] += $number;
			}else{
				$orders[$id] = array(
					"user_id" => $user_id,
					"item_id" => $item_id,
					"kind_id" => $kind_id,
					"number" => $number,
					"option_ids" => $option_ids
				);
			}
		}
		
		$mysqli->query("DELETE FROM orders");
		foreach($orders as $order){
			$mysqli->query("INSERT INTO orders (user_id, item_id, kind_id, number, option_ids) VALUES ('{$order["user_id"]}', {$order["item_id"]}, {$order["kind_id"]}, {$order["number"]}, '{$order["option_ids"]}')");
		}
		
		$mysqli->close();
		
		echo "success";
		die;
	}

	if($_POST["command"] == "add-user" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		foreach($json->userList as $user){
			$id = $mysqli->escape_string($user->id);
			$name = $mysqli->escape_string($user->name);
			$pass_hash = pw_hash($user->id);
			$permission = (int)$user->permission ? (int)$user->permission : 1;
			$permission = $permission > $_SESSION["permission"] ? $_SESSION["permission"] : $permission;
		
			$mysqli->query("
				INSERT INTO users (id, pass_hash, name, permission) VALUES ('$id', '$pass_hash', '$name', $permission)
					ON DUPLICATE KEY UPDATE pass_hash='$pass_hash', name='$name', permission=$permission
			");
		}
		echo $mysqli->error ? $mysqli->error : "success";
		
		$mysqli->close();
	}
		
	if($_POST["command"] == "delete-user" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		foreach($json->userList as $user){
			$id = $mysqli->escape_string($user->id);
			$permission = $_SESSION["permission"];
		
			$mysqli->query("DELETE FROM users WHERE id = '$id' && permission <= $permission");
		}
		echo $mysqli->error ? $mysqli->error : "success";
		
		$mysqli->close();
	}

	if($_POST["command"] == "floor" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		foreach($json->floors as $i){
			$id = (int)$i->id;
			$name = $mysqli->escape_string($i->name);
			$delete = (int)$i->delete;
			
			if($delete && $id > 1){
				$mysqli->query("DELETE FROM floors WHERE id = $id");
			}else{
				$mysqli->query(
					"INSERT INTO floors (id, name) VALUES ($id, '$name')
						ON DUPLICATE KEY UPDATE name='$name'"
				);
			}
		}
		echo $mysqli->error ? $mysqli->error : "success";
		
		$mysqli->close();
	}
	
	if($_POST["command"] == "add-group" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		
		$id = (int)$json->group->id;
		$name = $mysqli->escape_string($json->group->name);
		
		$deleteall = false;
		if(isset($json->group->delete) && $json->group->delete){
			$mysqli->query("DELETE FROM groups WHERE id=$id");
			$deletall = true;
		}else{
			$mysqli->query(
				"INSERT INTO groups (id, name) VALUES ($id, '$name')
					ON DUPLICATE KEY UPDATE name='$name'"
			);
		}
		
		if(!$id){
			$id = $mysqli->insert_id;
		}

		$json->group->id = $id;
		
		$group_id = $id;
		if(isset($json->group->items)){
			foreach($json->group->items as $item){
				$id = $item->id;
				$name = $item->name;
				
				$deleteitem = false;
				$mysqli->query(
					"INSERT INTO items (id, name, group_id) VALUES ($id, '$name', $group_id)
						ON DUPLICATE KEY UPDATE name='$name'"
				);
				
				if(!$id){
					$id = $mysqli->insert_id;
				}
				
				if($item->delete || $deleteall){
					$mysqli->query("DELETE FROM items WHERE id=$id");
					$deleteitem = true;
				}

				$item->group_id = $group_id;
				$item->id = $id;
				
				$item_id = $id;
				
				$delete_count = 0;
				foreach($item->kinds as $key => $kind){
					$id = $kind->id;
					$name = $kind->name;
					$price = $kind->price;
					
					$mysqli->query(
						"INSERT INTO kinds (id, name, price, item_id) VALUES ($id, '$name', $price, $item_id)
							ON DUPLICATE KEY UPDATE name='$name', price=$price"
					);
					
					if(!$id){
						$id = $mysqli->insert_id;
					}

					if($kind->delete || $deleteitem){
						if($deleteitem || $delete_count < count($item->kinds) - 1){
							$mysqli->query("DELETE FROM kinds WHERE id=$id");
							$delete_count++;
						}
					}
					
					$kind->item_id = $item_id;
					$kind->id = $id;
				}
			}
		}
		
		// add detail
		if(isset($json->group->details)){
			foreach($json->group->details as $detail){
				$id = (int)$detail->id;
				$name = $mysqli->escape_string($detail->name);
				$price = (int)$detail->price;
				
				if($detail->delete){
					$mysqli->query("DELETE FROM details WHERE id = $id");
				}else{
					$mysqli->query(
						"INSERT INTO details (id, name, price, group_id) VALUES ($id, '$name', $price, $group_id)
							ON DUPLICATE KEY UPDATE name='$name', price=$price"
					);
				}
				
				// save option
				$detail_id = $id;
				if(isset($detail->options)){
					foreach($detail->options as $option){
						$id = (int)$option->id;
						$name = $mysqli->escape_string($option->name);
						
						if(isset($option->delete) && $option->delete){
							$mysqli->query("DELETE FROM options WHERE id = $id");
						}else{
							$mysqli->query(
								"INSERT INTO options (id, name, detail_id) VALUES ($id, '$name', $detail_id)
									ON DUPLICATE KEY UPDATE name='$name'"
							);
						}
					}
				}
			}
		}
		
		// save item_detail
		if(isset($json->group->item_detail)){
			$mysqli->query("DELETE item_detail FROM item_detail, items WHERE item_detail.item_id = items.id && items.group_id = $group_id");
			foreach($json->group->item_detail as $item_detail){
				$item_id = $item_detail->item_id;
				$detail_id = $item_detail->detail_id;
				
				$mysqli->query("INSERT INTO item_detail (item_id, detail_id) VALUES ($item_id, $detail_id)");
			}
		}
		
		$json->state = $mysqli->error ? $mysqli->error : "success";
		
		$json = json_encode($json);
		
		echo $json;
		
		$mysqli->close();
	}
	
	if($_POST["command"] == "add-detail" && isset($_POST["data"])){
		$json = $_POST["data"];
		$json = json_decode($json);
		
		$mysqli = dbc();
		
		$id = (int)$json->detail->id;
		$name = $mysqli->escape_string($json->detail->name);
		$group_id = (int)$json->detail->group_id;
		$price = (int)$json->detail->price;
		
		$deleteall = false;
		if(isset($json->detail->delete) && $json->detail->delete){
			$mysqli->query("DELETE FROM details WHERE id=$id");
			$deletall = true;
		}else{
			$mysqli->query(
				"INSERT INTO details (id, group_id, name, price) VALUES ($id, $group_id, '$name', $price)
					ON DUPLICATE KEY UPDATE name='$name', price=$price"
			);
		}
		
		if(!$id){
			$id = $mysqli->insert_id;
		}

		$json->detail->id = $id;
		
		$detail_id = $id;
		if(isset($json->detail->options)){
			foreach($json->detail->options as $option){
				$id = $option->id;
				$name = $option->name;
				
				$deleteitem = false;
				$mysqli->query(
					"INSERT INTO options (id, name, detail_id) VALUES ($id, '$name', $detail_id)
						ON DUPLICATE KEY UPDATE name='$name'"
				);
				
				if(!$id){
					$id = $mysqli->insert_id;
				}
				
				if($option->delete || $deleteall){
					$mysqli->query("DELETE FROM options WHERE id=$id");
					$deleteitem = true;
				}

				$option->detail_id = $detail_id;
				$option->id = $id;
			}
		}
		
		$json->state = $mysqli->error ? $mysqli->error : "success";
		
		$json = json_encode($json);
		
		echo $json;
		
		$mysqli->close();
	}
	
	if($_POST["command"] == "get-groups"){
		$json = [];
		
		$mysqli = dbc();
		
		// get groups
		$re = $mysqli->query("SELECT * FROM groups");
		
		$json["groups"] = [];
		while($re && $row = $re->fetch_assoc()){
			$group = $row;
			
			$json["groups"][] = $group;
		}
		
		$json["state"] = $mysqli->error ? $mysqli->error : "success";
		
		echo json_encode($json);
		
		$mysqli->close();
	}

	if($_POST["command"] == "get-floor"){
		$json = [];
		
		$mysqli = dbc();
		$uid = $_SESSION["uid"];
		
		$re = $mysqli->query("SELECT floors.* FROM floors, users WHERE users.id = '$uid' && users.floor_id = floors.id");
		
		if($re->num_rows){
			$json["floor"] = $re->fetch_assoc();
			$floor_id = $json["floor"]["id"];
			
			// get floor groups
			$json["floor"]["groups"] = [];
			$r2 = $mysqli->query("SELECT groups.* FROM groups, floor_group WHERE floor_group.floor_id = $floor_id && floor_group.group_id = groups.id");
			while($r2 && $ro2 = $r2->fetch_assoc()){
				$json["floor"]["groups"][] = $ro2;
			}
		}
		
		$json["state"] = $mysqli->error ? $mysqli->error : "success";
		
		echo json_encode($json);
		
		$mysqli->close();
	}

	if($_POST["command"] == "set-floor-group" && isset($_POST["data"])){
		$json = json_decode($_POST["data"]);
		
		$mysqli = dbc();
		$uid = $_SESSION["uid"];
		$floor_id = (int)$json->floor->id;
		
		$mysqli->query("DELETE FROM floor_group WHERE floor_id = $floor_id");
		
		foreach($json->floor->groups as $group){
			$group_id = (int)$group->id;
			
			$mysqli->query("INSERT INTO floor_group (floor_id, group_id) VALUES ($floor_id, $group_id)");
		}

		$json->state = $mysqli->error ? $mysqli->error : "success";
		
		echo json_encode($json);
		
		$mysqli->close();
	}
}
*/