$(document).ready(function() {

    $('.project').hover(
        function() {
            var that = $(this);
            $(this).find('img').fadeTo(500, 0.2, function() {
                if(that.is(':hover')) {
                    that.find('.title, .info, .more').fadeIn();
                }
            });
        }, function() {
            var that = $(this);
            $(this).find('img').fadeTo(500, 1, function() {
                that.find('.title, .info, .more').fadeOut();
            });
        }
    );
});
