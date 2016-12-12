var body          = $('body');
var table_wrapper = $('#table-wrapper');

// $(document).mouseup(function (e)
// {
//     var container = $(".popup-form");
//
//     if (!container.is(e.target)
//         && container.has(e.target).length === 0)
//     {
//         container.css('display', 'none');
//     }
// });

// Loading gears

$(window).load(function() {
    // Animate loader off screen
    body.hide();
    $(".se-pre-con").delay(300).fadeOut(100);
    body.show().fadeIn(500);
});

// Event messages

$(document).ready(function(){
    $(".event-success").delay(3500).animate({ height: 0, opacity: 0 }, 'fast');
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
    var form = $('#new-user form')[0];
    $('.popup-form').css('display', 'none');
    var id = $(this).attr('data-id');
    $('#' + id).css('display', 'block');
    form.reset();
});

// CLOSE POPUP
$(document).on('click', '.popup-form-close', function(e){
   e.preventDefault();
   $('.popup-form').css({display: 'none'});
});

////////////////////////////////////////////
// POPUP FORM AJAX
////////////////////////////////////////////
var data = {};

$(document).ready(function() {
    $('.submit-form').on('click', function(e) {
        resetErrors();
        e.preventDefault();
        var form         = this.form,
            url          = form.action,
            data_url     = $(form).attr('data-url'),
            data         = $(form).serialize(),
            success_mesg = $('input[name=success]').val(),
            error_mesg   = $('input[name=error]').val(),
            ajax_success = $('.ajax-success');
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
                    ////////////////////////////////////////////
                    ajax_success.html(success_mesg).show();
                    window.setTimeout(function () {
                        ajax_success.animate({
                            height: 0,
                            opacity: 0
                        }, 200);
                    }, 3500);
                    ////////////////////////////////////////////
                    window.setTimeout(function () {
                        ajax_success
                            .hide()
                            .css({
                                height: '',
                                opacity: ''
                            });
                    }, 3800);
                    ////////////////////////////////////////////
                    $.ajax({
                        dataType: 'html',
                        type: 'POST',
                        url: data_url,
                        success: function (html_response) {
                            table_wrapper.html(html_response);
                        }
                    });
                    ////////////////////////////////////////////
                } else {
                    $.each(resp, function(i, v) {
                        var label = $("label[for='"+i+"']");
                        label.html(v);
                        label.addClass('input-error-label')
                        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('input-error');
                    });
                    var keys = Object.keys(resp);
                    $('input[name="'+keys[0]+'"]').focus();
                }
                ////////////////////////////////////////////
            },
            error: function() {
                console.log('Error');
            }
        });
        return false;
    });
});
////////////////////////////////////////////
function resetErrors() {
    $('form input, form select').removeClass('input-error');
    $('form label').removeClass('.input-error-label');
}


/// ------------------------  Users ------------------ \\\

body.on('click', '.user-delete', function(e) {
    e.preventDefault();
    var url  = $(this).attr('href');
    var data = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: url,
        data: {id:data},
        success: function (response) {
            table_wrapper.html(response);
        }
    });

});