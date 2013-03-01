$(function() {
  $('.file_info').on('click', '.file_remove', function(e) {
    e.preventDefault();
    var parent = $(this).parent();
    $(parent).siblings('input[type="hidden"]').attr('value', 'dummy');
    $(parent).remove();
    return false;
  });
});