/*! bandon 2014-08-08 */

!function(){function a(){$("form").submit(b)}function b(){function a(){alert("儲存成功！請重新登入"),location.href="logout.php"}function b(a){console.log(a),alert("發生錯誤！"+a.error)}var c=$(".old-pass").val(),d=$(".new-pass").val(),e=$(".check-pass").val();if(!d||!e)return alert("請勿留空"),!1;if(d!=e)return alert("請重覆輸入新密碼"),!1;var f={old_pass:c,new_pass:d};return myPost("set-user",f,a,b,$(".submit")),!1}document.addEventListener("DOMContentLoaded",a,!1)}();
//# sourceMappingURL=account.js.map