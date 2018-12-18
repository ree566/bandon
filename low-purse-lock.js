$(function () {
    if (amount < purse_min_allow) {
        var message = "餘額不足(" + amount + "), 請聯絡系統管理員!!";
        $(".submit").attr("disabled", true).unbind("click");
        $(".menus").children().replaceWith("<h5 style='color:red'>" + message + "</h5>");
        $(".menus").children().not(':first').remove();
        alert(message);
    }
});