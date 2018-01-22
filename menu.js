

(function (){

	function makeHiddenCheckBox(group){
		// var div = Element("div", {class: "wrap-checkbox checkbox input-group-addon"});
		

		var l = Element("label", {class: "wrap-checkbox input-group-addon", for: "hidden-check-" + group.id});
		// div.appendChild(l);
		
		var check = Element("input", {class: "group-hidden", type: "checkbox", id: "hidden-check-" + group.id});
		l.appendChild(check);

		check.onchange = function(){
			group.hidden = this.checked;
		}
		
		if(group.hidden){
			check.checked = true;
		}
		
		l.appendChild(document.createTextNode(" 隱藏"));
		
		return l;
	}
	
	function makeDeleteGroupButton(group){
		// var div = Element("div", {class: "col-md-1"});
		
		var b = Element("a", {class: "pull-right btn btn-default"} , "刪除");
		// div.appendChild(b);
		
		b.onclick = function(){
			if(!confirm("確定要刪除此菜單？")){
				return false;
			}
			
			group.element.parentNode.removeChild(group.element);
			for(var iid in group.items){
				for(var kid in itemList[iid].kinds){
					delete kindList[kid];
				}
				delete itemList[iid];
			}
			delete groupList[group.id];
			delete group.element;
		}
		
		return b;
	}
	
	function newKind(item){
		var kid = maxKey(kindList) * 1 + 1;
		console.log(kindList, kid);
		var kind = item.kinds[kid] = kindList[kid] = {
			id: kid,
			name: "",
			price: "",
			item_id: item.id
		};
		console.log(kindList);
		return kind;
	}
	
	function makeAddItemButton(group){
		var div = Element("input", {class: "btn btn-default pull-right", type: "button", value: "新增項目"});
		
		div.onclick = function(){
			// new blank item
			var iid = maxKey(itemList) * 1 + 1;
			var newItem = itemList[iid] = {
				id: iid,
				name: "",
				group_id: group.id,
				kinds: {}
			};
			newKind(newItem);
			group.element.querySelector(".edit-list").appendChild(makeItem(newItem));
		}
		
		return div;
	}
	
	function makeGroup(group){
		var div = Element("div", {id: "gid-" + group.id, class: "group clearfix text-left"});
		
		// var p = Element("p", {class: "text-center"});
		// div.appendChild(p);
		
		var header = Element("div", {class: "form-group"});
		div.appendChild(header);
		
		var inner = Element("div", {class: "col-sm-10 col-xs-10 col-xs-10"});
		header.appendChild(inner);
		
		var headWrap = Element("div", {class: "input-group"});
		inner.appendChild(headWrap);
		
		var head = Element("input", {class: "form-control input-lg group-name header", type: "text", value: group.name, placeholder: "店名"});
		head.onchange = function(){
			group.name = this.value;
		}
		headWrap.appendChild(head);
		
		var hiddenCB = makeHiddenCheckBox(group);
		headWrap.appendChild(hiddenCB);
		
		var inner2 = Element("div", {class: "col-sm-2 col-xs-2"});
		header.appendChild(inner2);

		var delBtn = makeDeleteGroupButton(group);
		inner2.appendChild(delBtn);
		
		var cl = Element("div", {class: "clearfix"});
		div.appendChild(cl);
		
		// var table = Element("table");
		// div.appendChild(table);
		
		// var editList = Element("tbody", {class: "edit-list"});
		// table.appendChild(editList);
		
		var editList = Element("div", {class: "edit-list"});
		div.appendChild(editList);
		
		var addItemButton = makeAddItemButton(group);
		div.appendChild(addItemButton);
		
		group.element = div;
		
		return div;
	}
	
	function makeDeleteItemButton(item){
		var div = Element("input", {type: "button", value: "×", class: "btn btn-default"});
		
		div.onclick = function(){
			item.element.parentNode.removeChild(item.element);
			delete item.element;
			delete itemList[item.id];
			
			for(var kid in item.kinds){
				delete kindList[kid];
			}
		}
		
		return div;
	}
	
	function addGroup(){
		var gid = maxKey(groupList) * 1 + 1;
		var newGroup = groupList[gid] = {
			id: gid,
			name: "",
			hidden: 0
		};
		
		document.querySelector(".group-list").appendChild(makeGroup(newGroup));
	}

	function makeKind(kind){
		var div = Element("div", {class: "kind input-group"});
		
		// var divName = Element("div", {class: "form-group col-md-4"});
		// div.appendChild(divName);
		
		var name = Element("input", {class: "form-control kind-name", type: "text", value: kind.name, placeholder: "種類"});
		name.onchange = function(){
			kind.name = this.value;
		}
		div.appendChild(name);
		
		// var divPrice = Element("div", {class: "form-group col-md-4"});
		// div.appendChild(divPrice);
		
		var price = Element("input", {class: "form-control kind-price", type: "text", value: kind.price, placeholder: "價格"});
		price.onchange = function(){
			kind.price = this.value * 1;
		}
		div.appendChild(price);
		
		// div.appendChild(document.createTextNode(" 元 "));

		var divBtn = Element("span", {class: "input-group-btn"});
		div.appendChild(divBtn);
		
		var remove = Element("button", {type: "button", value: "移除種類", class: "btn btn-default"}, "移除種類");
		remove.onclick = function(){
			if(count(itemList[kind.item_id].kinds) <= 1){
				alert("一個項目至少包含一種商品");
				return false;
			}
			div.parentNode.removeChild(div);
			delete itemList[kind.item_id].kinds[kind.id];
			delete kindList[kind.id];
		}
		divBtn.appendChild(remove);
		
		return div;
	}
	
	
	function makeItem(item){
		var div = Element("div", {id: "iid-" + item.id, class: "item form-group"});
		
		var divName = Element("div", {class: "col-md-4"});
		div.appendChild(divName);
		
		var name = Element("input", {class: "item-name form-control", type: "text", value: item.name, placeholder: "項目"});
		name.onchange = function(){
			item.name = this.value;
		}
		divName.appendChild(name);
		
		var divKind = Element("div", {class: "col-md-5"});
		div.appendChild(divKind);
		
		for(var kid in item.kinds){
			divKind.appendChild(makeKind(kindList[kid]));
		}
		
		var divBtn = Element("div", {class: "col-md-3 text-right"});
		div.appendChild(divBtn);
	
		var addKind = Element("input", {type: "button", value: "增加種類", class: "btn btn-default"});
		addKind.onclick = function(){
			var kind = newKind(item);
			var div = makeKind(kind);
			divKind.appendChild(div);
		}
		divBtn.appendChild(addKind);
		
		var delBtn = makeDeleteItemButton(item);
		divBtn.appendChild(delBtn);
	
		// var tr = Element("tr", {id: "iid-" + item.id, class: "item"});
		
		// var div = Element("td");
		// tr.appendChild(div);
		
		// var name = Element("input", {class: "item-name form-control", type: "text", value: item.name, placeholder: "項目"});
		// name.onchange = function(){
			// item.name = name.value;
		// }
		// div.appendChild(name);

		// var wrapKinds = Element("td", {class: "kind-wrap"});
		// for(var kid in item.kinds){
			// wrapKinds.appendChild(makeKind(kindList[kid]));
		// }
		// tr.appendChild(wrapKinds);
		
		// var div = Element("td");
		// var addKind = Element("input", {type: "button", value: "增加種類", class: "btn btn-default"});
		// addKind.onclick = function(){
			// var kind = newKind(item);
			// var div = makeKind(kind);
			// wrapKinds.appendChild(div);
		// }
		// div.appendChild(addKind);
		// div.appendChild(makeDeleteItemButton(item));
		// tr.appendChild(div);
		
		item.element = div;
		
		return div;
	}
	
	function draw(){
		// draw menus
		var container = document.createDocumentFragment();
		var gid, iid, eid;
		
		for(gid in groupList){
			container.appendChild(makeGroup(groupList[gid]));
		}
		
		// put items
		for(iid in itemList){
			var group = groupList[itemList[iid].group_id].element;
			group.querySelector(".edit-list").appendChild(makeItem(itemList[iid]));
		}
		
		document.querySelector(".group-list").appendChild(container);
	}
	
	function buildModel(){
		for(var id in itemList){
			var group = groupList[itemList[id].group_id];
			if(!group.items){
				group.items = {};
			}
			group.items[id] = itemList[id];
		}
		
		for(var id in kindList){
			var item = itemList[kindList[id].item_id];
			if(!item){
				console.log(kindList[id].item_id);
				continue;
			}
			if(!item.kinds){
				item.kinds = {};
			}
			item.kinds[id] = kindList[id];
		}
	}
	
	function init(){
		buildModel();
		draw();
		registEvent();
	}
	
	function registEvent(){
		document.querySelector(".add-group").onclick = addGroup;
		document.querySelector("form").onsubmit = submit;
	}
	
	function submit(){
		var submitButton = document.querySelector("input[type='submit']");
		submitButton.value = "等待伺服器回應中……";
		submitButton.disabled = true;
		var statusInfo = document.querySelector(".status-info");
	
		var json = {
			groupList: {},
			itemList: {},
			kindList: {}
		}
		
		for(var id in groupList){
			json.groupList[id] = {
				id: id,
				name: groupList[id].name,
				hidden: groupList[id].hidden
			}
		}
		
		for(var id in itemList){
			json.itemList[id] = {
				id: id,
				name: itemList[id].name,
				group_id: itemList[id].group_id
			}
		}
		
		for(var id in kindList){
			json.kindList[id] = {
				id: id,
				name: kindList[id].name,
				price: kindList[id].price,
				item_id: kindList[id].item_id
			}
		}
		
		json = JSON.stringify(json);
		// console.log(json);
		
		myAjax({
			url: "operator.php",
			query: "command=menu&data=" + json,
			method: "POST",
			complete: function(r){
				if(r.responseText.trim() == "success"){
					alert("儲存成功！");
					// location.reload(true);
					location.replace(location.href);
				}else{
					alert("儲存失敗！" + r.responseText);
				}
				
				submitButton.value = "儲存";
				submitButton.disabled = false;
			},
			fail: function(){
				alert("發生錯誤！");
				submitButton.value = "儲存";
				submitButton.disabled = false;
			}
		});
		return false;
	}
	
	document.addEventListener("DOMContentLoaded", init, false);
})();
