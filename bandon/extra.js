

(function (){

	function draw(){
	
		var container = document.createDocumentFragment();
		for(var did in detailList){
			container.appendChild(makeDetail(detailList[did]));
		}
		document.querySelector(".detail-list").appendChild(container);
		
		updateTable();
	}
	
	function updateTable(){
	
		var table = Element("table", {class: "item-detail table"});
		var thead = Element("thead");
		var tr = Element("tr")
		tr.appendChild(Element("td"));
		for(var did in detailList){
			var e = Element("th", null, detailList[did].name);
			tr.appendChild(e);
			detailList[did].element = e;
		}
		thead.appendChild(tr);
		table.appendChild(thead);
		
		var tbody = Element("tbody");
		// console.log(groupList);
		for(var gid in groupList){
			var group = groupList[gid];
			var tr = Element("tr");
			tr.appendChild(Element("th", {colspan: 999}, groupList[gid].name));
			tbody.appendChild(tr);
			
			for(var iid in group.items){
				var item = itemList[iid];
				var tr = Element("tr");
				tr.appendChild(Element("td", null, item.name));
				
				for(var did in detailList){
					var td = Element("td");
					var check = makeItemDetailCheck(item, detailList[did]);
					td.appendChild(check);
					tr.appendChild(td);
				}
				tbody.appendChild(tr);
			}
			
		}
		table.appendChild(tbody);
		
		var ot = document.querySelector(".item-detail");
		ot.parentNode.replaceChild(table, ot);
	}

	function makeItemDetailCheck(item, detail){
		var id = item.id + "," + detail.id;
		
		// var l = Element("label", {class: "btn-block"});
		
		var check = Element("input", {type: "checkbox"});
		// l.appendChild(check);
		
		if(itemDetailList[id]){
			check.checked = true;
		}
		check.onchange = function(){
			if(this.checked){
				if(itemDetailList[id]){
					return;
				}
				// new item detail
				itemDetailList[id] = item.details[detail.id] = detail.items[item.id] = {
					id: id,
					item_id: item.id,
					detail_id: detail.id
				};
			}else{
				if(!itemDetailList[id]){
					return;
				}
				var re = itemDetailList[id];
				delete itemDetailList[id];
				delete item.details[re.detail_id];
				delete detail.items[re.item_id];
			}
		}
		return check;
		// return l;
	}
	
	function init(){
		buildModel();
		draw();
		registEvent();
	}
	
	function makeDetail(detail){
		var divWrap = Element("div", {class: "form-group"});
		
		var inputWrap = Element("div", {class: "col-sm-10"});
		divWrap.appendChild(inputWrap);
	
		var div = Element("div", {class: "detail input-group"});
		inputWrap.appendChild(div);
		
		var name = Element("input", {class: "detail-name form-control", type: "text", placeholder: "細項名稱", value: detail.name});
		name.onchange = function(){
			detail.name = this.value;
			detail.element.innerHTML = detail.name;
		}
		div.appendChild(name);
		
		var options = Element("input", {class: "options form-control", type: "text", placeholder: "項目1, 項目2, 項目3, ..."});
		var ops = [];
		for(oid in detail.options){
			ops.push(detail.options[oid].name);
		}
		options.value = ops.join(", ");
		options.onchange = function(){
			for(var oid in detail.options){
				delete optionList[oid];
			}
			detail.options = {};
			var ops = this.value.split(/\s*,\s*/);
			var oid = maxKey(optionList) + 1;
			for(var i = 0; i < ops.length; i++){
				detail.options[oid] = optionList[oid] = {
					id: oid,
					name: ops[i],
					detail_id: detail.id
				}
				oid++;
			}
		}
		div.appendChild(options);
		
		var price = Element("input", {type: "input", class: "detail-price form-control", value: detail.price || "", placeholder: "價格"});
		price.onchange = function(){
			detail.price = this.value * 1;
		}
		div.appendChild(price);
		
		var delBtn = Element("div", {class: "col-sm-2"});
		divWrap.appendChild(delBtn);
		
		var remove = Element("input", {type: "button", value: "刪除", class: "btn btn-default btn-block"});
		remove.onclick = function(){
			for(var oid in detail.options){
				delete optionList[oid];
			}
			delete detailList[detail.id];
			divWrap.parentNode.removeChild(divWrap);
			updateTable();
		}
		delBtn.appendChild(remove);
		
		return divWrap;
	}
	
	function addDetail(){
		var id = maxKey(detailList) + 1;
		var newDetail = detailList[id] = {
			id: id,
			name: "",
			items: {},
			options: {},
			price: 0
		}
		document.querySelector(".detail-list").appendChild(makeDetail(newDetail));
		
		updateTable();
	}
	
	function registEvent(){
		document.querySelector(".add-detail").onclick = addDetail;
		document.querySelector("form").onsubmit = submit;
	}
	
	function submit(){
		var submitButton = document.querySelector("input[type='submit']");
		submitButton.value = "等待伺服器回應中……";
		submitButton.disabled = true;
		var statusInfo = document.querySelector(".status-info");
	
		var json = {
			detailList: {},
			optionList: optionList,
			itemDetailList: itemDetailList
		}
		
		for(var id in detailList){
			json.detailList[id] = {
				id: id,
				name: detailList[id].name,
				price: detailList[id].price
			}
		}
		// console.log(json);
		json = JSON.stringify(json);
		
		myAjax({
			url: "operator.php",
			query: "command=extra&data=" + json,
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
