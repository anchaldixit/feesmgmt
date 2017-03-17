var QuickEdit = function () {
    var self = this;
    var $ = jQuery;
    self.active_quick_id;
    self.init = function () {
        self.bindEditViewAction();
    };
    self.bindEditViewAction = function () {
        $('.quick-edit, #quick_add_row').unbind('click');
        $('.quick-edit, #quick_add_row').on('click', function (e) {
            var id = $(this).attr('data-edit-id'), url;
            if (id !== undefined) {
                self.active_quick_id = id;
                url = '/app_dev.php/settings/edit/' + id;
            } else {
                self.active_quick_id = null;
                url = '/app_dev.php/settings/edit/new';

            }
            self.getData(url, 'GET', 'html', {ajax: 'yes'}, self.showForm);
            //$("#dialog").dialog();
            e.preventDefault();

        });

        $('.delete-link').unbind('click');
        $('.delete-link').on('click', function (event) {
            if (confirm('Are you sure to delete the row?')) {
                event.stopPropagation();
                return true;
            }
            return false;
        });
    };
    self.bindAjaxSaveAction = function () {
        $('#row-edit-form').unbind('submit');
        $('#row-edit-form').on('submit', function () {
            return false
        });
        $('#row-edit-form input[type="submit"]').on('click', function (e) {
            var url;
            e.preventDefault();
            //var id = $(this).attr('data-edit-id');
            params = $('#row-edit-form').serializeArray();

            params = $.merge(params, [{name: 'ajax', value: 'yes'}]);
            if ($(e.target).attr('name') == 'delete_submit') {
                //sent delete action param to identify delete action
                params = $.merge(params, [{name: 'delete_submit', value: 'Delete'}]);
            }
            if ($(e.target).attr('name') == 'add_submit') {
                url = '/app_dev.php/settings/edit/new';
            } else {
                url = '/app_dev.php/settings/edit/' + self.active_quick_id;
            }
            self.getData(url, 'POST', 'json', params, self.showupdate);
            //$("#dialog").dialog();
            //return false;
            return false;
        });
    };

    self.getData = function (_url, _method, _type, _data, callback) {
        $.ajax({
            url: _url,
            method: _method,
            dataType: _type,
            data: _data,
            cache: false,
            beforeSend: function () {

            },
            success: function (res) {
                callback(res);
            },
            error: function (err) {
                alert('An error has occurred..!');
            }
        });
    };
    self.showupdate = function (resp) {

        if (resp.error === undefined && resp.msg !== undefined) {
            // alert('no error')
            $("#dialog").dialog('close');
            m = new MessageBox('success', resp.msg);

            if (self.active_quick_id) {
                
                var table_row_id = '#row_id_' + self.active_quick_id, old_row = $(table_row_id);
                if (old_row.length) {
                    if (resp.action === 'update') {
                        console.log('updated');
                        old_row.replaceWith(resp.row);
                        //due to complete row html replacement, reinitialize the events again
                        self.bindEditViewAction();
                        //jsut highlight the row
                        $(table_row_id).addClass('bg').addClass('highlight-row');
                        setTimeout(function () {
                            $(table_row_id).removeClass('highlight-row');
                        }, 3000);
                    } else if (resp.action === 'delete') {
                        old_row.remove();

                    }
                }

            } else {
                if (resp.action === 'add') {
                    $('.setting_table tbody').prepend(resp.row);
                    //due to complete row html replacement, reinitialize the events again
                    self.bindEditViewAction();
                    //jsut highlight the row
                    if (resp.id !== undefined) {
                        $('#row_id_' + resp.id).addClass('bg').addClass('highlight-row');
                        setTimeout(function () {
                            $('#row_id_' + resp.id).removeClass('highlight-row');
                        }, 3000);
                    }

                }

            }

            m.showMsg();
            self.active_quick_id = null;


        } else if (resp.error !== undefined) {

            m = new MessageBox('error', resp.error_msgs);
            m.showMsg();

        }

    };

    self.showForm = function (resp) {
        $("#dialog")
                .html(resp)
                .dialog(
                        {
                            width: 550,
                            open: function (event, ui) {
                                self.quickEditFieldValidations();
                                self.bindAjaxSaveAction();
                            },
                            close: function (event, ui) {
                                //$('.notify').hide();
                                m = new MessageBox();
                                m.hideMsg();
                            }
                        }
                );
    };

    self.quickEditFieldValidations = function () {
        $('#fieldname_edit').on('click', function () {
            $('#module_field_name').attr('READONLY', false).focus();
            return false;
        });
        $('#module_field_datatype').on('change', function () {

            if ($(this).val() == 'enum') {
                $('#value_row').slideDown('slow');
            } else {
                $('#value_row').slideUp('slow');
            }
            if ($(this).val() == 'link') {
                $('#link_text_row').slideDown('slow');
            } else {
                $('#link_text_row').slideUp('slow');
            }
            if ($(this).val() == 'varchar') {
                $('#varchar_limit_row').slideDown('slow');
            } else {
                $('#varchar_limit_row').slideUp('slow');
            }
            if ($(this).val() == 'text' || $(this).val() == 'link') {
                jQuery("#enable_filter").val('N');
                $('#enable_filter_row').slideUp('slow');
            } else {
                $('#enable_filter_row').slideDown('slow');
            }

            if ($(this).val() == 'varchar' || $(this).val() == 'number') {
                $('#unique_field_row').slideDown('slow');
            } else {
                $('#unique_field_row').slideUp('slow');
            }

            if ($(this).val() == 'relationship') {
                $('#relationship_module_unique_field_row').slideDown('slow');
            } else {
                $('#relationship_module_unique_field_row').slideUp('slow');
            }

            if (['relationship-aggregator', 'relationship'].indexOf($(this).val()) > -1) {
                $('#relationship_module_row').slideDown('slow');
            } else {
                $('#relationship_module_row').slideUp('slow');
            }

            if ($(this).val() == 'relationship-aggregator') {
                $('#aggregator_function_row').slideDown('slow');
            } else {
                $('#aggregator_function_row').slideUp('slow');
            }

            if (['varchar', 'relationship'].indexOf($(this).val()) == -1) {
                $('#enable_filter_with_option_row').slideUp('slow')
            }
            if ($(this).val() == 'formulafield') {
                $('#formulafield_row').slideDown('slow');
            } else {
                $('#formulafield_row').slideUp('slow');
            }

        }).trigger('change');

        $('#enable_filter').on('change', function () {
            if ($(this).val() == 'Y' && ['varchar', 'relationship'].indexOf($('#module_field_datatype').val()) > 0) {
                $('#enable_filter_with_option_row').slideDown('slow')
            } else {
                $('#enable_filter_with_option_row').slideUp('slow');
            }

        }).trigger('change');


        if ($('#edit_id_hidden_field').length) {
            $('#module_field_datatype').attr('DISABLED', true);
            //$('.add_f_field').hide();
            $('#module').attr('DISABLED', true);
            $('#relationship_module').attr('DISABLED', true);
            //$('#field_has_relationship').attr('DISABLED', true);
            $('#varchar_limit').attr('DISABLED', true);
            $('#unique_field').attr('DISABLED', true);

            $('#fieldname_edit').hide();

            $('#delete_action').on('click', function () {
                if (!confirm('Are you sure to delete the column with data, this step cannot be rollbacked')) {
                    event.stopPropagation()
                }
            });

            $('.open_module_field_identifier_popup').hide();
            $('.open_aggregator_popup').hide();
        }
        var module = new Module();
        module.init();
    }

};
var MessageBox = function (type, msg) {
    var self = this;
    var $ = jQuery;

    $('.notify').removeClass('error').removeClass('n-animation').removeClass('n-movetoleft');

    self.showMsg = function () {
        if (type == 'success') {
            $('.notify .info-notice').html(msg);
            $('.notify').addClass('n-animation');
            setTimeout(function () {
                $('.notify').removeClass('n-animation')
            }, 2000);
        } else if (type == 'error') {
            $('.notify .info-notice').html(msg);
            $('.notify').addClass('error').addClass('n-animation');
            setTimeout(function () {
                $('.notify').addClass('n-movetoleft');
            }, 1000);
        }
    };
    self.hideMsg = function () {
        $('.notify').removeClass('n-animation').removeClass('error').removeClass('n-movetoleft');
    }


    //return self;
}