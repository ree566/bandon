/*! bandon 2014-08-08 */

!function(){function a(){function a(a){c=a.items,b()}function d(a){console.log(a),alert("取得熱門失敗")}var e={count:5};myPost("get-today-hot",e,a,d)}function b(){for(var a=[],b=0;5>b;b++)if(c.length){var d=c[b%c.length];a.push(T("<li>有 {count} 個人點了 {item}</li>",{count:d.count,item:d.name}))}else a.push("<li>都沒人點餐，快點餐吧！</li>");$(".today-hot-list").html(a.join(""))}var c=null;$(document).ready(a)}();
//# sourceMappingURL=today-hot.js.map