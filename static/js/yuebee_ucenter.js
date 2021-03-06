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
     * 点击添加关注
     */
    $('.add_follow_link').live('click',function(){

        var follow_uid = $(this).attr('name'); //接受方id
        var data = "follow_uid=" + follow_uid;
        var to_url = site_url + 'users/add_follow';

        var item_index = $('.add_follow_link').index(this);
        var block = $('.follow').eq(item_index);

        block.html("处理中...");

        $.ajax({//异步发送关注信息

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            "success" : function(data){

                block.attr('class','followed');

                var show_text = "正在关注";
                if( data == 1 ){

                    show_text = "互相关注";

                }
                block.html(

                    "<a href='javascript:void(0);' class='cancel_follow' name='" + follow_uid + "'>" +
                    "<span class='follow_main_text'>" + show_text + "</span>" +
                    "<span class='follow_hover_text'>取消关注</span></a>"

                );

                $('.cancel_follow').hover(

                    function(){

                        $(this).find('.follow_main_text').hide();
                        $(this).find('.follow_hover_text').show();

                    },
                    function(){

                        $(this).find('.follow_main_text').show();
                        $(this).find('.follow_hover_text').hide();

                    }


                );

            }

        });


    });

    /*
     * 已关注的悬浮效果
     *
     * 悬浮后出现‘取消关注’字样
     *
     */
    $('.cancel_follow').hover(

        function(){

            $(this).find('.follow_main_text').hide();
            $(this).find('.follow_hover_text').show();

        },
        function(){

            $(this).find('.follow_main_text').show();
            $(this).find('.follow_hover_text').hide();

        }


    );


    /*
     * 处理取消关注
     */
    $('.cancel_follow').live('click',function(){

        var item_index = $('.add_follow_link').index(this);
        var block = $('.followed').eq(item_index);

        block.html("处理中...");

        var follow_uid = $(this).attr('name');
        var to_url = site_url + "users/cancel_follow";
        var data = "follow_uid=" + follow_uid;

        $.ajax({//异步取消关注

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            "success" : function(data){

                block.attr('class','follow');
                block.html("<a href='javascript:void(0);' name='" + follow_uid + "' class='add_follow_link'><span><b>+</b> 加关注</span></a>");

            }

        });

    });


    /*
     * 状态发布框的获得焦点事件
     *
     * 出现发布按钮
     *
     */
    $('#feed_textarea').focus(function(){

       $('#status_action').show();

    });

    $('#feed_textarea').blur(function(){

       if( $(this).val() == "" ){

           $('#status_action span').text('');
           $('#status_action').hide();

       }

    });

    /*
     * 点击发布状态
     */
    $('#publish_status').bind('click',function(){

        var content = $('#feed_textarea').val();
        var length = getLength(content);//取得状态的字数
        if( length < 1 || length >240 ){

            $('#status_action span').addClass('error_msg');
            $('#status_action span').text('字数须在1－240之间');


        }else{

            var to_url = site_url + "ucenter/publish_status";
            var data = "content=" + content;

            $.ajax({//异步发布状态

                "type" : "POST",
                "url" : to_url,
                "data" : data,
                "success" : function(data){

                    $('#status_action span').removeClass('error');
                    $('#status_action span').text('发布成功!');
                    $('#feed_textarea').val('');

                }

            });


        }



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

        $(window).unbind('scroll');

        $(window).bind('scroll',function(){

            back_to_top_icon();//回到顶部按钮

        });

        $.ajax({//异步获取新鲜事

            "type" : "POST",
            "url" : to_url,
            "data" : data,
            'dataType':'json',
            "success" : function(data){

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
                            "<div class='comment_container'>";

                        if( data[i].reply_num >= 1 ){

                            var first_comment = "<div class='comment_item'>" +
                                "<div class='comment_avatar'> <img src='" + site_url + "avatar/get/" + data[i].first_comment.author_id + "/" + data[i].first_comment.md5_nickname + "/30/" + Math.random() + "' height='30' width='30' /></div>" +
                                "<div class='comment_main'>" +
                                "<a href='" + site_url + "users/" + data[i].first_comment.author_id + "/" + data[i].first_comment.author_nickname +"' class='reply_nickname'>" + data[i].first_comment.author_nickname + "</a>" + data[i].first_comment.comment +
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
                                "<a href='" + site_url + "users/" + data[i].last_comment.author_id + "/" + data[i].last_comment.author_nickname +"' class='reply_nickname'>" + data[i].last_comment.author_nickname + "</a>" + data[i].last_comment.comment +
                                "</div>" +
                                "<p><span class='reply' style='float:right;display: none;'><a href='javascript:void(0);' name='" + data[i].feed_id + "'>回复</a></span></p>" +
                                "<div class='clear'></div>" +
                                "</div></div>";

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

                counter++;

                if( data.length < 5){//判断是否还有动态

                    $('#more').text("没有更多动态了");
                    $('#more').unbind('click');//取消点击事件

                }else{

                    offset += 5;
                    $('#more').attr('name',offset);
                    $('#more').text("查看更多动态");

                    $(window).bind('scroll',function(){

                        back_to_top_icon();//回到顶部按钮
                        load_feed();//加载新鲜事

                    });

                }

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
                        "<span><a href='" + site_url + "users/" + data[i].author_id + "/" + data[i].author_nickname + "'  class='reply_nickname'>" + data[i].author_nickname + "</a></span> : " + data[i].comment +
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
                        "<a href='" + site_url + "users/" + data[i].author_id + "/" + data[i].author_nickname + "'><img src='" + site_url + "avatar/get/" + data[i].author_id + "/" + data[i].md5_nickname + "/30/" + Math.random() +  "' height='30' width='30' /></a>" +
                        "</div>";//头像
                    var comment_main = "<div class='comment_main'>" +
                        "<span><a href='" + site_url + "users/" + data[i].author_id + "/" + data[i].author_nickname + "'  class='reply_nickname'>" + data[i].author_nickname + "</a></span> : " + data[i].comment +
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


});
