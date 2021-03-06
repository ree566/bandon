<?php
function is_true($dict, $key){
	return isset($dict[$key]) && $dict[$key];
}

function last_id(){
	global $MYSQLI;
	return $MYSQLI->insert_id;
}

function escape($s){
	global $MYSQLI;
	return $MYSQLI->escape_string($s);
}

function Q($q){
	global $MYSQLI;
	$re = $MYSQLI->query($q);
	if($re === true){
		return $MYSQLI->affected_rows;
	}
	
	return $re;
}

function get_row($q){
	$row = null;
	
	if($re = Q($q)){
		$row = $re->fetch_assoc();
		$re->close();
	}
	
	return $row;
}

function get_rows($q){
	$rows = array();
	
	if($re = Q($q)){
		while($row = $re->fetch_assoc()){
			$rows[] = $row;
		}
		$re->close();
	}
	
	return $rows;
}

function set_state($json){
	global $MYSQLI;
	if(isset($json["state"])){
		return $json;
	}else if(!isset($MYSQLI)){
		$json["state"] = "error";
	}else if($MYSQLI->error){
		$json["state"] = "error";
		$json["error"] = $MYSQLI->error;
	}else{
		$json["state"] = "success";
	}
	return $json;
}

function get_floors($child = false, $group_id = null){
	if($group_id){
		$floors = get_rows("SELECT floors.* FROM floors, floor_group WHERE floor_group.group_id = $group_id && floor_group.floor_id = floors.id");
	}else{
		$floors = get_rows("SELECT * FROM floors");	
	}

	if($child){
		foreach($floors as &$floor){
			$floor["groups"] = get_groups($floor["id"], true);
		}
	}
	return $floors;
}

function get_groups($floor_id = null, $items = false, $orders = false){

	if($floor_id){
		$floor_id = (int)$floor_id;
		$groups = get_rows("SELECT groups.* FROM groups, floor_group WHERE floor_group.floor_id = $floor_id && floor_group.group_id = groups.id");
	}else{
		$groups = get_rows("SELECT * FROM groups");
	}
	
	if($items){
		foreach($groups as &$group){
			$group["items"] = get_items($group["id"]);
		}
	}
	
	if($orders){
		foreach($groups as &$group){
			$group["orders"] = get_orders($group["id"]);
		}
	}
	
	return $groups;
}

function get_items($group_id = null){

	if($group_id){
		$group_id = (int)$group_id;
		$items = get_rows("SELECT * FROM items WHERE items.group_id = $group_id");
	}else{
		$items = get_rows("SELECT * FROM items");
	}
	
	foreach($items as &$item){
		$item["kinds"] = get_kinds($item["id"]);
		$item["details"] = get_details($item["id"]);
	}
	
	return $items;
}

function get_kinds($item_id = null){

	if($item_id){
		$item_id = (int)$item_id;
		$kinds = get_rows("SELECT * FROM kinds WHERE kinds.item_id = $item_id");
	}else{
		$kinds = get_rows("SELECT * FROM kinds");
	}
	
	return $kinds;
}

function get_detail($detail_id){

	$detail_id = (int)$detail_id;
	return get_row("SELECT * FROM details WHERE details.id = $detail_id");
}

function get_details($item_id = null, $group_id = null){
	
	if($item_id){
		$item_id = (int)$item_id;
		$details = get_rows("SELECT details.* FROM details, item_detail WHERE item_detail.item_id = $item_id && item_detail.detail_id = details.id");
	}else if($group_id){
		$group_id = (int)$group_id;
		$details = get_rows("SELECT * FROM details WHERE details.group_id = $group_id");
	}else{
		$details = get_rows("SELECT * FROM details");
	}
	
	foreach($details as &$detail){
		$detail["options"] = get_options($detail["id"]);
	}
	
	return $details;
}

