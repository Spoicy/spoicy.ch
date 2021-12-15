$('input[type=radio]').change(function() {
    var string = $('input[name=first]:checked').val() + $('input[name=second]:checked').val();
    $('.currsel').text(string);
    console.log(string);
});