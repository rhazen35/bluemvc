var body = $('body');

$(document).mouseup(function (e)
{
    var container = $(".popup-form");

    if (!container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.css('display', 'none');
    }
});

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
    $('.popup-form').css('display', 'none');
    var id = $(this).attr('data-id');
    $('#' + id).css('display', 'block');

});

// CLOSE POPUP
$(document).on('click', '.popup-form-close', function(e){
   e.preventDefault();
    $('.popup-form').css({display: 'none'});

});

(function() {

    var table_wrapper = $('#table-wrapper');
    var ajax_success  = $('.ajax-success');

    body.on('click', '.submit-form', function(e) {
        var form       = this.form,
            url        = form.action,
            data       = $(form).serialize(),
            data_array = $(form).serializeArray();
            success_mesg = $('input[name=success]').val();
            error_mesg   = $('input[name=error]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response)
            {
                form.reset();
                $('.popup-form').fadeOut('fast');
                ajax_success
                    .html(success_mesg)
                    .show();

                window.setTimeout(function () {
                    ajax_success.animate({
                        height: 0,
                        opacity: 0
                    }, 200);
                }, 3500);

                window.setTimeout(function () {
                    ajax_success
                        .hide()
                        .css({
                            height: '',
                            opacity: ''
                        });
                }, 3800);

                table_wrapper.html(response);
            },
            error: function()
            {
                ajax_success
                    .html(data['error'])
                    .show();
            }

        });

        e.preventDefault();

    });

    body.on('click', '#deleteUser', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-url');

        $.get( url, function( data ) {
            $tableWrapper.html( data );
        });

    });

}());



