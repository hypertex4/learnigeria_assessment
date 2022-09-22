(function($) {
    'use strict';
    // No White Space
    $.validator.addMethod("noSpace", function(value, element) {
        if( $(element).attr('required') ) {
            return value.search(/^(?! *$)[^]+$/) == 0;
        }
        return true;
    }, 'Please fill this empty field.');
    $.validator.addClassRules({
        'form-control': {noSpace: true}
    });

    $("form[name='create_client']").validate({
        rules: {
            client_fullname: "required",
            organisation_name: "required",
            client_email: {required: true, email: true},
            client_mobile: {required: true, digits: true},
            client_pwd: {required: true, minlength: 6},
            pwd_confirm: {required: true, equalTo: '[name="client_pwd"]'},
            agreeterms: "required"
        },
        messages: {
            client_fullname: "Enter client full name",
            organisation_name: "Enter organisation name",
            client_email: "Enter a valid client email",
            client_mobile: "Enter a valid client phone no",
            client_pwd: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            pwd_confirm: {required: "", equalTo: ""},
            agreeterms:"Pls agree to our terms of use"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.checkbox-custom'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/create-client.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_client').reset();
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='create_assessor']").validate({
        rules: {
            fullname: "required",
            client_id: "required",
            email: {required: true, email: true},
            ass_status:  "required",
            password : {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            fullname: "Enter assessor full name",
            client_id: "",
            email: "Enter a valid email",
            ass_status: "required",
            password: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            confirm_password: {required: "Confirm password is required", equalTo: "Password not matched"}
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.checkbox-custom'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/create-assessor.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('create_assessor').reset();
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.replace('list-assessor');}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='client_login']").validate({
        rules: {
            cli_id_or_em: "required",
            client_pwd: "required"
        },
        messages: {
            cli_id_or_em: "Enter your client ID or Email",
            client_pwd: "Enter your password"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/client-login.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('client_login').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.replace(data.location),1000);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_personal_info']").validate({
        rules: {
            user_id: "required",
            user_name: "required",
            user_email: {required: true,email:true},
            org_name: "required"
        },
        messages: {
            user_id: "",
            user_name: "Name is required",
            user_email: "Enter a valid email address",
            org_name: "Type is required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/update-user-profile.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_profile_by_user_id']").validate({
        rules: {
            fullname: "required",
            user_id: "required",
            email: {required: true,email:true},
            ass_status: "required"
        },
        messages: {
            fullname: "Name is required",
            user_id: "",
            email: "Enter a valid email address",
            ass_status: "Status is required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/update-user-profile-by-user-id.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_password_info']").validate({
        rules: {
            curr_pwd: "required",
            new_pwd: {required: true, minlength: 6},
            rpt_new_pwd: {required: true, equalTo: '[name="new_pwd"]'}
        },
        messages: {
            curr_pwd:"Current password required",
            new_pwd: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            rpt_new_pwd: {required: "Required", equalTo: "Password not matched"}
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/update-user-password.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_password_by_user_id']").validate({
        rules: {
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: '[name="password"]'}
        },
        messages: {
            password: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            confirm_password: {required: "Required", equalTo: "Password not matched"}
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "api/v7/update-password-user-id.php", type: "POST", data: JSON.stringify($form.serializeObject()),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse2('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse2('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $(document).on("click", "#assessorStatusBtn", function (e) {
        var u_id = $(this).data("u_id");
        var active = $(this).data("active");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to update assessor status?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "api/v7/assessor-actions.php", type: "POST",
                        data: JSON.stringify({u_id:u_id,active:active,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {window.location.replace('list-assessor'); }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData)  {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);  },
            }
        });
    });

    $(document).on("click", "#assessorDeleteBtn", function (e) {
        e.preventDefault();
        var u_id = $(this).data("u_id");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);
        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this assessor profile?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "api/v7/assessor-actions.php", type: "POST",
                        data: JSON.stringify({u_id:u_id, action_code: 102}),
                        success: function (data) {
                            if (data.status === 1) {
                                new PNotify({title: 'Success', text: data.message, type: 'success'});
                                setTimeout(function () {
                                    window.location.replace('list-assessor');
                                }, 500);
                            } else { new PNotify({title: 'Error', text: data.message, type: 'danger'}); }
                        },
                        error: function (errData) {},
                        complete: function () { submitButton.val(submitButtonText).attr('disabled', false); }
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
            }
        });
    });


    var datatableInit = function() {
        var $table = $('#datatable-assessment222');

        var table = $table.dataTable({
            sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print'
                },
                {
                    extend: 'excel',
                    text: 'Excel'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize : function(doc){
                        var colCount = new Array();
                        $('#datatable-assessment222').find('tbody tr:first-child td').each(function(){
                            if($(this).attr('colspan')){
                                for(var i=1;i<=$(this).attr('colspan');$i++){
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                }
            ]
        });

        $('<div />').addClass('dt-buttons mb-2 pb-1 text-end').prependTo('#datatable-tabletools_wrapper');

        $table.DataTable().buttons().container().prependTo( '#datatable-tabletools_wrapper .dt-buttons' );

        $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
    };
    $(function() {datatableInit();});

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'error'});
}

function sendSuccessResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'error'});
}
