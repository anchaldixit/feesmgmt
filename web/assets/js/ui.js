/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Loader() {

}

$.extend(Loader.prototype, {
    init: function () {
        win_height = $(window).height();


    },
    show: function () {
        that = this;
        $('.wrapper').css({height: '0px', overflow: 'hidden'});

    },
    hide: function () {
        $('.wrapper').removeAttr('style');

    }
});

function Login() {

}

$.extend(Login, {
    ajaxLink: window.location.origin + '/api/v1/general',
    ajaxLink2: window.location.origin + '/api/v1'
});

$.extend(Login.prototype, {
    init: function () {
        var that = this;
        that.bindForgetPasswordAction();
        that.flipForm();
        that.featureSlider();
        that.openMenu();
        if($('#mypreferences').length){
            that.updatePreferences();
        }
        if($('#change_password').length){
            that.changePassword();
        }
    },
    bindForgetPasswordAction: function () {
        var that = this;
        $('#forget_password_btn').click(function () {
            var field_validated = that.fieldValidate($('#forget_password_textbox'), 'email');

            if (field_validated === true) {
                that.getForgetPassword($('#forget_password_textbox').val());
            }
        });
    },
    featureSlider: function(){
        if($('.feature-list').length){
            var li_width = 30;
            $('.feature-list ul li').each(function(){
                li_width = li_width + $(this).outerWidth();
            });
            $('.feature-list ul').css('width',li_width+'px');
            $('.next').click(function(){
                
                var diff = $('.feature-list ul').width() - $(window).width();
                //alert('next'+diff);
                if(diff > 0){
                    $('.feature-list ul').animate({'left':'-'+diff+'px'},500);
                }
            });
            $('.prev').click(function(){
                
                var diff = $('.feature-list ul').width() - $(window).width();
                var pos = 0;
                if(diff > 0){
                    var left_pos = $('.feature-list ul').css('left');
                    left_pos = parseInt(left_pos);
                    
                    if(left_pos == 0){
                        pos = left_pos;
                    }
                    else{
                        pos = diff + left_pos;
                    }
                    $('.feature-list ul').animate({'left':'+'+pos+'px'},500);
                }
            });
        }
    },
    getForgetPassword: function (_val) {
        var obj = {
            head: {
                action: "forgetPassword"
            },
            body: {
                email: _val
            }
        };
        var str = JSON.stringify(obj);
        $.ajax({
            url: Login.ajaxLink,
            method: 'post',
            dataType: 'json',
            data: str,
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (res) {
                var msg = '';

                $('#loader').hide();
                if (res.head.status === "success") {
                    $('#forget_password_textbox').val('');
                    msg = '<span class="msg">An activation link has been sent to your registered email</span>';
                }
                $('.validation_msg').html('');
                $('#valid_error').html('');
                $('#valid_error').html(msg);
            },
            error: function (err) {
                var error = '';
                $('#loader').hide();
                obj = jQuery.parseJSON(err.responseText);

                if (obj.head.status === 'error') {
                    error = '<span class="error_msg">' + obj.body.error_msg + '</span>';
                }
                $('#valid_error').html('');
                $('#valid_error').html(error);
            }
        });

    },
    updatePreferences : function (){
        $('#update_preferences').click(function(){
            var _fname = $.trim($('#full_name_text').val());
            var error = 'Name field can not be empty';
            if(_fname == ''){
                $('.validation_msg').html(error);
                $('.validation_msg').show();
            }
            else{
                var obj = {
                        head: {
                            action: "changePreference"
                        },
                        body: {
                            name: _fname
                        }
                    };
                var _str = JSON.stringify(obj);
                $.ajax({
                    url: Login.ajaxLink2,
                    method: 'post',
                    dataType: 'json',
                    data: _str,
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function(res){
                        var msg = '';
                        $('#loader').hide();
                        if (res.head.status === "success") {
                            msg = '<span class="msg">Your name has been successfully updated</span>';
                        }
                        $('.validation_msg').html('');
                        $('#valid_error').html('');
                        $('#valid_error').html(msg);
                    },
                    error: function(err){
                        var error = '';
                        $('#loader').hide();
                        obj = jQuery.parseJSON(err.responseText);

                        if (obj.head.status === 'error') {
                            error = '<span class="error_msg">' + obj.body.error_msg + '</span>';
                        }
                        $('#valid_error').html('');
                        $('#valid_error').html(error);
                    }
                });   
            }
        });
    },
    changePassword: function(){
        $('#change_password_btn').click(function(){
            
            var error = '';
            var _oldPassword = $('#old_password').val();
            var _newPassword = $('#new_password').val();
            var _renewPassword = $('#re_new_password').val();
            $('#valid_error').html('');
            $('.validation_msg').html('');
            $('.validation_msg2').html('');
            if(_oldPassword == ''){
                error = 'Old Password field can not be empty';
                $('.validation_msg').html(error);
                $('.validation_msg').show();
            }
            else if(_newPassword !==  _renewPassword){
                $('.validation_msg2').html('Retype password is not matching');
                $('.validation_msg2').show();
            }
            else if(_newPassword == '' || _renewPassword == ''){
                $('.validation_msg2').html('New password fields can not empty');
                $('.validation_msg2').show();
            }
            else{
                $('.validation_msg2').html('');
                $('.validation_msg').html('');
                
                var obj = {
                        head: {
                            action: "changePassword"
                        },
                        body: {
                            old_password: _oldPassword,
                            new_password: _renewPassword
                        }
                    };
                var _str = JSON.stringify(obj);
                $.ajax({
                    url: Login.ajaxLink2,
                    method: 'post',
                    dataType: 'json',
                    data: _str,
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function(res){
                        var msg = '';
                        $('#loader').hide();
                        if (res.head.status === "success") {
                            msg = '<span class="msg">Your password has been successfully updated</span>';
                        }
                        $('.validation_msg').html('');
                        $('#valid_error').html('');
                        $('#valid_error').html(msg);
                        setTimeout(function(){
                            window.location.href = 'http://'+window.location.hostname+'/login';
                        },1000);
                        
                    },
                    error: function(err){
                        var error = '';
                        $('#loader').hide();
                        obj = jQuery.parseJSON(err.responseText);
                        
                        if (obj.head.status === 'error') {
                            error = '<span class="error_msg">' + obj.body.error_msg + '</span>';
                        }
                        $('#valid_error').html('');
                        $('#valid_error').html(error);
                    }
                }); 
            }
            
            
        });
    },
    fieldValidate: function (valobj, field) {

        var that = this;
        var error = '';
        var flag = true;
        var _val = valobj.val();
        if (field == 'email') {
            if (_val == '') {

                error = 'Field email can not be empty';
                valobj.next('.validation_msg').html();
                valobj.next('.validation_msg').html(error);
                valobj.next('.validation_msg').show();
                flag = false;
            }
            else if (that.isEmail(_val) === false) {

                error = 'Please enter a valid email';
                valobj.next('.validation_msg').html();
                valobj.next('.validation_msg').html(error);
                valobj.next('.validation_msg').show();
                flag = false;
            }

        }
        return flag;

    },
    isEmail: function (email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    },
    flipForm: function () {
        if ($('.flip').length) {
            $('.flip').click(function () {
                $('.card').toggleClass('flipped');
                return false;
            });
        }
    },
    openMenu: function(){
        if($('.open-menu').length){
            $('.open-menu').click(function(){
                var id = $(this).attr('href');
                $(id).slideToggle();
                return false;
            });
        }
    }
});

$(document).ready(function () {
    
    login = new Login();
    login.init();
});




