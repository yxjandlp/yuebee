/*
 * 一些全局变量
 */
var site_url = "http://localhost/test/yuebee/";

/*
 * 获得textarea字数
 */
var getLength = (function(){

    var trim = function(h) {

        try {

            return h.replace(/^\s+|\s+$/g, "")

        } catch(j) {

            return h

        }
    }

    var byteLength = function(b) {

        if (typeof b == "undefined") {

            return 0
        }

        var a = b.match(/[^\x00-\x80]/g);
        return (b.length + (!a ? 0 : a.length))

    };

    return function(q, g) {

        g = g || {};
        g.max = g.max || 140;
        g.min = g.min || 41;
        g.surl = g.surl || 20;
        var p = trim(q).length;

        if (p > 0) {

            var j = g.min,
                s = g.max,
                b = g.surl,
                n = q;
            var r = q.match(/(http|https):\/\/[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+([-A-Z0-9a-z\$\.\+\!\_\*\(\)\/\,\:;@&=\?~#%]*)*/gi) || [];
            var h = 0;
            for (var m = 0,
                     p = r.length; m < p; m++) {
                var o = byteLength(r[m]);
                if (/^(http:\/\/t.cn)/.test(r[m])) {
                    continue
                } else {
                    if (/^(http:\/\/)+(weibo.com|weibo.cn)/.test(r[m])) {
                        h += o <= j ? o: (o <= s ? b: (o - s + b))
                    } else {
                        h += o <= s ? b: (o - s + b)
                    }
                }
                n = n.replace(r[m], "")
            }
            return Math.ceil((h + byteLength(n)) / 2)
        } else {
            return 0
        }
    }
})();

function showbirthday(){

    var el = document.getElementById('birthday');
    var birthday = el.value;

    el.length=0;
    el.options.add(new Option('日', ''));

    for(var i=0;i<28;i++){

        el.options.add(new Option(i+1, i+1));

    }

    if(document.getElementById('birthmonth').value!="2"){

        el.options.add(new Option(29, 29));
        el.options.add(new Option(30, 30));

        switch(document.getElementById('birthmonth').value){

            case "1":
            case "3":
            case "5":
            case "7":
            case "8":
            case "10":
            case "12":{

                el.options.add(new Option(31, 31));

            }
        }

    } else if(document.getElementById('birthyear').value!="") {

        var nbirthyear=document.getElementById('birthyear').value;
        if(nbirthyear%400==0 || (nbirthyear%4==0 && nbirthyear%100!=0)) el.options.add(new Option(29, 29));

    }

    el.value = birthday;
}

/*
 *  ------------------------
 *       jquery begin
 *  ------------------------
 */
$(document).ready(function(){

    /*
     * 页面载入后获取消息条数
     */
    $.ajax({
        "type" : "POST",
        "url" : site_url + 'ucenter/count_notification',
        "data" : '',
        "success" : function(data){

            var num_of_notification = $('#num_of_notification');
            if( data == "0"){

                num_of_notification.removeClass('notification')

            }else{

                num_of_notification.addClass('notification');

            }
            num_of_notification.text(data);
        }

    });

    /*
     * 顶部模板展示区域
     */
    $('#decoration_link').bind('click',function(){

        $("#absolute_top").animate( { height: '220px'}, { duration: "slow" }).show();
        $(this).fadeOut("slow");

    });

    $('#cancel_dec').bind('click',function(){

        $("#absolute_top").animate( { height: '0px'}, { duration: "slow" });
        $("#decoration_link").fadeIn("slow");

    });

    /*
     * 右上角更换模板链接悬浮事件
     */
    $('#decoration_link img').hover(

        function(){

            $(this).attr("src",site_url + "static/img/open.png");

        },

        function(){

            $(this).attr("src",site_url + "static/img/close.png");

        }

    );

    /*
     * 模板悬浮事件
     */
    $('.ucenter_tpl').hover(

        function(){

            $(this).css({

                "border"           : "1px solid #999",
                "background-color" : "#EDEEF1"

            });

        },
        function(){

            $(this).css({

                "border"           : "1px solid white",
                "background-color" : "#fff"

            });

        }

    );

    /*
     * 状态发布
     */
    $('#status_frm').submit(function(){

        $('.success_tip').css('display','block');
        $('.success_tip').html('正在发布状态......');

        var content = $('#status_content').val();
        var length = getLength(content);

        if( length > 0 && length <= 140 ){

            var to_url = site_url + "ucenter/publish_status";
            data = "content=" + content;

            $.ajax({

                "type" : "POST",
                "url" : to_url,
                "data" : data,
                "success" : function(data){

                    $('.success_tip').html('状态发布成功！');
                    $('#status_content').val('');

                }

            });

        }else{

            $('.success_tip').html('字数在1－140之间');

        }

        return false;

    });
    /*
     * 点击添加好友
     */
    $('#add_friend_link a').bind('click',function(){

        var to_id = $("#to_id").val(); //接受方id
        var data = "to=" + to_id;
        var to_url = site_url + 'friend/add_request';
        $('#add_friend_link').html(to_id);

        $.ajax({//异步发送好友添加请求

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            "success" : function(data){

                $('#add_friend_link').html("<p>请求已发送</p>");

            }

        });


    });

    /*
     * 点击同意好友添加请求
     */
    $('.notification_item a').bind('click',function(){

        var notification_id = $(this).attr('name');
        var to_url = site_url + "ucenter/accept_friend_request";
        var data = "id=" + notification_id;


        $.ajax({//异步添加好友

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            "success" : function(data){

                var target_span = "#accept_btn_" + notification_id;
                $(target_span).html("已同意");

            }

        });



    });


    /*
     * textarea状态发表字数统计
     */
    $('#status_content').bind('keyup',function(){

        $('#status_num').text( 140 - getLength($('#status_content').val()));

    });

    /*
     * 处理评论回复的输入框
     */
    $('.status_comment').live('focus',function(){

        $(this).css('height','60px');
        var index = $('.status_comment').index(this);
        $('.comment_action').eq(index).css('display','block');

    });


    $('.status_comment').live('blur',function(){

        if( $(this).val().length == 0){//如果没有填写文字

            $(this).css('height','25px');
            var index = $('.status_comment').index(this);
            $('.comment_action').eq(index).css('display','none');

        }

    });

    /*
     * 处理取消评论
     */
    $('.cancel_comment').live('click',function(){

        var index = $('.cancel_comment').index(this);
        $('.status_comment').eq(index).val('');
        $('.status_comment').eq(index).blur();

    });

    /*
     * 处理提交评论
     */
    $('.submit_comment').live('click',function(){

        var index = $('.submit_comment').index(this);
        var comment = $('.status_comment').eq(index).val();

        if( comment != ""){

            var feed_id = $('.feed_id').eq(index).attr('name');//获取对应状态的id值

            var to_url = site_url + "ucenter/comment";
            var data = "comment=" + comment + "&fid=" + feed_id;



            $.ajax({//异步提交回复

                "type" : "POST",
                "url" : to_url,
                "data" : data,
                'dataType':'json',
                "success" : function(data){

                    var avatar = "<div class='comment_avatar'>" +
                        "<a href=''><img src='" +site_url + "avatar/get/" + data.uid + "/" + data.md5_nickname + "/30/" + Math.random() + "' height='30' width='30' /></a>" +
                        "</div>";//头像
                    var comment_main = "<div class='comment_main'>" +
                        "<span><a href='" + site_url + "users/" + data.author_nickname + "'  class='reply_nickname'>" + data.author_nickname + "</a></span> : " + comment +
                        "</div> ";
                    var appent_comment = "<div class='comment_item'>" +
                        avatar + comment_main +
                        "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data.feed_id +  "'>回复</a></span></p>" +
                        "<div class='clear'></div>" +
                        "</div> ";

                    $('.comment_container').eq(index).append(appent_comment);//添加该评论项到评论栏

                    $('.comment_item').hover(//添加悬停事件

                        function(){

                            $(this).css('background-color','#f8f8ff');
                            var item_index = $('.comment_item').index(this);
                            $('.reply').eq(item_index).css('display','block');

                        },

                        function(){

                            $(this).css('background-color','white');
                            var item_index = $('.comment_item').index(this);
                            $('.reply').eq(item_index).css('display','none');

                        }

                    );

                    $('.status_comment').eq(index).val('');
                    $('.status_comment').eq(index).blur();


                }

            });


        }

    });


    /*
     * 评论项的悬停效果
     */
    $('.comment_item').hover(//添加悬停事件

        function(){

            $(this).css('background-color','#f8f8ff');
            var item_index = $('.comment_item').index(this);
            $('.reply').eq(item_index).css('display','block');

        },

        function(){

            $(this).css('background-color','');
            var item_index = $('.comment_item').index(this);
            $('.reply').eq(item_index).css('display','none');

        }

    );

    $('.reply a').live('click',function(){

        var feed_id = $(this).attr('name');
        var item_index = $('.reply a').index(this);
        var nickname = $('.reply_nickname').eq(item_index).text();
        $('#textarea_' + feed_id).focus();
        $('#textarea_' + feed_id).val("回复 " + nickname + ": ");



    });


    var counter = 0;

    function load_feed(){//加载新鲜事

        if( counter < 5 ){

            if( is_bottom() ){

                get_more_feed();

            }

        }

    }

    /*
     * 判断是否滑到了底端
     */
    function is_bottom(){

        return ( ( ($(document).height() - $(window).height() ) -$(window).scrollTop() ) <= 50 );

    }


    /*
     * 点击获取更多新鲜事
     */
    $('#more').bind('click', get_more_feed );


    /*
     * 获取新鲜事
     */
    function get_more_feed(){


        var to_url = site_url + 'ucenter/more_feed';
        var offset = Number($('#more').attr('name'));
        var data = "offset=" + offset;

        $('#more').text("正在加载好友动态");

        $.ajax({//异步获取新鲜事

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            'dataType':'json',
            "success" : function(data){

                counter++;

                if( data.length < 5){//判断是否还有动态

                    $('#more').text("没有更多动态了");
                    $('#more').unbind('click');//取消点击事件
                    $(window).unbind('scroll');
                    $(window).bind('scroll',back_to_top_icon);

                }else{

                    offset += 5;
                    $('#more').attr('name',offset);
                    $('#more').text("查看更多动态");

                }

                var length = data.length;

                for(var i = 0;i < length;i++){

                    var content = "<div class='status_item'>" +
                        "<div class='status_avatar'><img src='"+ site_url + "avatar/get/" + data[i].uid + "/" + data[i].md5_nickname + "/50/" + Math.random()  +"' alt='" + data[i].nickname +"' width='50' height='50' class='status_avatar'/></div>"+
                        "<div class='status_main'>" +
                        "<div class='status_main_content'>" +
                        "<span class='status_author'><a href=''>" + data[i].nickname + "</a></span> :" +
                        "<span class='status_message'>" + data[i].message + "</span><br/>" +
                        "</div>" +
                        "<p>" + data[i].create_time;
                    if ( data[i].feed_type == 2 ){

                        content += "</p>";

                    }else{

                        var add_content = "<span class='feed_id' name='" + data[i].feed_id + "' style='display: none'></span>" +
                            "</p>" +
                            "<div class='clear'></div>" +
                            "<div class='comment_container'></div>";

                        if( data[i].reply_num >= 1 ){

                            var first_comment = "<div class='comment_item'>" +
                                "<div class='comment_avatar'> <img src='" + site_url + "avatar/get/" + data[i].first_comment.author_id + "/" + data[i].first_comment.md5_nickname + "/30/" + Math.random() + "' height='30' width='30' /></div>" +
                                "<div class='comment_main'>" +
                                "<a href='' class='reply_nickname'>" + data[i].first_comment.author_nickname + "</a>" + data[i].first_comment.comment +
                                "</div>" +
                                "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data[i].feed_id + "'>回复</a></span></p>" +
                                "<div class='clear'></div>" +
                                "</div>";

                            add_content += first_comment;

                        }

                        if( data[i].reply_num >=2 ){

                            if( data[i].reply_num > 2 ){

                                var more = "<div class='more_comment'>" +
                                    "<a href='javascript:void(0);' name='" + data[i].feed_id + "'>还有" + (data[i].reply_num - 2) + "条回复</a>" +
                                    "</div>" +
                                    "<div id='more_" + data[i].feed_id + "'></div>";

                                add_content += more;

                            }

                            var last_comment = "<div class='comment_item'>" +
                                "<div class='comment_avatar'> <img src='" + site_url + "avatar/get/" + data[i].last_comment.author_id + "/" + data[i].last_comment.md5_nickname + "/30/"+ Math.random() +  "' height='30' width='30' /></div>" +
                                "<div class='comment_main'>" +
                                "<a href='' class='reply_nickname'>" + data[i].last_comment.author_nickname + "</a>" + data[i].last_comment.comment +
                                "</div>" +
                                "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data[i].feed_id + "'>回复</a></span></p>" +
                                "<div class='clear'></div>" +
                                "</div>";

                            add_content += last_comment;

                        }

                        var text = "<div class='comment'>" +
                            "<textarea autocomplete='off' class='status_comment' placeholder='评论...' id='textarea_" + data[i].feed_id + "'></textarea>" +
                            "<div class='comment_action'  style='display: none;'>" +
                            "<a class='cancel_comment' href='javascript:void(0);'>取消</a>&nbsp;&nbsp;" +
                            "<a class='submit_comment' href='javascript:void(0);'>发表</a>" +
                            "</div>" +
                            "</div>";

                        add_content += text;
                        content += add_content;



                    }

                    content +="</div><div class='clear'></div></div>";

                    $('.uc_center_content').append(content);//添加更多新鲜事

                }

                $('.comment_item').hover(//添加悬停事件

                    function(){

                        $(this).css('background-color','#f8f8ff');
                        var item_index = $('.comment_item').index(this);
                        $('.reply').eq(item_index).css('display','block');

                    },

                    function(){

                        $(this).css('background-color','');
                        var item_index = $('.comment_item').index(this);
                        $('.reply').eq(item_index).css('display','none');

                    }

                );


            }

        });

    }



    /*
     * 更多回复
     */
    function more_comment(){

        var feed_id = $(this).attr('name');
        var container = $('#more_'+feed_id);
        var to_url = site_url + 'ucenter/more_comment';
        var data = "fid=" + feed_id;
        var index = $('.more_comment a').index(this);

        $(this).text('正在加载中...');

        $.ajax({//异步获取回复

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            'dataType':'json',
            "success" : function(data){

                var length = data.length;

                for(var i = 0;i < length; i++){

                    var avatar = "<div class='comment_avatar'>" +
                        "<a href=''><img src='" +  site_url + "avatar/get/" + data[i].author_id + "/" + data[i].md5_nickname + "/30/" + Math.random() +  "' height='30' width='30' /></a>" +
                        "</div>";//头像
                    var comment_main = "<div class='comment_main'>" +
                        "<span><a href='" + site_url + "users/" + data[i].author_nickname + "'  class='reply_nickname'>" + data[i].author_nickname + "</a></span> : " + data[i].comment +
                        "</div> ";
                    var appent_comment = "<div class='comment_item'>" +
                        avatar + comment_main +
                        "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data[i].feed_id +  "'>回复</a></span></p>" +
                        "<div class='clear'></div>" +
                        "</div> ";

                    container.append(appent_comment);



                }

                $('.comment_item').hover(//添加悬停事件

                    function(){

                        $(this).css('background-color','#f8f8ff');
                        var item_index = $('.comment_item').index(this);
                        $('.reply').eq(item_index).css('display','block');

                    },

                    function(){

                        $(this).css('background-color','');
                        var item_index = $('.comment_item').index(this);
                        $('.reply').eq(item_index).css('display','none');

                    }

                );

                $('.more_comment').eq(index).hide();

            }


        });


    }

    /*
     * 展开更多回复
     */
    $('.more_comment a').live('click',more_comment);


    /*
     * 回到顶部按钮操 作
     */
    $('div#back-to-top').hide();

    $(window).bind('scroll',function(){

        back_to_top_icon();//回到顶部按钮
        load_feed();//加载新鲜事

    });

    function back_to_top_icon(){

        if( $(window).scrollTop() > 200 ){

            $('div#back-to-top').fadeIn(500);

        }
        else{

            $('div#back-to-top').fadeOut(500);
        }

    }

    $('div#back-to-top').addClass('out_hover');

    $('div#back-to-top').hover(

        function(){

            $(this).removeClass('out_hover');
            $(this).addClass('in_hover');

        },

        function(){

            $(this).removeClass('in_hover');
            $(this).addClass('out_hover');

        }

    );

    $('div#back-to-top').bind('click',function(event){

        $('body,html').animate({scrollTop:0},300);
        return false;

    });


    /*
     * 展开回复
     */
    function fold(){

        var index = $('.unfold_comment a').index(this);
        var feed_id = $('.feed_id').eq(index).attr('name');//获取对应状态的id值

        var to_url = site_url + "ucenter/all_comment";
        var data = "fid=" + feed_id;

        $('.comment_container').eq(index).html('');//清除之前的回复
        $('.comment_container').eq(index).show();//显示回复

        $.ajax({//异步获取回复内容

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            'dataType':'json',
            "success" : function(data){

                var length = data.length;
                for(var i = 0;i < length;i++){

                    var avatar = "<div class='comment_avatar'>" +
                        "<a href=''><img src='" + site_url + "avatar/get/" + data[i].author_id + "/" + data[i].md5_nickname + "/30/" + Math.random() +  "' height='30' width='30' /></a>" +
                        "</div>";//头像
                    var comment_main = "<div class='comment_main'>" +
                        "<span><a href='" + site_url + "users/" + data[i].author_nickname + "'  class='reply_nickname'>" + data[i].author_nickname + "</a></span> : " + data[i].comment +
                        "</div> ";
                    var appent_comment = "<div class='comment_item'>" +
                        avatar + comment_main +
                        "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data[i].feed_id +"'>回复</a></span></p>" +
                        "<div class='clear'></div>" +
                        "</div> ";
                    $('.comment_container').eq(index).append(appent_comment);//添加该评论项到评论栏

                    $('.comment_item').hover(//添加悬停事件

                        function(){

                            $(this).css('background-color','#f8f8ff');
                            var item_index = $('.comment_item').index(this);
                            $('.reply').eq(item_index).css('display','block');

                        },

                        function(){

                            $(this).css('background-color','');
                            var item_index = $('.comment_item').index(this);
                            $('.reply').eq(item_index).css('display','none');

                        }

                    );


                }

                if( i != 0 ){//回复数不为零

                    $('.unfold_comment a').eq(index).text('回复(' + i + ')');

                }

            }

        });

        return false;

    }

    /*
     * 收起回复
     */
    function unfold(){

        var index = $('.unfold_comment a').index(this);
        $('.comment_container').eq(index).html('');//显示回复

    }


    /*
     * 展开所有回复
     */
    $('.unfold_comment a').toggle( fold,unfold );



    /*
     * 异步上传头像到服务器
     */
    $('#upload_avatar_form').ajaxForm({

        dataType:'json',
        success:function(data){

            if( data.error ){

                $('#upload_error').css('display','block');//显示上传错误信息

            }else{

                $('#upload_error').css('display','none');
                $('#re_choose').css('display','block');

                $('#upload_avatar_btn').hide();//隐藏上传按钮

                $('#preview_1').attr("src",site_url + "static/uploads/" + data.file_name + "?r="+Math.random());//预览图1
                $('#preview_1').css('display','block');

                $('#preview_2').attr("src",site_url + "static/uploads/" + data.file_name + "?r="+Math.random());//预览图2
                $('#preview_2').css('display','block');

                $('#preview_3').attr("src",site_url + "static/uploads/" + data.file_name + "?r="+Math.random());//预览图3
                $('#preview_3').css('display','block');

                $('#avatar_tmp').attr("width",data.image_width);
                $('#avatar_tmp').attr("height",data.image_height);
                $('#avatar_tmp').attr("src",site_url + "static/uploads/" + data.file_name + "?r="+Math.random());//图片在服务器的临时地址
                $('#avatar_tmp').css('display','block');
                $('#avatar_tmp').ready(function(){

                    $('#avatar_tmp').Jcrop({
                        setSelect: [ 10, 10, 200, 200 ],
                        onChange: update_preview,
                        onSelect: update_preview,
                        aspectRatio: 1
                    },function(){
                        // Use the API to get the real image size
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];
                        // Store the API in the jcrop_api variable
                        jcrop_api = this;
                    });

                    $('#btn_saves').show();
                });

            }

        }

    });

    $('#upload_avatar_form').ajaxStart(function(){//头像上传中

        $('#upload_avatar_btn').val('正在上传，请稍后...');
        $('#upload_avatar_btn').attr('disabled',true);

    });

    $("#upload_avatar_form").ajaxComplete(function(event,request, settings){

        $('#upload_avatar_btn').val('上传');
        $('#upload_avatar_btn').attr('disabled',false);

    });


    var jcrop_api, boundx, boundy;
    /*
     * 实时更新小预览图
     */
    function update_preview(c){

        function preview(size,id){

            var rx = size / c.w;
            var ry = size / c.h;

            $(id).css({

                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'

            });

        }

        if (parseInt(c.w) > 0){

            preview(150,"#preview_1");
            preview(50,"#preview_2");
            preview(30,"#preview_3");

            $('#img_left').val(c.x);
            $('#img_top').val(c.y);
            $('#img_width').val(c.w);
            $('#img_height').val(c.h);

        }
    }


    /*
     * 保存选中区域
     */
    $('#btn_save_region').bind('click',function(){

        var data = 'left='+$("#img_left").val()+'&top='+$("#img_top").val()+'&width='+$("#img_width").val()+'&height='+$("#img_height").val();
        var to_url = site_url + 'accounts/settings/save_avatar';

        $.ajax({

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            "success" : function(data){

                alert("头像更新成功");
                location.reload();

            }

        });

    });


    /*
     * 取消保存头像
     */
    $('#btn_save_cancel').bind('click',function(){

       location.reload();

    });

    /*
     * 级联显示地区
     */
    $('#home_province').bind('change',show_city );
    $('#live_province').bind('change',show_city);

    function show_city(){

        if( $(this).attr('class') == "home" ){

            var select_city = $('#home_city');

        }else{

            var select_city = $('#live_city');

        }


        if( $(this).val() == "0" ){

            select_city.empty();
            select_city.css('display','none');

        }else{

            var to_url = site_url + "ucenter/admin/get_city";
            var data = "id=" + $(this).val();


            $.ajax({

                "type" : "POST",
                "url" : to_url,
                "data" : data,
                "dataType" : "json",
                "success" : function(data){

                    select_city.css('display','');
                    select_city.empty();//清空之前的选项

                    select_city.append("<option value='0'>不限</option> ")

                    var length = data.length;

                    for(var i = 0;i < length;i++){

                        select_city.append("<option value='" + data[i].id + "'>" + data[i].name  + "</option>")

                    }


                }

            });

        }

    }


});
