/*
 * 一些全局变量
 */
var site_url = "http://localhost/test/yuebee/";
var avatar_path = site_url + 'static/img/avatar/default.jpg';


/*
 * 判断密码强度
 */
function getPasswordStrength(password){

    return 0
        // if password bigger than 5 give 1 point
        + +( password.length > 5 )
        // if password has both lower and uppercase characters give 1 point
        + +( /[a-z]/.test(password) && /[A-Z]/.test(password) )
        // if password has at least one number and at least 1 other character give 1 point
        + +( /\d/.test(password) && /\D/.test(password) )
        // if password has a combination of other characters and special characters give 1 point
        + +( /[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/.test(password) && /\w/.test(password) )
        // if password bigger than 12 give another 1 point (thanks reddit)
        + +( password.length > 12 )
}

/*
 *  点击改变验证码的值
 */
function change_code(){

    document.getElementById("code_img").src = site_url + "show_captcha/index/" + Math.random();

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
    /*--------------------------------------*\
                     注册模块
    \*--------------------------------------*/



    /*
     * 检查邮箱有效性
     */
    $('#email').blur(function(){


        var email_error_msg = $('#email_error_msg');
        var email = $.trim($(this).val());
        var email_pn = /^[0-9a-z_][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}\.){1,4}[a-z]{2,4}$/;//邮箱地址正则表达式
        //var email_pn = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;

        email_error_msg.addClass('error_msg');

        if( email.length == 0 ){

            email_error_msg.text('邮箱不能为空');

        }else if( ! email_pn.exec( email ) ){

            email_error_msg.text('邮箱格式不正确');

        }else{

            var data = "target=email&email=" + email;//传输数据
            var to_url = site_url + "accounts/register/check" ;

            $.ajax({//异步传输email到服务器端验证
                "type" : "POST",
                "url" : to_url,
                "data" : data,
                "success" : function(data){

                    if( data == "0"){

                        email_error_msg.removeClass('error_msg');

                        email_error_msg.text("邮箱可以使用");

                    }

                    if( data == "1"){

                        email_error_msg.text("邮箱已被注册");

                    }

                }

            });
        }

    });

    /*
     * 检查昵称有效性
     *
     * 1-16位的中英文、数字或_
     *
     */
    $('#nickname').blur(function(){

        var nickname_error_msg = $('#nickname_error_msg');
        var nickname_pn = /^[0-9a-zA-Z\u4e00-\u9fa5_]*$/;
        nickname_error_msg.addClass('error_msg');


        var nickname = $.trim($('#nickname').val());
        var length = nickname.length;

        if( length == 0){//昵称为空

            nickname_error_msg.text('请填写昵称');

        }else{

            if( ! ( length >= 1 && length <= 16 ) ){//昵称格式

                nickname_error_msg.text('昵称为1-16个字符');

            }else{

                if( nickname_pn.exec( nickname )){

                    var data = "target=nickname&nickname=" + nickname;//传输数据
                    var to_url = site_url + "accounts/register/check" ;

                    $.ajax({//异步传输email到服务器端验证
                        "type" : "POST",
                        "url" : to_url,
                        "data" : data,
                        "success" : function(data){

                            if( data == "0"){

                                nickname_error_msg.removeClass('error_msg');
                                nickname_error_msg.text("昵称可以使用");

                            }

                            if( data == "1"){

                                nickname_error_msg.text("昵称已被使用");

                            }

                        }

                    });

                }else{

                    nickname_error_msg.text('昵称为1－16位的中英文、数字或_');

                }

            }
        }

    });

    /*
     * 即时判断密码强度
     */
    $('#reg_password').bind( 'keyup' , function(){

        $('#password_error_msg').removeClass('error_msg');

        var pass = $(this).val();
        var strength = getPasswordStrength(pass);
        var text = new Array();
        var show_text;

        text[0] = "弱";//密码强度组
        text[1] = "中";
        text[2] = "强";
        text[3] = "极强";

        if( pass.length > 0 ){
            if( strength == 0){

                show_text = text[0];

            }else if( strength == 1 ){

                show_text = text[1];

            }else if( 2 <= strength && strength <= 4 ){

                show_text = text[2];

            }
            else if( strength == 5 ){

                show_text = text[3];
            }

            $('#password_error_msg').text("密码强度:" + show_text);
        }

    });

    /*
     * 检查输入密码
     */
    $('#reg_password').blur(function(){


        var pwd = $(this).val();
        var p_length = pwd.length;//取得密码长度,密码长度需不少于6位
        var password_error_msg = $('#password_error_msg');


        if( p_length == 0 ){

            password_error_msg.addClass('error_msg');
            password_error_msg.text('密码不能为空');

        }else{

            if( p_length < 6 ){

                password_error_msg.addClass('error_msg');
                password_error_msg.text('密码长度不能小于6位');

            }
        }
    });

    /*
     * 检查两次输入的密码是否相同
     */
    $('#reg_password2').blur(function(){

        var password2 = $(this).val();
        var password = $('#reg_password').val();
        var p2_length = password2.length;
        var password2_error_msg = $('#password2_error_msg');

        if( p2_length == 0 ){//如果确认密码为空

            if( password.length != 0 ){//如果第一次输入密码不为空，则显示错误信息

                password2_error_msg.addClass('error_msg');
                password2_error_msg.text('请确认密码');
            }

        }else{

            if( password2 != password ){

                password2_error_msg.addClass('error_msg');
                password2_error_msg.text('两次输入的密码不一致');

            }else{

                password2_error_msg.removeClass('error_msg');
                password2_error_msg.text('正确');
            }

        }

    });

    /*
     * 检查验证码是否输入正确
     */
    $('#code').blur(function(){

        var code_error_msg = $('#code_error_msg');
        var code = $.trim($(this).val());

        code_error_msg.addClass('error_msg');

        if( code.length == 0){

            code_error_msg.text('请输入验证码');

        }else {

            var data = "target=captcha&captcha=" + code;
            var to_url = site_url + "accounts/register/check";

            $.ajax({//异步传输验证码到服务器端验证

                "type" : "POST",
                "url" : to_url,
                "data" : data,
                "success" : function(data){

                    if( data == "0"){

                        code_error_msg.removeClass('error_msg');
                        code_error_msg.text("验证码正确");
                    }

                    if( data == "1"){

                        code_error_msg.text("验证码输入错误");
                    }

                    if( data == "2"){

                        code_error_msg.text("验证码已过期");
                    }

                }

            });
        }


    });

    $('#reg_form').submit(function (){//提交注册

        event.preventDefault();

        if( $.trim($('#email').val()) == "" ){//邮箱为空

            $('#email_error_msg').addClass('error_msg');
            $('#email_error_msg').text('邮箱不能为空');
            $('#email').focus();

            return false;
        }

        if( $.trim($('#nickname').val()) == "" ){//昵称为空

            $('#nickname_error_msg').addClass('error_msg');
            $('#nickname_error_msg').text("请填写昵称");
            $('#nickname').focus();

            return false;
        }

        if( $('#reg_password').val() == "") {//密码为空

            $('#password_error_msg').addClass('error_msg');
            $('#password_error_msg').text('密码不能为空');
            $('#reg_password').focus();

            return false;
        }

        if( $('#reg_password2').val() != $('#reg_password' ).val()){//两次输入的密码不一致

            $('#password2_error_msg').addClass('error_msg');
            $('#password2_error_msg').text('两次输入的密码不一致');
            $('#reg_password2').focus();

            return false;
        }

        if( $.trim($('#code').val()) == "" ){//验证码为空

            $('#code_error_msg').addClass('error_msg');
            $('#code_error_msg').text('请输入验证码');
            $('#code').focus();

            return false;
        }
    });

    /*--------------------------------------*\
                     登录模块
    \*--------------------------------------*/


    /*
     * 提效表单进行的操作
     */
    $('#login_frm').submit(function(){

        //event.preventDefault();

        $('#login_email_msg').text("");//先清空之前的错误信息
        $('#login_pwd_msg').text("");

        var email = $.trim($('#login_email').val());//trim后的email
        var password = $('#login_pwd').val();

        if( email.length == 0 ){//邮箱为空

            $('#login_email_msg').text("请输入Email地址");

            $('#login_email').focus();

            return false;
        }

        if( password.length == 0 ){//密码为空

            $('#login_pwd_msg').text("请输入密码");

            $('#login_pwd').focus();

            return false;

        }

    });


    /*--------------------------------------*\
                  忘记密码模块
    \*--------------------------------------*/

    $('#forget_pwd_1').submit(function(){

        var pwd_email = $('#pwd_email');
        var email = $.trim(pwd_email.val());
        var pwd_email_error = $('#pwd_email_error');

        if( email.length == 0 ){

            pwd_email_error.text('请输入注册邮箱');
            pwd_email.focus();
            return false;

        }

    });

    $('#forget_pwd_3').submit(function(){

        var password = $('#forget_pwd');//input
        var password2 = $('#forget_pwd_2');

        var pwd_msg = $('#forget_pwd_msg');//错误信息
        var pwd2_msg = $('#forget_pwd2_msg');

        pwd_msg.text('');
        pwd2_msg.text('');//清空错误信息

        if( password.val() == "" ){//密码为空

            pwd_msg.text('请输入密码');
            password.focus();

            return false;

        }

        if( password.val().length < 6){

            pwd_msg.text('密码不能少于6位');
            password.focus();

            return false;

        }

        if( password2.val() == "" ){//确认蜜码为空

            pwd2_msg.text('请确认密码');
            password2.focus();

            return false;
        }

        if( password.val() != password2.val()){//两次密码不一致

            pwd2_msg.text('两次输入的密码不一致');
            return false;
        }

    });

    /*
     * 回到顶部按钮操 作
     */
    $('div#back-to-top').hide();

    $(window).bind('scroll',function(){

        if( $(window).scrollTop() > 200 ){

            $('div#back-to-top').fadeIn(500);

        }
        else{

            $('div#back-to-top').fadeOut(500);
        }

    });

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


});
