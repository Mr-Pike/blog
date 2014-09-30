$(document).ready(function() {

    $('.project').hover(function() {
        /*$(this).find('img').fadeTo(500, 0.2);*/
        var that = $(this);
        $(this).find('img').fadeTo(500, 0.2, function() {
            that.find('.title').fadeIn();
            that.find('.info').fadeIn();
            that.find('.more').fadeIn();
        });
    }, function() {
        var that = $(this);
        $(this).find('img').fadeTo(500, 1, function() {
            that.find('.title').fadeOut();
            that.find('.info').fadeOut();
            that.find('.more').fadeOut();
        });
    });
});
