function initSelection(gridId, buttonClass, checkboxName) {
  var button = $('.' + buttonClass);
  $('input[name="'+ checkboxName +'"], input[name="'+ checkboxName.slice(0, -2) +'_all"]').change(function() {
    var keys = $('#' + gridId).yiiGridView('getSelectedRows');
    button.attr('data-alert', keys);
    if (keys.length > 0) {
      button.removeClass('disabled');
    } else {
      button.addClass('disabled');
    }
  });
}
