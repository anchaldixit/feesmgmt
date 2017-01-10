function Module(){

}

$.extend(Module,{
    baseurl: 'http://'+window.location.hostname+'/settings/fieldset/'
});
$.extend(Module.prototype,{
    init: function(){
        var that = this;
        Module.baseurl = 'http://'+window.location.hostname+Module.getAppDevLink()+'/settings/fieldset/';
        
        if($('#setting_edit_template').length){
            
            that.bindModuleFieldTypeAction();
            //that.openPopup('.open_formula_popup');
            that.closePopup();
            
        }
        if($('#group_dd').length){
            that.bindGroupDropDownAction();
        }
        
        that.bindModuleDropDownAction();
        that.bindFormulaFieldPopup();
        that.bindRelationalFieldPopup();
        that.bindModuleFieldIdentifierPopup();
        that.bindAddRelationalFieldAction();
        that.bindAddFieldAction();
        that.bindModuleIdentifierField();
        
    },
    bindModuleFieldTypeAction: function(){
        $('#module_field_datatype').change(function(){
            var _val = $(this).find('option:selected').val();
            if(_val == 'formulafield'){
               $('.add_f_field').show();}
            else{
               $('.add_f_field').hide();}
        });
        
    },
    openPopup: function(_Id){
        $(_Id).click(function () {
            var modalId = $(this).attr('data-modal-id');
            $(modalId).show();
            return false;
        });
    },
    closePopup: function(){
        $('.close-popup').click(function () {
            $('.popup-wrapper').hide();
            return false;

        });
    },
    bindModuleIdentifierField: function(){
        var that = this;
        $('#module_field_identifiers').change(function(){
            var _val = $(this).val();
            that.setModuleIdentifier(_val,function(res){
                
                if(res.success !== undefined){
                    $('#re_response').html('');
                    $('#re_response').html(res.success);
                    $('#re_response').show();
                }
                if(res.error !== undefined){
                    alert(res.error);
                }
                setTimeout(function(){
                    $('#re_response').hide();
                    $('#re_response').html('');
                    
                },4000);
            });
        });
    },
    bindGroupDropDownAction: function(){
        $('#group_dd').change(function () {
            //debugger;
            var _val = $(this).find('option:selected').val();
            if (_val == '') {
                $('#field_group_name').show();
                $('.group_display_li').show();
            }
            else {

                $('#field_group_name').hide();
                $('.group_display_li').hide();
            }

        });
    },
    bindModuleDropDownAction: function(){
        var moduleName = $('#module').find('option:selected').val();
            if (moduleName != '') {
                $('#group_dd').find('.' + moduleName).removeClass('hide');
            }
            $('#module').change(function () {
                var moduleName = $(this).find('option:selected').val();
                $('#group_dd').find('.module').addClass('hide');
                $('#group_dd').find('.' + moduleName).removeClass('hide');
            });
    },
    bindFormulaFieldPopup: function(){
        var that = this;
        $('.open_formula_popup').click(function(){
        var moduleId = $(this).attr('data-modal-id');
        var _moduleName = $('#module').find('option:selected').val();
        if(_moduleName != ''){
            //var _moduleName = 'marketing_projects';
            var url = Module.baseurl+ _moduleName;
            var _data = '{}';
            that.getAjaxData(url, _data,function(res){
                var html = '';
                $.each(res,function(key,value){
                    html += '<tr>';
                    html += '<td><input type="radio" value="'+key+'" name="foumula_fields"/></td>';
                    html += '<td>'+value+'</td>';
                    $('#formula_popup tbody').html('');
                    $('#formula_popup tbody').html(html);
                    $(moduleId).show();

                });
            });
        }
        else{
            alert('Please choose module');
        }
        return false;
        });
    },
    bindRelationalFieldPopup: function(){
        var that = this;
        $('.open_relationship_popup').click(function(){
            var modalId = $(this).attr('data-modal-id');
            var _relationalModuleName = $('#relationship_module').find('option:selected').val();
            if(_relationalModuleName != ''){

                //var _moduleName = 'marketing_projects';
                var url = Module.baseurl+ _relationalModuleName;
                var _data = '{}';
                that.getAjaxData(url, _data,function(res){
                    var html = '';
                    $.each(res,function(key,value){
                        html += '<tr>';
                        html += '<td><input type="checkbox" value="'+key+'" name="relation_fields"/></td>';
                        html += '<td>'+value+'</td>';
                        $('#relation_popup tbody').html('');
                        $('#relation_popup tbody').html(html);
                        $(modalId).show();

                    });
                });

            }
            else{
                alert('Please choose Relational module');   
            }
            return false;
        });
    },
    bindModuleFieldIdentifierPopup : function(){
        var that = this;
        $('.open_module_field_identifier_popup').click(function(){
            var modalId = $(this).attr('data-modal-id');
            var _relationalModuleName = $('#relationship_module').find('option:selected').val();
            if(_relationalModuleName != ''){

                //var _moduleName = 'marketing_projects';
                var url = Module.baseurl+ _relationalModuleName;
                var _data = '{}';
                that.getAjaxData(url, _data,function(res){
                    var html = '<option value="">Select</option>';
                    $.each(res,function(key,value){
                        html += '<option value="'+key+'" >'+value+'</option>';
                        $('#module_field_identifiers').html('');
                        $('#module_field_identifiers').html(html);
                        $(modalId).show();

                    });
                });

            }
            else{
                alert('Please choose Relational Table');   
            }
            return false;
        });
    },
    bindAddRelationalFieldAction: function(){
        var that = this;
        $('.relation_field_btn').click(function(){
            
            var _selChecks = $('input[name="relation_fields"]:checked');
            that.fillUniqueFields(_selChecks, function(count){
                
                var msg = count+' Fields has been added';
                $('.msg p').html('');
                $('.msg p').html(msg);
                $('.msg').show();
                setTimeout(function(){
                    $('.msg').hide();
                    $('input[name="relation_fields"]').prop('checked',false);
                },2000);
            });
            
        });
    },
    
    bindAddFieldAction: function(){
        var that = this;
        $('.formula_field_btn').click(function(){
            
            var _selChecks = $('input[name="foumula_fields"]:checked');
            that.fillTextArea(_selChecks, function(count){
                
                var msg = count+' Fields has been added';
                $('.msg p').html('');
                $('.msg p').html(msg);
                $('.msg').show();
                setTimeout(function(){
                    $('.msg').hide();
                    $('input[name="foumula_fields"]').prop('checked',false);
                },2000);
            });
            
        });
    },
    fillUniqueFields: function(_obj, callback){
        var _fields = '';
        _obj.each(function(){
            var _valArr = '';
            _valArr = $(this).val();
            _val = _valArr.split('.');
            //console.log(_val[1]);
               _fields += _val[1]+'|';
           });
           var textfields = $('#relationship_module_unique_field').val();
           if(textfields != ''){
               _fields = textfields+ '|' + _fields;
           }
           _fields = _fields.substring(0, _fields.length - 1);
           $('#relationship_module_unique_field').val(_fields);
           callback(_obj.length);
    }, 
    fillTextArea: function(_obj, callback){
        var _fields = '';
        _obj.each(function(){
            _fields += $(this).val()+' ';
        });
        var textfields = $('#formulafield').val();
        if(textfields != ''){
            _fields = textfields + _fields;
        }

        $('#formulafield').val(_fields);
        callback(_obj.length);
    },
    setModuleIdentifier: function(_obj,callback){
        var res ={};
        var _fieldArr = _obj.split('.');
        if(_fieldArr.length == 0){
            res.error = 'Module Field Identifier has not set';
        }
        else{
            $('#module_field_name').val(_fieldArr[1]);
            res.success = 'Module Field Identifier has been set';
            
        }
        
        callback(res);
    },
    getAjaxData: function(_url, _data, callback){
        $.ajax({
            url: _url,
            method: 'post',
            dataType: 'json',
            data: _data,
            beforeSend: function () {
                
            },
            success: function (res) {
                callback(res);
            },
            error: function (err) {
                alert('An error has occurred..!');
                
            }
        });
    }
});
Module.getAppDevLink = function(){
        var _str = '';
        var _path = window.location.pathname;
        if (_path.indexOf("app_dev.php") >= 0){
            _str = '/app_dev.php';
        }
        
        return _str;
    }
$(document).ready(function(){
    var module = new Module();
    module.init();
});