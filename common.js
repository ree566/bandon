if(!Array.forEach){
	Array.prototype.forEach = function(func){
		var i;
		for(i = 0; i < this.length; i++){
			func(this[i], i, this);
		}
	};
}

if(!Array.every){
	Array.prototype.every = function(func){
		var i;
		for(i = 0; i < this.length; i++){
			if(!func(this[i], i, this)){
				return false;
			}
		}
		return true;
	};
}

if(!Array.map){
	Array.prototype.map = function(func){
		var i,
			list = [];
		for(i = 0; i < this.length; i++){
			list.push(func(this[i], i, this));
		}
		return list;
	};
}

function add(a, b){
	return a + b;
}

function bFix(window, container, elem, padding){
	// var tid = 0;
					
	function bfix(){
		var o = $(elem),
			scrollTop = $(window).scrollTop(),
			offsetTop = Math.ceil(o.offset().top),
			height = o.height(),
			containerHeight = $(container).prop("scrollHeight"),
			oTop = o.parent().offset().top;
			
		// console.log(scrollTop, offsetTop, height, containerHeight, padding.top, padding.bottom);
			
		if(scrollTop + padding.top + height == containerHeight - padding.bottom){
			return;
		}else if(scrollTop + padding.top + height > containerHeight - padding.bottom){
			o.css("top", containerHeight - padding.bottom - height - oTop);
		}else if(scrollTop + padding.top < oTop){
			o.css("top", 0);
		}else if(scrollTop + padding.top > oTop){
			o.css("top", scrollTop + padding.top - oTop);
		}
		// clearTimeout(tid);
		// tid = setTimeout(bfix, 500);
	}
	
	$(window).on("scroll", bfix);
}

function T(s, dict){
	if($.isArray(dict)){
		s = s.split("{}");
		p = [];
		s.forEach(function(e, i){
			p.push(e);
			p.push(dict[i]);
		});
		s = p.join("");
	}else{
		for(var key in dict){
			// s = s.replace("{" + key + "}", dict[key]);
			s = s.split("{" + key + "}").join(dict[key] || "");
		}
	}
	return s;
}

function loop(arr, func){
	var newArr = [];
	arr.forEach(function(e, i, s){
		newArr.push(func(e, i, s));
	});
	return newArr;
}

function isString(s){
	if (typeof s == 'string' || s instanceof String){
		return true;
	}
	return false;
}

function myPost(command, json, success, fail, button){
	if(button){
		$(button).data("btnText", $(button).text());
		$(button).text("與伺服器連線中……");
		$(button).prop("disabled", true);
		$(button).addClass("null");
	}
	
	if (!isString(json)){
		json = JSON.stringify(json);
	}
	
	$.post("operator.php", "command="+command+"&data="+json)
		.done(function(data){
			var json = {};
			
			try{
				json = JSON.parse($.trim(data));
			}catch(er){
				json.state = "error";
				json.error = er;
				json.data = data;
			}
			
			if(json.state == "success"){
				success(json);
			}else{
				fail(json);
			}
		})
		.fail(fail)
		.always(function(){
			if(button){
				$(button).prop("disabled", false);
				$(button).text($(button).data("btnText"));
				$(button).removeClass("null");
			}
		});
}

function myAjax(o){
	var httpRequest;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
		httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		throw "can't init httpRequest";
	}
	
	httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState != 4) {
			return;
		}
		
		if (httpRequest.status != 200) {
			o.fail();
			return;
		}
		
		o.complete(httpRequest);
	};

	httpRequest.open(o.method, o.url||location.href);
	httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	httpRequest.send(o.query);
}

function Element(s, o, i){
	var e = document.createElement(s);
	var k;
	for(k in o){
		e.setAttribute(k, o[k]);
	}
	
	if(!i){
		return e;
	}

	if(typeof i == "string" || typeof i == "number"){
		e.innerHTML = i;
	}else{
		e.appendChild(i);
	}
	
	return e;
}

function maxKey(o){
	var max = 0, k;
	for(k in o){
		k = k * 1;
		if(k > max){
			max = k;
		}
	}
	return max;
}

// function messageBox(node, title, x, y){
	// title = title || "";
	// var div = Element("div", {class: "message-box", style: "top: " + y + "px; left: " + x + "px;"});
	// var header = Element("header", {class: "message-box-title"}, title);
	// var closeButton = Element("input", {class: "message-box-close-button button-small", type: "button", value: "X"});
	// closeButton.onclick = function(){
		// div.parentNode.removeChild(div);
	// }
	// header.appendChild(closeButton);
	// div.appendChild(header);
	
	// var body = Element("div", {class: "message-box-body"}, node);
	// div.appendChild(body);
	
	// document.querySelector("body").appendChild(div);
// }

// http://stackoverflow.com/questions/4994201/is-object-empty
function isEmpty(obj) {
	var hasOwnProperty = Object.prototype.hasOwnProperty;

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}

function count(obj){
	var hasOwnProperty = Object.prototype.hasOwnProperty;

    // null and undefined are "empty"
    if (obj == null) return 0;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return obj.length;
    if (obj.length === 0)  return 0;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
	var i = 0;
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) i++;
    }

    return i;
}
