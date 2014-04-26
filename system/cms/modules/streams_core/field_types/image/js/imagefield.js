$(function() {
  $('.image_remove').click(function(e){
    // change the input to cleared so we know its saved
    $(this).siblings('input[type="hidden"]').attr('value', 'dummy');
    // remove the a tag
    $(this).siblings('a').remove();
    // remove this close button
    $(this).remove();
    return false;
  });
});