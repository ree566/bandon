/*! bandon 2014-08-08 */

!function(){function a(){b(),d(),j()}function b(){v.orders.forEach(function(a){a.number*=1,a.kind.price*=1})}function c(){function a(a){v=a.user,i()}function b(a){console.log(a),alert("取得員工資訊失敗！")}function c(a){w=a.floors,i()}function d(a){console.log(a),alert("取得各樓層菜單失敗！")}myPost("get-user","",a,b),myPost("get-floors","",c,d)}function d(){f(),e(),v.orders.length?s():r(),g(),h()}function e(){var a=0;v.orders.forEach(function(b){var c=0;b.options.forEach(function(a,b){console.log(v.orders,b,a),c+=1*a.detail.price}),a+=(c+1*b.kind.price)*b.number}),$(".price-showoff .price").html(a)}function f(){var a=[];w.forEach(function(b){var c=T('<div class="panel panel-default order-floor order-floor-{floor_id} {close}">				<div class="panel-heading">{floor_name} {status}</div>				<ul class="buying-list buying-list-{floor_id} list-group text-left"></ul>			</div>',{floor_id:b.id,floor_name:b.name,close:1*b.open?"":"locked",status:1*b.open?'<span class="text-success">開放訂購中</span>':'<span class="text-danger">關閉訂購中</span>'});a.push(c)}),$(".orders-inner").html(a.join("")),v.orders.forEach(function(a){if(a.number){console.log(a);var b=T('<li class="list-group-item order" data-oid="{id}">				<div class="row">					<div class="col-md-2 col-xs-2">						<button class="btn btn-default btn-sm order-delete" {disable}>-</button>						<span class="glyphicon glyphicon-ok"></span>					</div>					<div class="col-md-8 col-xs-8 description">						{group_name} {item_name} {kind_name} {price}元 {options}					</div>					<div class="col-md-2 col-xs-2 number">						&times;{number}					</div>				</div>			</li>',{id:u(a),group_name:a.group.name,item_name:a.item.name,kind_name:a.kind.name,price:a.kind.price,options:loop(a.options,function(a){return a.name+(1*a.detail.price?"(+"+a.detail.price+")":"")}).join(" "),number:a.number,disable:1*a.floor.open?"":"disabled"});$(".buying-list-"+a.floor.id).append(b)}}),$(".order-floor").each(function(){var a=$(".buying-list",this).children().length;console.log(a),a||$(this).addClass("hidden")})}function g(){var a=[];w.forEach(function(b){var c=T('<option value="{floor_id}" {selected}>{floor_name}</option>',{floor_id:b.id,floor_name:b.name,selected:b.id==v.floor_id?"selected":""});a.push(c)}),$(".floors").html(a.join(" "))}function h(){var a=$(".floors option:selected").val(),b=null;w.every(function(c){return c.id==a?(b=c,!1):!0}),b.open*=1,b.open?($(".groups").html(""),$(".groups").removeClass("locked")):($(".groups").html('<div class="alert alert-danger" role="alert">此樓層關閉訂購中</div>'),$(".groups").addClass("locked")),console.log(b);var c=[];b.groups.forEach(function(a){var d=[];a.items.forEach(function(a){var c=[];a.kinds.forEach(function(b,d){var e=T('<label>						<input type="radio" data-kid="{kind_id}" class="kind" name="item-{item_id}" value="{kind_id}" {checked}>						{kind_name} {kind_price}元					</label>',{kind_id:b.id,kind_name:b.name,kind_price:b.price,checked:d?"":"checked",item_id:a.id});c.push(e)});var e=[];a.details.forEach(function(a){var b=[];a.options.forEach(function(a){var c=T('<option value="{option_id}">{option_name}</option>',{option_id:a.id,option_name:a.name});b.push(c)});var c=T('<label>						{name}{price}						<select data-did="{detail_id}" class="detail">							<option value="0">一般</option>							{options}						</select>					</label>',{name:a.name,detail_id:a.id,options:b.join(" "),price:1*a.price?"("+a.price+"元)":""});e.push(c)});var f=T('<div class="col-lg-3 col-md-3 col-sm-4">					<div class="item-wrap well item" data-iid="{item_id}">						<h4 class="name">{item_name}</h4>						<div class="kinds">{kinds}</div>						<div class="details">{details}</div>						<button type="button" class="btn btn-default order-add" data-toggle="popover" data-content="已加入{item_name}" {disable}>+</button>					</div>				</div>',{item_id:a.id,item_name:a.name,kinds:c.join(" "),details:e.join(" "),disable:1*b.open?"":"disabled"});d.push(f)});var e=T('<div data-gid="{group_id}" class="group">				<h3>{group_name}</h3>				<div class="row selling-list">{items}</div>			</div>',{group_id:a.id,group_name:a.name,items:d.join(" ")});c.push(e)}),$(".groups").append(c.join(""))}function i(){v&&w&&a()}function j(){k(),l(),m(),n()}function k(){$(".order-delete").click(o);var a={top:16,bottom:40};bFix(window,"html",".orders-wrap",a)}function l(){$(".submit").click(q)}function m(){$(".floors").change(function(){h(),n()})}function n(){$(".order-add").click(p),$(".order-add").popover({trigger:"focus"})}function o(){var a=$(this).parents(".order").data("oid");console.log(a),v.orders.every(function(b){var c=u(b);return c==a?(b.number>0&&b.number--,!1):!0}),f(),e(),k()}function p(){var a=$(this).parents(".item"),b=$(".floors").val(),c=a.data("iid"),d=a.parents(".group").data("gid"),g=$(".kind:checked",a).val();console.log(g);var h=$(".detail",a).map(function(){return $(this).val()}).get(),i=null;w.every(function(a){return a.id==b?(i=a,!1):!0});var j=null;i.groups.every(function(a){return a.id==d?(j=a,!1):!0});var l=null;j.items.every(function(a){return a.id==c?(l=a,!1):!0});var m=null;l.kinds.every(function(a){return a.id==g?(m=a,!1):!0});var n=[];l.details.forEach(function(a){a.options.forEach(function(b){console.log(h),h.every(function(c){return b.id==c?(n.push({id:b.id,name:b.name,detail:{id:a.id,name:a.name,price:a.price}}),!1):!0})})});var o={floor:{id:i.id,name:i.name,open:1*i.open},item:{id:l.id,name:l.name},group:{id:j.id,name:j.name},kind:{id:m.id,name:m.name,price:m.price},options:n,number:1},p=u(o),q=v.orders.every(function(a){return p!=u(a)?!0:(a.number+=o.number,!1)});q&&v.orders.push(o),f(),e(),k()}function q(){function a(a){console.log(a),alert("儲存成功！"),s()}function b(a){console.log(a),alert("儲存失敗！")}if("order"!=x)r();else{var c={orders:v.orders};myPost("set-orders",c,a,b,this)}}function r(){t("order")}function s(){t("view")}function t(a){x=a,$("html").removeClass(function(a,b){return console.log(b,loop(b.split(" "),function(a){return a.indexOf("page-")?a:""}).join(" ")),loop(b.split(" "),function(a){return a.indexOf("page-")?"":a}).join(" ")}),$("html").addClass("page-"+x)}function u(a){return T("{}-{}-{}-{}-{}",[v.id,a.floor.id,a.item.id,a.kind.id,a.options.map(function(a){return a.id}).join(",")])}var v=null,w=null,x="view";$(document).ready(c)}();
//# sourceMappingURL=view.js.map