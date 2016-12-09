var body = $('body');

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

// Users

$(document).on('click', '.edit-user-link', function(e) {
    e.preventDefault();
    $('.popup-form').css('display', 'none');
    var id = $(this).attr('data-id');
    $('#' + id).css('display', 'block');

});

$(document).on('click', '.popup-form-close', function(e){
   e.preventDefault();
    $('.popup-form').css({display: 'none'});

});

(function() {

    var $tableWrapper = $('#stage-table-wrapper');

    body.on('change', '#updateUser', function(e) {
        var url = this.form.action,
            data = $(this.form).serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response)
            {
                $tableWrapper.html(response);
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



