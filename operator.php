<?php
$PERMISSION = 1;
include "module/session.php";
include "module/locker.php";
include "module/settings.php";

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

		//order checkout
        if($_POST["command"] == "set-checkout-orders"){
            $json = set_checkout_orders($json);
        }

        //adjust purse
        if($_POST["command"] == "set-purses"){
            $json = set_purses($json);
        }

        //adjust purse
        if($_POST["command"] == "get-purse-event"){
            $json["purse_event"] = get_purse_event(isset($json["user_id"]) ? $json["user_id"] : null,
                isset($json["user_name"]) ? $json["user_name"] : null);
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
