
/** Change state of css class properties to fade individual images **/

function fader() {
    var $active = $('#fader IMG.active');

    if ( $active.length == 0 ) $active = $('#fader IMG:last');

    var $next =  $active.next().length ? $active.next()
        : $('#fader IMG:first');

    $active.addClass('lastActive');
        
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active lastActive');
        });
}


$(function() {
    setInterval( "fader()", 5000 );    
});

