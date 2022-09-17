jQuery(document).ready(function ($) {
  $("#bt-map").click(function () {
    if ($("#Cm-title").val().length === 0) {
      $("#Cm-title-error")
        .removeClass("errorCefiiMap")
        .addClass("errorCefiiMapDisplay");
    } else if ($("#Cm-latitude").val().length === 0) {
      $("#Cm-lat-error")
        .removeClass("errorCefiiMap")
        .addClass("errorCefiiMapDisplay");
    } else if ($("#Cm-longitude").val().length === 0) {
      $("#Cm-long-error")
        .removeClass("errorCefiiMap")
        .addClass("errorCefiiMapDisplay");
    }
  });
});