function get_options($detail_id = null){
	
	if($detail_id){
		$detail_id = (int)$detail_id;
		$options = get_rows("SELECT * FROM options WHERE options.detail_id = $detail_id");
	}else{
		$options = get_rows("SELECT * FROM options");
	}
	
	return $options;
}

function get_user($user_id = null, $orders=true, $floor=false){

	$user_id = escape($user_id);
	$user = get_row("SELECT * FROM users WHERE users.id = '$user_id'");
	if($orders){
		$user["orders"] = get_orders($user_id);
	}
	if($floor){
		$user["floor"] = get_floor($user["floor_id"]);
	}
	
	return $user;
}

function get_orders($user_id = null, $floor_id = null){
	
	if($user_id){
		$user_id = escape($user_id);
		$orders = get_rows("SELECT * FROM orders WHERE user_id = '$user_id'");
	}else if($floor_id){
		$floor_id = (int)$floor_id;
		$orders = get_rows("SELECT * FROM orders WHERE floor_id = $floor_id");
	}else{
		$orders = get_rows("SELECT * FROM orders");
	}
	
	foreach($orders as &$order){
		$order["item"] = get_item($order["item_id"], false);
		$order["group"] = get_group($order["item"]["group_id"], false);
		$order["kind"] = get_kind($order["kind_id"], false);
		$order["floor"] = get_floor($order["floor_id"], false);
		$order["user"] = get_user($order["user_id"], false, true);
	
		$options = array();
		if($order["option_ids"]){
			$option_ids = explode(",", $order["option_ids"]);
			foreach($option_ids as $option_id){
				$option = get_option($option_id);
				$option["detail"] = get_detail($option["detail_id"]);
				
				$options[] = $option;
			}
		}
		$order["options"] = $options;
	}
		
	return $orders;
}

function get_group($group_id, $child = false){
	$group_id = (int)$group_id;
	$group = get_row("SELECT * FROM groups WHERE groups.id = $group_id");
	if(!$group){
		return null;
	}
	
	if($child){
		$group["items"] = get_items($group_id);
		$group["details"] = get_details(null, $group_id);
		$group["item_detail"] = get_item_detail($group_id);
		$group["floors"] = get_floors(false, $group_id);
	}
		
	return $group;
}

function get_item($item_id, $child = false){
	$item_id = (int)$item_id;
	$item = get_row("SELECT * FROM items WHERE items.id = $item_id");

	if($child){
		$item["kinds"] = get_kinds($item["id"]);
	}

	return $item;
}

function get_kind($kind_id){
	$kind_id = (int)$kind_id;
	return get_row("SELECT * FROM kinds WHERE kinds.id = $kind_id");
}

function get_floor($floor_id, $groups = false, $users = false){
	$floor_id = (int)$floor_id;
	$floor = get_row("SELECT * FROM floors WHERE floors.id = $floor_id");

	if($groups){
		$floor["groups"] = get_groups($floor["id"]);
	}
	if($users){
		$floor["users"] = get_users($floor["id"]);
	}

	return $floor;
}

function get_option($option_id){
	$option_id = (int)$option_id;
	return get_row("SELECT * FROM options WHERE options.id = $option_id");
}

function get_item_detail($group_id){
	$group_id = (int)$group_id;
	return get_rows("SELECT item_detail.* FROM item_detail, details WHERE details.group_id = $group_id && details.id = item_detail.detail_id");
}

function get_users($floor_id = null){
	if($_SESSION["permission"] <= 2){
		$floor_id = $_SESSION["floor_id"];
	}
	
	if($floor_id){
		$floor_id = (int)$floor_id;
		$users = get_rows("SELECT * FROM users WHERE users.floor_id = $floor_id");
	}else{
		$users = get_rows("SELECT * FROM users");
	}
	
	foreach($users as &$user){
		$user["floor"] = get_floor($user["floor_id"]);
	}
	
	return $users;
}

