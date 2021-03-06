var body          = $('body');
var table_wrapper = $('#table-wrapper');
var ajax_success  = $('.ajax-success');
var ajax_failed   = $('.ajax-failed');

// TOOLTIP

$( function() {
    $( document ).tooltip({
        show: false,
        hide: false,
        position: {
            my: "bottom-30",
            at: "center top",
            using: function( position, feedback ) {
                $( this ).css( position );
                $( "<div>" )
                    .addClass( "arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
            }
        }
    });
} );

// Loading gears

$(window).load(function() {
    // Animate loader off screen
    body.hide();
    $(".se-pre-con").delay(300).fadeOut(100);
    body.show().fadeIn(500);
});

// Event messages

$(document).ready(function(){
    $(".event-success").delay(2000).animate({ height: 0, opacity: 0 }, 'fast');
    $(".event-failed").delay(4500).animate({ height: 0, opacity: 0 }, 'fast');
});

// Go back function

function goBack()
{
    window.history.go(-1);
}

// Menu with dropdown

function menuDropDown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};

// Logout lock image

(function() {

    $('.logout').bind('mouseenter mouseleave', function () {
        $('.logout-img').attr({
            src: $('.logout-img').attr('data-alt-src')
            , 'data-alt-src': $('.logout-img').attr('src')
        })
    });

}());

/// ------------------------  POPUP FORM ------------------ \\\

$(document).on('click', '.popup-form-link', function(e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    var form    = $('.popup-form-form[data-id="' + data_id + '"]')[0];
    $('.popup-form').css('display', 'none');
    $('form input, form select').removeClass('input-error');
    $('.popup-form-section label span').html('');
    $('#' + data_id).css('display', 'block');
    $('.popup-form-form[data-id="' + data_id + '"] :input:enabled:visible:first').focus();
    form.reset();
});

// CLOSE POPUP
$(document).on('click', '.popup-form-close, .popup-form-delete-cancel', function(e){
   e.preventDefault();
    $('form input, form select').removeClass('input-error');
    $('.popup-form-section label span').html('');
    $('.popup-form').css({display: 'none'});
});

////////////////////////////////////////////
// POPUP FORM AJAX
////////////////////////////////////////////
var data = {};

$(document).on('click', '.submit-form', function(e) {
    resetErrors();
    e.preventDefault();
    var form         = this.form,
        url          = form.action,
        data_url     = $(form).attr('data-url'),
        data         = $(form).serialize(),
        success_mesg = $(form).find("input[name='success']").val(),
        error_mesg   = $(form).find("input[name='error']").val();
    ////////////////////////////////////////////
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: url,
        data: data,
        success: function(resp) {
            if ( resp === true ) {
                form.reset();
                $('.popup-form').fadeOut('fast');
                popup_message_timeout( ajax_success, success_mesg );
                $.ajax({
                    dataType: 'html',
                    type: 'POST',
                    url: data_url,
                    data: data,
                    success: function (html_response) {
                        table_wrapper.html(html_response);
                    }
                });
                ////////////////////////////////////////////
            } else {
                $.each(resp, function(i, v) {
                    var label = $("label[for='"+i+"'] span");
                    label.html(v);
                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('input-error');
                });
                var keys = Object.keys(resp);
                $('input[name="'+keys[0]+'"]').focus();
                popup_message_timeout( ajax_failed, error_mesg );
            }
            ////////////////////////////////////////////
        },
        error: function() {

        }
    });
    return false;
});
////////////////////////////////////////////
function resetErrors() {
    $('form input, form select').removeClass('input-error');
    $('.popup-form-section label span').html('');
}
////////////////////////////////////////////
function popup_message_timeout( element, message ) {
    element.html(message).show();
    window.setTimeout(function () {
        element.animate({
            height: 0,
            opacity: 0
        }, 200);
    }, 3500);
    window.setTimeout(function () {
        element
            .hide()
            .css({
                height: '',
                opacity: ''
            });
    }, 3800);
}
////////////////////////////////////////////
// POPUP FORM DELETE

body.on('click', '.popup-form-delete', function(e) {
    e.preventDefault();
    var form         = this.form;
    var url          = form.action;
    var data         = $(form).find("input[name='id']").val();
    var data_url     = $(form).attr('data-url');
    var text         = $(form).attr('data-text');
    var success_mesg = $(form).find("input[name='success']").val();
    var error_mesg   = $(form).find("input[name='error']").val();

    $.ajax({
        dataType: 'json',
        type: "POST",
        url: url,
        data: {id:data},
        success: function (response) {
            if( response === true ) {
                popup_message_timeout(ajax_success, success_mesg);
                $.ajax({
                    dataType: 'html',
                    type: 'POST',
                    url: data_url,
                    data: {page:page},
                    success: function (html_response) {
                        table_wrapper.html(html_response);
                    }
                });
            } else {
                popup_message_timeout(ajax_failed, error_mesg);
            }
        }
    });

});

///////////////////////////////////////////////////////////////

// PAGINATION

$(document).on('click', '.paginate', function(e){
   e.preventDefault();
   var page = $(this).attr('data-page');
   var url  = $(this).attr('data-url');
    $.ajax({
        dataType: 'html',
        type: 'POST',
        url: url,
        data: {page:page},
        success: function (response) {
            table_wrapper.html(response);
        }
    });
});