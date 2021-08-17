(function($){
$(document).on('click', 'input[name="rating"]', function() {
    console.log($(this).val());

    $('.rating-value').text($(this).val())
});


}, jQuery);