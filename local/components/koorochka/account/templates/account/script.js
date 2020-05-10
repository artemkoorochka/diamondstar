
function accountReload() {
    $.get("/account/",{html:"modal1"},function (data) {

        $("#modal1").html(data);

        setTimeout(function () {
            $("#modal1").find(".modal-body")
                .niceScroll({cursorcolor:"#b5985a", touchbehavior:true, cursoropacitymin:1});
            $("#progress_items_container")
                .niceScroll({cursorcolor:"#b5985a", touchbehavior:true, cursoropacitymin:1});
            //$(".nicescroll-rails").remove();
        }, 1000);

    });

    return false;
}

/**
 * Phone add
 * @param t
 * @returns {boolean}
 */
function login_phone_add(t, page) {
    var form = $(t).parent().parent(),
        phone = $("#PERSONAL_PHONE").val(),
        email = $("#EMAIL").val(),
        re = /\S+@\S+\.\S+/;

    if(email !== undefined)
    {
        if(email.length < 1)
        {
            $("#EMAIL")
                .parent()
                .parent()
                .removeClass("has-success")
                .addClass("has-error")
                .find(".help-block").hidden("Не введен адрес электронной почты");
        }
    }
    else if(re.test(email) == false)
    {
        $("#EMAIL")
            .parent()
            .parent()
            .removeClass("has-success")
            .addClass("has-error")
            .find(".help-block").hidden("Неверный адрес электронной почты");
    }
    else
    {
        $("#EMAIL")
            .parent()
            .parent()
            .removeClass("has-error")
            .addClass("has-success")
            .find(".help-block").hidden("Корректный адрес электронной почты");
    }

    if(phone !== undefined)
    {
        if(phone.length > 2)
        {
            $.getJSON(page, form.serialize(), function(data){
                if(data.SUCCESS == undefined)
                {
                    if(data.ERROR.PHONE_VALID){
                        $("#PERSONAL_PHONE")
                            .parent()
                            .parent()
                            .removeClass("has-success")
                            .addClass("has-error")
                            .find(".help-block").hidden(data.ERROR.PHONE_VALID);
                    }
                    else {
                        $("#PERSONAL_PHONE")
                            .parent()
                            .parent()
                            .removeClass("has-error")
                            .addClass("has-success")
                            .find(".help-block").hidden("Корректный номер телефона");
                    }

                }
                else
                {
                    $("#loader").show();
                    form.removeClass("has-error").addClass("has-success");
                    $.get(page,{html:"modal1"}, function (data) {
                        $("#modal1").html(data).find(".modal-body")
                            .niceScroll({cursorcolor:"#b5985a", touchbehavior:true, cursoropacitymin:1});;
                        $("#loader").hide();
                    });
                }
            });
        }
    }
    else{
        $("#PERSONAL_PHONE")
            .parent()
            .parent()
            .removeClass("has-success")
            .addClass("has-error")
            .find(".help-block").hidden("Неверный номер телефона");
    }
    return false;
}

/**
 * Show progress info
 * @param t
 * @returns {boolean}
 */
function show_progress_info(t) {
    //$(".nicescroll-rails").remove();
    var dialog = $("#modal3"),
        body = dialog.find(".modal-content"),
        id = $(t).data("id");

    if(id > 0)
    {
        $.get("/account/progress.list.php", {
            id:id,
            height:document.documentElement.clientHeight,
            width:document.documentElement.clientWidth
        }, function(data){
            body.html(data);
        });
    }

    // 5 dialog show
    dialog.modal();

    return false;
}

/**
 * Show next process
 * @param id
 * @param next
 * @param prev
 * @returns {boolean}
 */
function show_progress(id) {

    if(id > 0)
    {
        $.get("/account/progress.list.php", {
            id:id,
            carusel:'yes'
        }, function(data){
            $("#modal3").find(".modal-body").html(data);
        });
    }

    return false;
}

/**
 * Level
 * @param t
 * @returns {boolean}
 */
