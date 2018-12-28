$(function () {
    var flag = 1;

    console.log(user_id);

    $(document).ajaxStop(function () {

        if (flag == 0) {
            return false;
        }

        var limit_icon = $(".limit-icon");

        var lock_group = [];

        $(".group").each(function () {
            // console.log($(this).find(".time-limit").val());

            var g = $(this);
            var group_id = g.attr("data-gid");

            var time_limit = g.find(".time-limit").val();

            if (time_limit != null && time_limit != '' && time_limit != '0000-00-00 00:00:00') {
                var time = moment(time_limit);

                g.attr("style", "outline: 5px dashed red;");
                var head = g.find("h3");
                head.append("<h5 class='countDown'></h5>");

                var n = moment();
                if (time.isAfter(n)) {
                    var f = function () {
                        var now = moment();
                        var diff = time.diff(now);
                        var duration = moment.duration(diff), days = duration.days();
                        g.find(".countDown").html("餘 " + (days == 0 ? "" : days + " 天 ") + moment.utc(diff).format("HH 小時 mm 分鐘 ss 秒"));

                        if (now.isAfter(time)) {
                            g.find(".countDown").html("已逾期");
                            g.find("input, button").attr("disabled", true).unbind("click");
                            clearInterval(i);
                        }
                    };

                    f();

                    var i = setInterval(f, 1000);
                } else {
                    lock_group.push(group_id);
                    g.find(".countDown").html("已逾期");
                    g.find("input, button").attr("disabled", true).unbind("click");
                }

                head.attr("style", "color: red");
                head.find("font").after(limit_icon.clone().removeAttr("hidden"));
            }

        });

        var order_timeout_check = function () {
            console.log(lock_group);

            $(".order").each(function () {
                var o = $(this);
                var order_id = o.attr("data-oid");

                for (var i in lock_group) {
                    if (order_id.indexOf(user_id + "-" + floor_id + "-" + lock_group[i]) != -1) {
                        o.find(".order-delete").attr("disabled", true);
                        break;
                    }
                }
            });
        };

        order_timeout_check();

        //Because button re-generate dynamic by other js file, use on to bind document event
        $(document).on("click", ".order-add, .order-delete", order_timeout_check);

        flag = 0;
    });

});

