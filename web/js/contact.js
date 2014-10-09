$(document).ready(function() {

    // Validate contact form.
    $('#contact').on('submit', function(e) {
        e.preventDefault();

        var alertSuccess = $('#contactForm .alert-success'),
            alertDanger = $('#contactForm .alert-danger'),
            data = $(this).serialize();

        alertSuccess.hide();
        alertDanger.hide();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            encoding: 'utf-8',
            dataType: 'json',
            success: function(response) {
                if(response['send'] == '1') {
                    alertSuccess.show();
                    $('form#contact :input').each(function(){
                        $(this).val('');
                    });
                } else {
                    alertDanger.find('span#errors').html('&nbsp;&nbsp;' + response['errors']);
                    alertDanger.show();
                }
            }
        });
    });

});