function show_level_info(t) {
    //$(".nicescroll-rails").remove();
    var dialog = $("#modal3"),
        body = dialog.find(".modal-content"),
        id = $(t).data("id");

    if(id > 0)
    {
        $.get("/account/level.list.php", {
            id:id,
            //url: document.referrer,
            url: top.window.location.href,
            height:document.documentElement.clientHeight,
            width:document.documentElement.clientWidth
        }, function(data){
            body.html(data);
        });
    }

    // 5 dialog show
    dialog.modal();
    return false;
}

/**
 * Show progress info
 * @param t
 * @returns {boolean}
 */
function show_present_info(t) {
    //$(".nicescroll-rails").remove();
    var dialog = $("#modal4"),
        body = dialog.find(".modal-content"),
        id = $(t).data("id");

    if(id > 0)
    {
        $.get("/account/presents.list.php", {
            id:id,
            participant: $(t).data("participant"),
            set: $(t).data("set"),
            height:document.documentElement.clientHeight,
            width:document.documentElement.clientWidth
        }, function(data){
            body.html(data);
        });
    }

    // 5 dialog show
    dialog.modal();

    return false;
}

function orderPresent(t)
{
    //$(".nicescroll-rails").remove();
    var dialog = $("#modal5"),
        body = dialog.find(".modal-content"),
        id = $(t).data("id"),
        quantity = $(t).data("quantity"),
        participant = $(t).data("participant");

    if(id > 0)
    {
        $.get("/account/present.order.php", {
            id:id,
            quantity: quantity,
            participant: participant
        }, function(data){
            body.html(data);
        });
    }

    // 5 dialog show
    dialog.modal();

    return false;
}

/**
 * Order present form
 * @param t
 * @returns {boolean}
 */
function orderPresentForm(t)
{
    $(t).find(".alert")
        .removeClass("alert-danger")
        .removeClass("alert-success")
        .addClass("alert-success")
        .html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> Loading...');

    $(t).append($("<div />",{
        id:"loader",
        class:"fa fa-spinner fa-spin fa-3x fa-fw"
    }));

    $.post($(t).attr("action"), $(t).serialize(), function (result) {
        if(result.ORDER_ID == undefined)
        {
            var message = "";
            if(result.Shop_IDP && result.Order_IDP > 0){
                /**
                 * create form for pay
                 */
                $(t).attr("onsubmit", "orderPresentPayForm(this)")
                    .attr("id", null)
                    .attr("action", result.URL)
                    .attr("target", "pay_iframe")
                    .html($("<input />", {
                        type: "hidden",
                        name: "Shop_IDP",
                        value: result.Shop_IDP
                    }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Order_IDP",
                    value: result.Order_IDP
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Subtotal_P",
                    value: result.Subtotal_P
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Lifetime",
                    value: result.Lifetime
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Customer_IDP",
                    value: result.Customer_IDP
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Comment",
                    value: result.Comment
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "Signature",
                    value: result.Signature
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "URL_RETURN_OK",
                    value: result.URL_RETURN_OK
                }));
                $(t).append($("<input />", {
                    type: "hidden",
                    name: "URL_RETURN_NO",
                    value: result.URL_RETURN_NO
                }));
                $(t).append($("<input />", {
                    type: "submit",
                    name: "Submit",
                    style: "display:none;",
                    value: result.SUBMIT_BTN
                }));

                // set iframe
                // <iframe width="630" height="332" name="pay_iframe"></iframe>
                $(t).parent().prepend($("<iframe />", {
                    width: "100%",
                    height: 0,
                    name: "pay_iframe",
                    id: "pay_iframe"
                }));
                $(t).submit();
                $(t).find("#loader").remove();
            }
            else{
                if(result.ERROR != undefined)
                {
                    for(var i = 0; i < result.ERROR.length; i++)
                    {
                        message += result.ERROR[i] + "<br>";
                    }
                    $(t).find(".alert")
                        .removeClass("alert-danger")
                        .removeClass("alert-success")
                        .addClass("alert-danger")
                        .html(message);
                }
                $(t).find("#loader").remove();
            }
        }
        else{
            var text = "Ваш заказ сформирован и оплачен. В ближайшее время с вами свяжется наш менеджер, для уточнения адреса и времени доставки.",
                keeper = {};
            if(result.PARTICIPANT){
                text = "Ваш заказ успешно сформирован и оплачен. В ближайшее время он будет доставлен получателю.";
                keeper = {mode: "participant", participant: result.PARTICIPANT};
            }

            $(t).find(".alert")
                .removeClass("alert-danger")
                .removeClass("alert-danger")
                .addClass("alert-success")
                .html(text);

            $(t).find("input").remove();
            $(t).find("#loader").remove();
            $(t).parent().parent().find(".close").attr("onclick", "closeGlobal()");

            // обновить кошелёк
            $(t).parent().find("#user-keeper").find(".fa-diamond").parent().html('<i class="fa fa-diamond"></i> ' + result.ACCOUNT.DIA);
        }

    }, "json");

    return false;
}

