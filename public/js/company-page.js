(function ($, F) {
    F.transitions.resizeIn = function() {
        var previous = F.previous,
            current  = F.current,
            startPos = previous.wrap.stop(true).position(),
            endPos   = $.extend({opacity : 1}, current.pos);

        startPos.width  = previous.wrap.width();
        startPos.height = previous.wrap.height();

        previous.wrap.stop(true).trigger('onReset').remove();

        delete endPos.position;

        current.inner.hide();

        current.wrap.css(startPos).animate(endPos, {
            duration : current.nextSpeed,
            easing   : current.nextEasing,
            step     : F.transitions.step,
            complete : function() {
                F._afterZoomIn();

                current.inner.fadeIn("fast");
            }
        });
    };

}(jQuery, jQuery.fancybox));

$(document).ready(function() {

    $(".fancybox")
        .attr('rel', 'gallery')
        .fancybox({
            nextMethod : 'resizeIn',
            nextSpeed  : 250,
            
            prevMethod : false,
            
        });
});