function set_orders($json){
	$user_id = escape($_SESSION["uid"]);
	Q("DELETE orders FROM orders, floors WHERE orders.user_id = '$user_id' && orders.floor_id = floors.id && floors.open = 1");
	
	foreach($json["orders"] as $order){
		$floor_id = (int)$order["floor"]["id"];
		$item_id = (int)$order["item"]["id"];
		$kind_id = (int)$order["kind"]["id"];
		$number = (int)$order["number"];
		
		// check number
		if(!$number){
			continue;
		}
		
		// check floor open
		if(!get_row("SELECT * FROM floors WHERE floors.id = $floor_id && floors.open = 1")){
			continue;
		}
		
		// check floor-group-item
		if(!get_row("SELECT * FROM items, groups, floor_group WHERE items.id = $item_id && items.group_id = groups.id &&
				groups.id = floor_group.group_id && floor_group.floor_id = $floor_id")){
			continue;
		}
		
		// check item-kind
		if(!get_row("SELECT * FROM items, kinds WHERE items.id = $item_id && kinds.id = $kind_id && kinds.item_id = items.id")){
			continue;
		}
		
		$option_ids = array();
		foreach($order["options"] as $option){
			$option_id = (int)$option["id"];
			
			// check item-detail-option
			if(!Q("SELECT * FROM items, details, options, item_detail WHERE items.id = $item_id && options.id = $option_id &&
					options.detail_id = details.id && item_detail.item_id = items.id && item_detail.detail_id = details.id ")){
				continue;
			}
			$option_ids[] = $option["id"];
		}
		$option_ids = escape(implode(",", $option_ids));
		
		Q("INSERT INTO orders (user_id, floor_id, item_id, kind_id, option_ids, number) VALUES ('$user_id', $floor_id, $item_id, $kind_id, '$option_ids', $number)");
	}
	
	$json["orders"] = get_orders($user_id);
	return $json;
}

function set_user($json){
	$user_id = escape($_SESSION["uid"]);
	$old_pass = $json["old_pass"];
	$new_pass = $json["new_pass"];
	
	require_once("module/dbc.php");
	$old_hash = pw_hash($old_pass);
	$new_hash = pw_hash($new_pass);

	if(!preg_match("/^[a-zA-Z0-9]+$/", $new_pass)){
		$json["error"] = "新密碼格式不符";
		$json["state"] = "fail";
	}else if(!get_row("SELECT * FROM users WHERE id = '$user_id' && pass_hash = '$old_hash'")){
		$json["error"] = "舊密碼錯誤！";
		$json["state"] = "fail";
	}else{
		Q("UPDATE users SET pass_hash='$new_hash' WHERE id = '$user_id'");
	}
	
	return $json;
}

function set_group($json){
	$group_id = (int)$json["group"]["id"];
	$group_name = escape($json["group"]["name"]);
	@$group_tel = escape($json["group"]["tel"]);
	
	if($group_id && get_row("SELECT * FROM floor_group WHERE group_id = $group_id")){
		$json["state"] = "fail";
		$json["error"] = "此菜單使用中，無法編輯";
	}else{
		Q("INSERT INTO groups (id, name) VALUES ($group_id, '$group_name')
			ON DUPLICATE KEY UPDATE name='$group_name', tel='$group_tel'");
			
		if(!$group_id){
			$json["group"]["id"] = $group_id = last_id();
		}
		
		if(is_true($json["group"], "delete")){
			Q("DELETE FROM groups WHERE groups.id = $group_id");
		}else{
			if(isset($json["group"]["items"])){
				foreach($json["group"]["items"] as &$item){
					$item_id = (int)$item["id"];
					$item_name = escape($item["name"]);
					
					Q("INSERT INTO items (id, group_id, name) VALUES ($item_id, $group_id, '$item_name')
						ON DUPLICATE KEY UPDATE name='$item_name'");
						
					if(!$item_id){
						$item["id"] = $item_id = last_id();
					}
					
					if(is_true($item, "delete")){
						Q("DELETE FROM items WHERE items.id = $item_id");
					}else{
						foreach($item["kinds"] as &$kind){
							$kind_id = (int)$kind["id"];
							$kind_name = escape($kind["name"]);
							$kind_price = (int)$kind["price"];
							
							Q("INSERT INTO kinds (id, item_id, name, price) VALUES ($kind_id, $item_id, '$kind_name', $kind_price)
								ON DUPLICATE KEY UPDATE name='$kind_name', price=$kind_price");
							
							if(!$kind_id){
								$kind["id"] = $kind_id = last_id();
							}
							
							if(is_true($kind, "delete")){
								Q("DELETE FROM kinds WHERE kinds.id = $kind_id");
							}
						}

						// check item has at least 1 kind
						if(!get_row("SELECT * FROM kinds WHERE kinds.item_id = $item_id")){
							Q("INSERT INTO kinds (item_id) VALUES ($item_id)");
						}
					}
				}
			}
			
			if(isset($json["group"]["details"])){
				foreach($json["group"]["details"] as &$detail){
					$detail_id = (int)$detail["id"];
					$detail_name = escape($detail["name"]);
					$detail_price = (int)$detail["price"];
					
					Q("INSERT INTO details (id, group_id, name, price) VALUES ($detail_id, $group_id, '$detail_name', $detail_price)
						ON DUPLICATE KEY UPDATE name='$detail_name', price=$detail_price");
						
					if(!$detail_id){
						$detail["id"] = $detail_id = last_id();
					}
					
					if(is_true($detail, "delete")){
						Q("DELETE FROM details WHERE details.id = $detail_id");
					}else{
						foreach($detail["options"] as &$option){
							$option_id = (int)$option["id"];

							if(is_true($option, "delete")){
								Q("DELETE FROM options WHERE options.id = $option_id");
								continue;
							}

							$option_name = escape($option["name"]);
							Q("INSERT INTO options (id, detail_id, name) VALUES ($option_id, $detail_id, '$option_name')
								ON DUPLICATE KEY UPDATE name='$option_name'");
								
							if(!$option_id){
								$option["id"] = $option_id = last_id();
							}
						}
					}
				}
			}
			
			if(isset($json["group"]["item_detail"])){
				Q("DELETE item_detail FROM item_detail, details WHERE details.group_id = $group_id && details.id = item_detail.detail_id");
				foreach($json["group"]["item_detail"] as &$item_detail){
					$item_id = (int)$item_detail["item_id"];
					$detail_id = (int)$item_detail["detail_id"];
					
					// check item-group
					if(!Q("SELECT * FROM items WHERE items.id = $item_id && items.group_id = $group_id")){
						continue;
					}
					
					// check detail-group
					if(!Q("SELECT * FROM details WHERE details.id = $detail_id && details.group_id = $group_id")){
						continue;
					}
					
					Q("INSERT INTO item_detail (item_id, detail_id) VALUES ($item_id, $detail_id)");
				}
			}
		}
		
		$json["group"] = get_group($group_id, true);
	}
	
	return $json;
}

function set_users($json){
	require_once("module/dbc.php");

	foreach($json["users"] as $user){
		$user_id = escape($user["id"]);
		$my_floor_id = (int)$_SESSION["floor_id"];
		$my_permission = (int)$_SESSION["permission"];
		$my_id = escape($_SESSION["uid"]);
		
		if($user_id == $my_id){
			continue;
		}
		
		if(is_true($user, "delete")){
			if($_SESSION["permission"] < 3){
				Q("DELETE FROM users WHERE users.id = '$user_id' && users.floor_id = $my_floor_id && users.permission <= $my_permission");
			}else{
				Q("DELETE FROM users WHERE users.id = '$user_id' && users.permission <= $my_permission");
			}
		}else{
			$floor_id = (int)$user["floor_id"];
			$user_name = escape($user["name"]);
			$user_hash = pw_hash($user["id"]);
			$user_permission = (int)$user["permission"];
			
			if($user_permission > $_SESSION["permission"]){
				$user_permission = (int)$_SESSION["permission"];
			}
			
			if($_SESSION["permission"] < 3 || !$floor_id){
				$floor_id = (int)$_SESSION["floor_id"];
			}
			
			if($_SESSION["permission"] < 3){
				if(!Q("INSERT INTO users (id, name, pass_hash, permission, floor_id) VALUES ('$user_id', '$user_name', '$user_hash', $user_permission, $floor_id)")){
					Q("UPDATE users SET name='$user_name', permission=$user_permission WHERE floor_id = $floor_id && permission <= $my_permission && id = '$user_id'");
				}
			}else{
				if(!Q("INSERT INTO users (id, name, pass_hash, permission, floor_id) VALUES ('$user_id', '$user_name', '$user_hash', $user_permission, $floor_id)")){
					Q("UPDATE users SET name='$user_name', permission=$user_permission, floor_id=$floor_id WHERE permission <= $my_permission && id = '$user_id'");
				}
			}
		}
	}
	
	$json["users"] = get_users();
	
	return $json;
}

function set_floors($json){
	foreach($json["floors"] as &$floor){
		$floor_id = (int)$floor["id"];
		$floor_name = escape($floor["name"]);
		$floor_open = (int)$floor["open"];
		
		Q("INSERT INTO floors (id, name, open) VALUES ($floor_id, '$floor_name', $floor_open)
			ON DUPLICATE KEY UPDATE name='$floor_name', open=$floor_open");
			
		if(is_true($floor, "delete")){
			Q("DELETE FROM floors WHERE floors.id = $floor_id");
		}
	}
	
	$json["floors"] = get_floors(false);
	
	return $json;
}

function set_floor($json){
	$floor_id = (int)$json["floor"]["id"];
	
	if($_SESSION["permission"] <= 2){
		$floor_id = (int)$_SESSION["floor_id"];
	}
	
	if(get_row("SELECT * FROM floors WHERE floors.id = $floor_id && floors.open = 0")){
	
		Q("DELETE FROM floor_group WHERE floor_id = $floor_id");
		foreach($json["floor"]["groups"] as $group){
			$group_id = (int)$group["id"];
			
			Q("INSERT INTO floor_group (floor_id, group_id) VALUES ($floor_id, $group_id)");
		}
		
		$json["floor"] = get_floor($floor_id, true);
		
	}else{
		$json["state"] = "error";
		$json["error"] = "開放訂購中，無法匯入菜單";
	}
	
	return $json;
}

function set_detail($json){
	$detail_id = (int)$json["detail"]["id"];
	$name = escape($json["detail"]["name"]);
	$price = (int)$json["detail"]["price"];
	$group_id = (int)$json["detail"]["group_id"];
	
	if(!get_row("SELECT * FROM floor_group WHERE floor_group.group_id = $group_id")){
		Q("INSERT INTO details (id, name, price, group_id) VALUES ($detail_id, '$name', $price, $group_id)
			ON DUPLICATE KEY UPDATE name='$name', price=$price");
	}else{
		$json["state"] = "error";
		$json["error"] = "此菜單使用中，無法編輯";
	}
	
	if(!$detail_id){
		$json["detail"]["id"] = $detail_id = last_id();
	}
	
	return $json;
}

function get_items_hot($number){
	$number = (int)$number;
	$floor_id = (int)$_SESSION["floor_id"];
	return get_rows("SELECT items.name, orders.item_id, SUM(orders.number) AS count FROM orders, items WHERE items.id = orders.item_id && orders.floor_id = $floor_id GROUP BY orders.item_id ORDER BY count DESC LIMIT $number");
}

