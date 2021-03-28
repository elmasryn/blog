//admin/messages/messages
function multi_check() {
    $(function () {
        //Enable check and uncheck all functionality
        $('.checkbox-toggle').click(function () {
            var clicks = $(this).data('clicks')
            if (clicks) {
                //Uncheck all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
            } else {
                //Check all checkboxes
                $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
            }
            $(this).data('clicks', !clicks)
        })

    })
}

//admin/messages/trash
function force_del_multi() {
    $(document).ready(function () {
        $('.del_multi').click(function () {
            $('#del_form').attr("action", $('#del_form').attr("action") + "forcedestroy");
            $('#my_input').attr("name", "force");
            $("input[name=_method]").attr("value", "DELETE");
            $('#del_form').submit();
        });
    })
    $(document).on('click', '.delBtn', function () {
        var checked = $('.item_checkbox:checked').length;
        if (checked > 0) {
            $('.yes_check').removeClass('d-none');
            $('.no_check').addClass('d-none');
        } else {
            $('.yes_check').addClass('d-none');
            $('.no_check').removeClass('d-none');
        }
        $('#multidestroy').modal('show');
    });
}

//admin/messages/inbox ,read, unread, trash, messages_department
function del_multi() {
    $(document).ready(function () {
        $('.del_multi').click(function () {
            $('#del_form').attr("action", $('#del_form').attr("action") + "multidestroy");
            $('#del_form_dep').attr("action", "../messages/multidestroy");
            $('#my_input').attr("name", "destroy");
            $("input[name=_method]").attr("value", "DELETE");
            $('#del_form').submit();
            $('#del_form_dep').submit();
        });
    })
    $(document).on('click', '.delBtn', function () {
        var checked = $('.item_checkbox:checked').length;
        if (checked > 0) {
            $('.yes_check').removeClass('d-none');
            $('.no_check').addClass('d-none');
        } else {
            $('.yes_check').addClass('d-none');
            $('.no_check').removeClass('d-none');
        }
        $('#multidestroy').modal('show');
    });
}

//admin/messages/inbox ,read, messages_department
function mark() {
    $(document).ready(function () {
        $('.markBtn').click(function () {
            $('#del_form').attr("action", $('#del_form').attr("action") + "multiMark");
            $('#del_form_dep').attr("action", "../messages/multiMark");
            $('#my_input').attr("name", "mark");
            $("input[name=_method]").attr("value", "PUT");
            $('#del_form , #del_form_dep').submit();
        });
    })
}


//admin/messages/inbox ,read, unread, trash, messages_department
function refresh() {
    $(document).ready(function () {
        $(".refresh").click(function () {
            $(".mailbox-messages").load(" .mailbox-messages");
        });
    });
}



//admin/messages/restore (trash)
function restore() {
    $(document).ready(function () {
        $('.restoreBtn').click(function () {
            $('#del_form').attr("action", $('#del_form').attr("action") + "multirestore");
            $('#my_input').attr("name", "restore");
            $("input[name=_method]").attr("value", "PUT");
            $('#del_form').submit();
        });
    })
}

//admin/messages/block_search
function search() {
    $(document).ready(function () {
        $(".mySearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".table tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
}

//admin/settings
function show_comment_message() {
    $(document).on('change', '.comment_status', function () {
        if ($('.comment_status option:selected').val() == '0') {
            $('.comment_message').removeClass('d-none');
        } else {
            $('.comment_message').addClass('d-none');
        }
    });
}

//admin/settings
function show_website_message() {
    $(document).on('change', '.website_status', function () {
        if ($('.website_status option:selected').val() == '0') {
            $('.website_message').removeClass('d-none');
        } else {
            $('.website_message').addClass('d-none');
        }
    });
}

//admin/categories
function check_all() {
    $('input[class="item_checkbox"]:checkbox').each(function () {
        if ($('input[class="check_all"]:checkbox:checked').length == 0) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }
    });
}

//admin/categories
function multidestroy() {
    $(document).ready(function () {
        $('.del_multi').click(function () {
            $('#del_form').submit();
        });
    })
    $(document).on('click', '.delBtn', function () {
        var checked = $('.item_checkbox:checked').length;
        if (checked > 0) {
            $('.yes_check').removeClass('d-none');
            $('.no_check').addClass('d-none');
        } else {
            $('.yes_check').addClass('d-none');
            $('.no_check').removeClass('d-none');
        }
        $('#multidestroy').modal('show');
    });
}

////////////////////////////////////////////Front End///////////////////////////////////////////////

//index
function animation() {
    $(document).ready(function () {
        $('.card-img-top , .img-thumbnail , .media img').mouseover(function () {
            $(this).animate({ padding: "+=10px" }).animate({ padding: "-=10px" });
        });
    })
}

//post (comments)
function publishComment() {
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on("click", '.publish', function () {
            $.ajax({
                /* the route pointing to the post function */
                url: 'publishComment',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { _token: CSRF_TOKEN, message: $(this).attr('commentStatus'), id: $(this).attr('commentId') },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: "top-end",
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        $(".comment-widgets").load(" .comment-widgets");
                    }
                }
            });
        });
    })
}

//post
function publishPost() {
    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on("click", '.publish', function () {
            $.ajax({
                /* the route pointing to the post function */
                url: 'publishPost',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { _token: CSRF_TOKEN, message: $(this).attr('postStatus'), id: $(this).attr('postId') },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: "top-end",
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        $(".post-widgets").load(" .post-widgets");
                        $(".post-alert").load(" .post-alert");
                    }
                }
            });
        });
    })
}

//post (comments)
function editComment() {
    $(document).ready(function () {
        $(document).on('click', '.editCommentBtn', function (e) {
            e.preventDefault();
            $(this).parent().next('form').toggleClass("d-none");
        });
    })
}

//postCreate
function tagsSelect2() {
    $(document).ready(function() {
        $(".tagsSelect2").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
    });
}


































// function check_all(){
// $('#master').on('click', function(e) {

//     if($(this).is(':checked',true))

//     {

//        $(".sub_chk").prop('checked', true);

//     } else {

//        $(".sub_chk").prop('checked',false);

//     }

//    });
// }