/**
 * set height to frame
 * @param t
 */
function orderPresentPayForm(t) {
    var body = $(t).parent().parent(),
        iframe = body.find("#pay_iframe"),
        height = body.height() - 60;
    iframe.height(height);
          //.width(body.find(".modal-body").width());
    body.find(".modal-body").niceScroll({cursorcolor:"#b5985a", touchbehavior:true, cursoropacitymin:1});
    body.find(".close").attr("onclick", "closeGlobal()");

}

/**
 * maskPhone
 * @param t
 * @param format
 * @returns {boolean}
 */
function maskPhone(t, format) {
    $(t).parent().parent().parent().find(".dropdown-toggle").find("img").attr("src", $(t).find("img").attr("src"));
    $("#PERSONAL_PHONE").mask(format).focus();
    return false;
}

/**
 * This function execute in 2 & 3 tabs on accaunt modale
 * @param t
 * @param level
 */
function progressShare(t, level, iblock_id, progress) {
    $(t).parent().append('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
    $(t).hide();
    var token = $.cookie("DIAMONDSTAR_SOCIAL_OATOKEN"),
        location = $.cookie("DIAMONDSTAR_SITE");

    if($.cookie("DIAMONDSTAR_SOCIAL_EXTERNAL") == "VKontakte" && token)
    {
        VK.init({
            apiId: 5690067
        });
        /**
         * get data for confirm
         */
        $.post("/account/progress.share.php",{
            level:level,
            url: location,
            iblock_id: iblock_id,
            progress: progress,
            action: 'get_data'
        }, function (json) {
            /**
             * wall.post
             */
            VK.Api.call('wall.post', {
                access_token: token,
                /* message: json.PROGRESS.DETAIL_hidden, */
                message: json.PROGRESS.DETAIL_TEXT,
                v: '5.60'
            }, function(r) {
                if(r.response == undefined)
                {
                    $(t).parent().find(".fa-spinner").remove();
                }
                else{
                    if(r.response.post_id > 0)
                    {
                        $.post("/account/progress.share.php",{
                            level:level,
                            url: location,
                            iblock_id: iblock_id,
                            progress: progress
                        }, function (data) {
                            $(t).parent()
                                .append('<div class="hidden-gray font10">' + data + '</div>')
                                .find(".fa-spinner")
                                .remove();
                            $(t).remove();
                        });
                    }
                }

            });
        }, "json");

    }
    else{
        $.post("/account/progress.share.php",{
            level:level,
            url: location,
            iblock_id: iblock_id,
            progress: progress
        }, function (data) {
            $(t).parent()
                .append('<div class="hidden-gray font10">' + data + '</div>')
                .find(".fa-spinner")
                .remove();
            $(t).remove();
        });
    }


}

/**
 * Get progress list
 * @param t
 * @param lastId
 * @param userId
 */
function getProgressList(t, lastId, userId) {
    $(t).parent().append('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
    $(t).hide();
    $.post("/account/aj_progress_list.php",{
        last_id:lastId,
        user_id: userId
    }, function (data) {
        $(t).parent()
            .append(data)
            .find(".fa-spinner")
            .remove();
        $(t).remove();
    });
}

/**
 * set quantity input-group
 * @param t
 * @param orientation
 * @returns {boolean}
 */
function setQuantity(t, orientation) {
    var input = $(t).parent().find("input"),
        value = parseInt(input.val());
    if(orientation == "-"){
        value = value - 1
    }
    else{
        value = value + 1;
    }
    if(value < 1)
    {
        value = 1;
    }
    input.val(value);
    return false;
}