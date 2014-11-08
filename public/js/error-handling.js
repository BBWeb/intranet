;(function($) {

  window.onerror = function (msg, url, lineNumber) {
    var n = noty({
      text: msg,
      type: 'warning',
      layout: 'top'
    });

    return true;
  };

})(jQuery);
