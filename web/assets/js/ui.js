/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Login() {
}

function User() {
}

function Role() {
}

function Permission() {
}

$.extend(Login, {
    ajaxLink: window.location.origin + '/api/v1/general',
    ajaxLink2: window.location.origin + '/api/v1',
    role: new Role(),
    user: new User()
});

$.extend(Login.prototype, {
    init: function () {
        var that = this;
        that.bindForgetPasswordAction();
        that.flipForm();
        that.openMenu();
        if ($('#mypreferences').length) {
            that.updatePreferences();
        }
        if ($('#change_password').length) {
            that.changePassword();
        }
        if ($('#registration').length) {
            that.registration();
        }
        if ($('#reset_password').length) {
            that.resetPassword();
        }
    },
    getForgetPassword: function (_val) {
        var that = this;
        var obj = {
            head: {
                action: "forgetPassword"
            },
            body: {
                email: _val
            }
        };
        var _obj = JSON.stringify(obj);
        var ajaxLink = Login.ajaxLink;
        Login.user.getAjaxData(ajaxLink, _obj, function (_data) {

            var msg = '';
            $('#loader').hide();
            if (_data.head.status === "success") {
                $('#forget_password_textbox').val('');
                msg = '<span class="msg">An activation link has been sent to your registered email</span>';
            }
            $('.validation_msg').html('');
            $('#valid_error').html('');
            $('#valid_error').html(msg);
        });
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
    flipForm: function () {
        if ($('.flip').length) {
            $('.flip').click(function () {
                $('.card').toggleClass('flipped');
                return false;
            });
        }
    },
    openMenu: function () {
        if ($('.open-menu').length) {
            $('.open-menu').click(function () {
                var id = $(this).attr('href');
                $(id).slideToggle();
                return false;
            });
        }
    },
    updatePreferences: function () {
        var that = this;
        $('#update_preferences').click(function () {
            var _fname = $.trim($('#full_name_text').val());
            var error = 'Name field can not be empty';
            if (_fname == '') {
                $('.validation_msg').html(error);
                $('.validation_msg').show();
            }
            else {
                var obj = {
                    head: {
                        action: "changePreference"
                    },
                    body: {
                        name: _fname
                    }
                };
                var _obj = JSON.stringify(obj);
                var ajaxLink = Login.ajaxLink2;
                Login.user.getAjaxData(ajaxLink, _obj, function (_data) {

                    var msg = '';
                    $('#loader').hide();
                    if (_data.head.status === "success") {
                        msg = '<span class="msg">Your name has been successfully updated</span>';
                    }
                    $('.validation_msg').html('');
                    $('#valid_error').html('');
                    $('#valid_error').html(msg);

                });
            }
        });
    },
    changePassword: function () {
        var that = this;
        $('#change_password_btn').click(function () {

            var error = '';
            var _oldPassword = $('#old_password').val();
            var _newPassword = $('#new_password').val();
            var _renewPassword = $('#re_new_password').val();
            $('#valid_error').html('');
            $('.validation_msg').html('');
            $('.validation_msg2').html('');
            if (_oldPassword == '') {
                error = 'Old Password field can not be empty';
                $('.validation_msg').html(error);
                $('.validation_msg').show();
            }
            else if (_newPassword !== _renewPassword) {
                $('.validation_msg2').html('Retype password is not matching');
                $('.validation_msg2').show();
            }
            else if (_newPassword == '' || _renewPassword == '') {
                $('.validation_msg2').html('New password fields can not empty');
                $('.validation_msg2').show();
            }
            else {
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
                var _obj = JSON.stringify(obj);
                var ajaxLink = Login.ajaxLink2;
                Login.user.getAjaxData(ajaxLink, _obj, function (_data) {
                    var msg = '';
                    $('#loader').hide();
                    if (_data.head.status === "success") {
                        msg = '<span class="msg">Your password has been successfully updated</span>';
                    }
                    $('.validation_msg').html('');
                    $('#valid_error').html('');
                    $('#valid_error').html(msg);
                    setTimeout(function () {
                        window.location.href = 'http://' + window.location.hostname + '/login';
                    }, 1000);
                });
            }
        });
    },
    registration: function () {
        var that = this;
        var error = '';
        var name = '';
        var passw = '';
        var errDiv = '';
        var re_passw = '';

        $('#user_register').click(function () {
            $('.validation_msg').html('');
            name = $('#full_name_text').val();
            passw = $('#password').val();
            re_passw = $('#re_password').val();
            if (name == '') {

                error = 'Name Field can be empty';
                errDiv = $('#full_name_text').next('.validation_msg');
                errDiv.html(error);
            }
            else if (passw == '') {
                error = 'Password Field can be empty';
                errDiv = $('#password').next('.validation_msg');
                errDiv.html(error);
            }
            else if (re_passw == '') {
                error = 'Retype Password Field can be empty';
                errDiv = $('#re_password').next('.validation_msg');
                errDiv.html(error);
            }
            else if (passw != re_passw) {
                error = 'Retype Password is not matching';
                errDiv = $('#re_password').next('.validation_msg');
                errDiv.html(error);
            }
            else {
                var obj = {
                    head: {
                        action: "registerUser"
                    },
                    body: {
                        verification_id: emailVerifyId,
                        name: name,
                        password: passw
                    }
                }
                var _obj = JSON.stringify(obj);
                Login.user.getAjaxData(Login.ajaxLink2, _obj, function () {
                    window.location.href = 'http://' + window.location.hostname + '/login?new_registration=1';
                });
            }

        });
    },
    resetPassword: function () {
        var that = this;
        var error = '';
        var flag = true;

        $('#reset_password_btn').click(function () {
            var new_pass = $('#reset_new_password').val();
            var re_new_pass = $('#reset_re_new_password').val();

            if ($.trim(new_pass) == '') {
                error = 'Password can not empty';
                var pass = $('#reset_new_password');
                var errDiv = pass.next('.validation_msg2');
                errDiv.html(error);
            }
            else if ($.trim(re_new_pass) == '') {
                error = 'Retype Password can not empty';
                var pass = $('#reset_re_new_password');
                var errDiv = pass.next('.validation_msg2');
                errDiv.html(error);
            }
            else if (new_pass != re_new_pass) {
                error = 'ReType Password is not matching';
                var pass = $('#reset_re_new_password');
                var errDiv = pass.next('.validation_msg2');
                errDiv.html(error);
            }
            else {
                var obj = {
                    head: {
                        action: "resetPassword"
                    },
                    body: {
                        "reset_password_id": resetId,
                        "new_password": new_pass
                    }
                }
            }
            var _obj = JSON.stringify(obj);
            Login.user.getAjaxData(Login.ajaxLink, _obj, function () {
                window.location.href = 'http://' + window.location.hostname + '/login?reset_pass=1';
            });

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
    }

});

$.extend(User, {
    ajaxLink2: window.location.origin + '/api/v1',
    roles: ['Registered', 'Unregistered', 'Unverified', 'Deactivated', 'Denied', 'Password Reset'],
    role: new Role(),
    login: new Login()
});

$.extend(User.prototype, {
    init: function () {
        var that = this;

        User.role.init();
        User.login.init();
        that.featureSlider();
        if ($('#userList').length) {
            that.createUserPage();
        }

    },
    featureSlider: function () {
        if ($('.feature-list').length) {
            var li_width = 30;
            $('.feature-list ul li').each(function () {
                li_width = li_width + $(this).outerWidth();
            });
            $('.feature-list ul').css('width', li_width + 'px');
            $('.next').click(function () {

                var diff = $('.feature-list ul').width() - $(window).width();
                if (diff > 0) {
                    $('.feature-list ul').animate({'left': '-' + diff + 'px'}, 500);
                }
            });
            $('.prev').click(function () {

                var diff = $('.feature-list ul').width() - $(window).width();
                var pos = 0;
                if (diff > 0) {
                    var left_pos = $('.feature-list ul').css('left');
                    left_pos = parseInt(left_pos);

                    if (left_pos == 0) {
                        pos = left_pos;
                    }
                    else {
                        pos = diff + left_pos;
                    }
                    $('.feature-list ul').animate({'left': '+' + pos + 'px'}, 500);
                }
            });
        }
    },
    createUserPage: function () {
        var that = this;
        that.flag = true;
        var obj = {
            head: {
                action: "getUsers"
            },
            body: {
                where: {
                    name: "",
                    role: [],
                    status: []
                },
                order_by: "name",
                order_type: "asc",
                filter: true
            }
        }
        var _str = JSON.stringify(obj);
        that.getUserList(_str);
        that.disableUser();
        that.activateUser();
        that.searchUser();
        that.addUserFilter();
        that.changeRole();
        that.sortUserTable();
        User.role.openPopup('.add-popup');
        User.role.closePopup();
    },
    disableUser: function () {
        var that = this;
        var ajaxLink = User.ajaxLink2;
        $('#userList').on('click', '.disable_user', function () {
            id = $(this).attr('data-id');
            var td = $(this);
            var obj = {
                head: {
                    action: "disableUser"
                },
                body: {
                    user_id: id
                }
            }
            var _obj = JSON.stringify(obj);

            that.getAjaxData(ajaxLink, _obj, function (_data) {
                var ajax_msg = '1 user disabled';
                $('.info-notice').html(ajax_msg);
                var tr = td.closest('tr');
                tr.find('.status').text('Deactivated');
                tr.css('background-color', '#ffc0cc');
                td.removeClass('disable_user');
                td.addClass('activate_user');
                var iTag = td.find('i');
                iTag.removeClass('fa-times');
                iTag.removeClass('red');
                iTag.addClass('fa-check');
                iTag.addClass('green');
                $('#loader').hide();
                $('.notify').addClass('n-animation');
                setTimeout(function () {
                    $('.notify').removeClass('n-animation');
                }, 2000);
            });
            return false;
        });
    },
    activateUser: function () {
        var that = this;
        var ajaxLink = User.ajaxLink2;
        $('#userList').on('click', '.activate_user', function () {
            id = $(this).attr('data-id');
            var td = $(this);
            var obj = {
                head: {
                    action: "enableUser"
                },
                body: {
                    user_id: id
                }
            }
            var _obj = JSON.stringify(obj);

            that.getAjaxData(ajaxLink, _obj, function (_data) {
                var ajax_msg = '1 user activated';
                $('.info-notice').html(ajax_msg);
                var tr = td.closest('tr');
                tr.find('.status').text(User.roles[_data.body.status - 1]);

                tr.css('background-color', '');
                td.removeClass('activate_user');
                td.addClass('disable_user');
                var iTag = td.find('i');
                iTag.removeClass('fa-check');
                iTag.removeClass('green');
                iTag.addClass('fa-times');
                iTag.addClass('red');
                $('#loader').hide();
                $('.notify').addClass('n-animation');
                setTimeout(function () {
                    $('.notify').removeClass('n-animation');
                }, 2000);
            });
            return false;
        });
    },
    changeRole: function () {

        var that = this;
        var ajaxLink = User.ajaxLink2;
        $('#userList').on('change', '.change_role', function () {
            var user_id = $(this).attr('data-user-id');
            var new_rol = $(this).val();

            var obj = {
                head: {
                    action: "changeRole"
                },
                body: {
                    user_id: user_id,
                    new_role_id: new_rol
                }
            }
            var _obj = JSON.stringify(obj);

            that.getAjaxData(ajaxLink, _obj, function (_data) {
                var ajax_msg = '1 Role Changed';
                $('.info-notice').html(ajax_msg);

                $('#loader').hide();
                $('.notify').addClass('n-animation');
                setTimeout(function () {
                    $('.notify').removeClass('n-animation');
                }, 2000);
            });
            return false;
        });


    },
    searchUser: function () {
        var that = this;
        that.getSearchPlugin();

        $('#search_user').donetyping(function () {
            var sortoption = that.getSortingOrder();
            var checkedroles = that.getSelectedRoles();
            var checkedStatus = that.getSelectedStatus();
            var searchText = $('#search_user').val();
            var obj = {
                head: {
                    action: "getUsers"
                },
                body: {
                    where: {
                        name: searchText,
                        role: checkedroles,
                        status: checkedStatus
                    },
                    order_by: sortoption[0],
                    order_type: sortoption[1],
                    filter: true
                }
            }
            var _obj = JSON.stringify(obj);
            that.getUserList(_obj);
        }, 500);

    },
    addUserFilter: function () {
        var that = this;
        $('#roles_ul').on('change', '.roles', function () {
            var sortoption = that.getSortingOrder();
            var checkedroles = that.getSelectedRoles();
            var checkedStatus = that.getSelectedStatus();
            var searchText = $.trim($('#search_user').val());
            var obj = {
                head: {
                    action: "getUsers"
                },
                body: {
                    where: {
                        name: searchText,
                        role: checkedroles,
                        status: checkedStatus
                    },
                    order_by: sortoption[0],
                    order_type: sortoption[1],
                    filter: true
                }
            }

            var _obj = JSON.stringify(obj);
            that.getUserList(_obj);

        });
        $('#status_ul').on('change', '.status', function () {
            var sortoption = that.getSortingOrder();
            var checkedroles = that.getSelectedRoles();
            var checkedStatus = that.getSelectedStatus();
            var searchText = $.trim($('#search_user').val());
            var obj = {
                head: {
                    action: "getUsers"
                },
                body: {
                    where: {
                        name: searchText,
                        role: checkedroles,
                        status: checkedStatus
                    },
                    order_by: sortoption[0],
                    order_type: sortoption[1],
                    filter: true
                }
            }

            var _obj = JSON.stringify(obj);
            that.getUserList(_obj);
        });
    },
    sortUserTable: function () {
        var that = this;
        $('.sort_table').click(function () {
            var order_by = $(this).attr('data-order-by');
            var order_type = $(this).attr('data-order-type');
            $('#userList .sort_table').each(function () {
                var _orderType = $(this).attr('data-order-type');
                if (_orderType != 'desc') {
                    $(this).find('.fa').removeClass('fa-caret-up').addClass('fa-caret-down');
                    $(this).removeClass('active_sort');
                    $(this).attr('data-order-type', 'asc');
                }
            });

            if (order_type == 'asc') {
                $(this).find('.fa').addClass('fa-caret-down').removeClass('fa-caret-up');
                $(this).attr('data-order-type', 'desc');
                $(this).addClass('active_sort');
            }
            else {
                $(this).find('.fa').removeClass('fa-caret-down').addClass('fa-caret-up');
                $(this).attr('data-order-type', 'asc');
                $(this).addClass('active_sort');
            }

            var checkedroles = that.getSelectedRoles();
            var checkedStatus = that.getSelectedStatus();
            var searchText = $.trim($('#search_user').val());
            var obj = {
                head: {
                    action: "getUsers"
                },
                body: {
                    where: {
                        name: searchText,
                        role: checkedroles,
                        status: checkedStatus
                    },
                    order_by: order_by,
                    order_type: order_type,
                    filter: true
                }
            }
            console.log(obj);
            var _obj = JSON.stringify(obj);
            that.getUserList(_obj);
        });
    },
    getSortingOrder: function () {
        var sortby = [];
        if ($('#userList .active_sort').length) {
            var oderby = $('#userList .active_sort').attr('data-order-by');
            var ordertype = $('#userList .active_sort').attr('data-order-type');
            ordertype = (ordertype == 'desc' ? 'asc' : 'desc');
            sortby.push(oderby);
            sortby.push(ordertype);
        }
        else {
            sortby.push("name");
            sortby.push("asc");
        }
        return sortby;
    },
    getUserList: function (_obj) {
        var that = this;
        var ajaxLink = User.ajaxLink2;
        that.getAjaxData(ajaxLink, _obj, function (responseData) {
            var html = '';
            var status = '';
            var status_ul = '';
            var roles = '';
            var _data = responseData.body.data;
            var allstatus = responseData.body.filters.status;
            var allroles = responseData.body.filters.roles;

            if (that.flag == true) {
                that.flag = false;

                if (allroles.length > 0) {
                    $.each(allroles, function (index) {
                        roles += '<li><input type="checkbox" name="Roles" class="roles" value="' + allroles[index].id + '" /><label>' + allroles[index].name + '</label></li>';
                    });

                    $('#roles_ul').append(roles);
                }
                if (allstatus.length) {
                    $.each(allstatus, function (index) {
                        status_ul += '<li><input type="checkbox" name="Status" class="status" value="' + allstatus[index].id + '" /><label>' + allstatus[index].name + '</label></li>';
                    });

                    $('#status_ul').append(status_ul);
                }
            }

            if (_data.length > 0) {
                $.each(_data, function (index) {

                    var userrole = _data[index].role.id;
                    var selectbox = '';
                    selectbox += '<select class="change_role" data-user-id="' + _data[index].id + '">';
                    $.each(allroles, function (index) {
                        selectbox += '<option ' + (userrole == allroles[index].id ? 'selected' : '') + ' value = "' + allroles[index].id + '" ' + (allroles[index].status == 1 ? "" : 'disabled') + '>' + allroles[index].name + '</option>';
                    });
                    selectbox += '</select>';


                    status = allstatus[_data[index].status - 1].name;
                    if (_data[index].status == 4) {
                        html += '<tr style="background-color:#ffc0cc">';
                    }
                    else {
                        html += '<tr>';
                    }
                    html += '<td><a href="#">' + (_data[index].name == null ? _data[index].email : _data[index].name) + '</a></td>';
                    html += '<td>' + selectbox + '</td>';
                    html += '<td class="status">' + status + '</td>';
                    html += '<td>' + _data[index].last_login + '</td>';
                    if (_data[index].status == 4)
                        html += '<td><a class="activate_user" href="#"  data-id="' + _data[index].id + '"><i class="fa fa-check green"></i></a></td>';
                    else {
                        html += '<td><a class="disable_user" href="#"  data-id="' + _data[index].id + '"><i class="fa fa-times red"></i></a></td>';
                    }
                    html += '</tr>';
                });

                $('.curr-result, .total-result').text(_data.length);
            }
            else {
                html += '<tr>';
                html += '<td colspan="5" >No Data is Found</td>';
                html += '</tr>';
                $('.curr-result, .total-result').text('0');
            }

            $('#userList tbody').html('');
            $('#userList tbody').html(html);
            $('#userList').show();
            $('#loader').hide();


        });
    },
    inviteUsers: function(){
        $('#invite-users-action').click(function(){
            var useremail = $('#useremail').val();
            var selectedrole = $('#selected_role :selected').val();
            
            
        });
    },
    getSelectedRoles: function () {
        var that = this;
        that.checkedRoles = [];
        $('#roles_ul :checked').each(function () {
            that.checkedRoles.push($(this).val());
        });

        return that.checkedRoles;
    },
    getSelectedStatus: function () {
        var that = this;
        that.checkedStatus = [];
        $('#status_ul :checked').each(function () {
            that.checkedStatus.push($(this).val());
        });

        return that.checkedStatus;
    },
    getSearchPlugin: function () {
        ;
        (function ($) {

            $.fn.extend({
                donetyping: function (callback, timeout) {
                    timeout = timeout || 1e3;
                    var timeoutReference,
                            doneTyping = function (el) {
                                if (!timeoutReference)
                                    return;
                                timeoutReference = null;
                                callback.call(el);
                            };
                    return this.each(function (i, el) {
                        var $el = $(el);
                        $el.is(':input') && $el.on('keyup keypress paste', function (e) {
                            if (e.type == 'keyup' && e.keyCode != 8)
                                return;
                            if (timeoutReference)
                                clearTimeout(timeoutReference);
                            timeoutReference = setTimeout(function () {
                                doneTyping(el);
                            }, timeout);
                        }).on('blur', function () {
                            doneTyping(el);
                        });
                    });
                }
            });
        })(jQuery);
    },
    getPermissionAccess: function (_access) {
        var _permission = '';
        if (_access.app == true && _access.user == true) {
            _permission = 'App, User';
        }
        else if (_access.app == false && _access.user == true) {
            _permission = 'User';
        }
        else if (_access.app == true && _access.user == false) {
            _permission = 'App';
        }
        else {
            _permission = 'Basic';
        }
        return _permission;
    },
    getAjaxData: function (_ajaxLink, _obj, callback) {
        $.ajax({
            url: _ajaxLink,
            method: 'post',
            dataType: 'json',
            data: _obj,
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (res) {
                callback(res);
            },
            error: function (err) {
                obj = jQuery.parseJSON(err.responseText);
                if (obj.head.status === 'error') {
                    alert(obj.body.error_msg);
                }
            }
        });
    }

});

$.extend(Role, {
    user: new User(),
    login: new Login()
});

$.extend(Role.prototype, {
    init: function () {
        var that = this;
        if ($('#roleList').length) {
            that.createRolePage();
        }
    },
    createRolePage: function () {
        var that = this;
        var obj = {
            head: {
                action: "getRoles"
            },
            body: {
                where: {
                    name: ""
                }
            }
        }
        var _obj = JSON.stringify(obj);
        that.getRolesList(_obj);
        that.disableRole();
        that.enableRole();
        that.searchRoles();
        that.openPopup('.add-popup');
        that.closePopup();
        that.createRole();
    },
    getRolesList: function (_obj) {
        var that = this;
        var ajaxLink = User.ajaxLink2;
        user.getAjaxData(ajaxLink, _obj, function (data) {
            var html = '';
            var currentUserRoleId = data.body.loggedin_user_role_id;
            var _data = data.body.data;

            if (_data.length) {
                $.each(_data, function (index) {
                    var access = user.getPermissionAccess(_data[index].app_permissions);
                    if (_data[index].is_active) {
                        html += '<tr>';
                    }
                    else {
                        html += '<tr style="background-color:#ffc0cc">';
                    }
                    html += '<td><a href="#">' + _data[index].name + '</a>' + (_data[index].id == currentUserRoleId ? '<i class="fa fa-check"></i>' : '') + '</td>';
                    html += '<td>' + access + '</td>';
                    html += '<td>-</td>';
                    if (_data[index].is_active) {
                        html += '<td>' + (_data[index].id != currentUserRoleId ? '<a class="disable_role" href="#" data-role-id="' + _data[index].id + '"><i class="fa fa-times red"></i></a>' : '') + '</td>';
                    }
                    else {
                        html += '<td>' + (_data[index].id != currentUserRoleId ? '<a class="enable_role" href="#" data-role-id="' + _data[index].id + '"><i class="fa fa-check green"></i></a>' : '') + '</td>';

                    }
                    html += '</tr>';
                });

                $('.curr-result, .total-result').text(_data.length);
            }
            else {
                html += '<tr>';
                html += '<td colspan="4">No data found</td>';
                html += '</tr>';
                $('.curr-result, .total-result').text('0');
            }
            $('#roleList tbody').html('');
            $('#roleList tbody').html(html);
            $('#roleList').show();
            $('#loader').hide();

        });
    },
    searchRoles: function () {
        var that = this;
        user.getSearchPlugin();

        $('#search_role').donetyping(function () {

            var searchText = $('#search_role').val();
            var obj = {
                head: {
                    action: "getRoles"
                },
                body: {
                    where: {
                        name: searchText
                    }
                }
            }
            var _obj = JSON.stringify(obj);
            that.getRolesList(_obj);
        }, 500);

    },
    disableRole: function () {
        $('#roleList').on('click', '.disable_role', function () {
            var that = this;
            var td = $(this);
            var ajaxLink = User.ajaxLink2;
            var roleId = $(this).attr('data-role-id');
            var obj = {
                head: {
                    action: "disableRole"
                },
                body: {
                    role_id: roleId
                }
            }

            var _obj = JSON.stringify(obj);
            user.getAjaxData(ajaxLink, _obj, function (data) {
                td.addClass('enable_role').removeClass('disable_role');
                td.html('<i class="fa fa-check green"></i>');
                var tr = td.closest('tr');
                tr.css('background-color', '#ffc0cc');
                var ajax_msg = '1 Role Disabled';
                $('.info-notice').html(ajax_msg);
                $('#loader').hide();
                $('.notify').addClass('n-animation');
                setTimeout(function () {
                    $('.notify').removeClass('n-animation');
                }, 2000);
            });

            return false;
        });
    },
    enableRole: function () {
        $('#roleList').on('click', '.enable_role', function () {
            var that = this;
            var td = $(this);
            var ajaxLink = User.ajaxLink2;
            var roleId = $(this).attr('data-role-id');
            var obj = {
                head: {
                    action: "enableRole"
                },
                body: {
                    role_id: roleId
                }
            }

            var _obj = JSON.stringify(obj);
            user.getAjaxData(ajaxLink, _obj, function (data) {
                td.addClass('disable_role').removeClass('enable_role');
                td.html('<i class="fa fa-times red"></i>');
                var tr = td.closest('tr');
                tr.css('background-color', '');
                var ajax_msg = '1 Role Enabled';
                $('.info-notice').html(ajax_msg);
                $('#loader').hide();
                $('.notify').addClass('n-animation');
                setTimeout(function () {
                    $('.notify').removeClass('n-animation');
                }, 2000);
            });
            return false;
        });
    },
    openPopup: function (_Id) {
        $(_Id).click(function () {
            var modalId = $(this).attr('data-modal-id');
            $(modalId).show();
            return false;
        });
    },
    closePopup: function () {
        $('.close-popup').click(function () {
            $('.popup-wrapper').hide();
            return false;

        });
    },
    createRole: function () {
        var that = this;
        var error = '';
        var ajaxLink = User.ajaxLink2;
        $('#create_role').click(function () {
            $('.validation_msg').html('');
            var _roleName = $.trim($('#role_name').val());
            var _roleDesc = $.trim($('#role_description').val());

            if (_roleName == '') {
                errDiv = $('#role_name').next('.validation_msg');
                error = 'Role Name Field can be empty';
                errDiv.html(error);
            }

            else if (_roleDesc == '') {
                errDiv = $('#role_description').next('.validation_msg');
                error = 'Role Description can be empty';
                errDiv.html(error);
            }
            else {
                var obj = {
                    head: {
                        action: "createRole"
                    },
                    body: {
                        name: _roleName,
                        description: _roleDesc
                    }
                }
                var _obj = JSON.stringify(obj);
                user.getAjaxData(ajaxLink, _obj, function (_data) {
                    window.location.href = 'http://' + window.location.hostname + '/roles?new_role=' + _data.body.role_id;
                });
            }
        });
    }
});



$.extend(Permission, {
});

$.extend(Permission.prototype, {
    init: function () {

    },
    createTabs: function () {
        if ($('#createTab').length) {

        }
    }
});


$(document).ready(function () {

    user = new User();
    user.init();
});




