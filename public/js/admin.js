$(document).ready(function () {
  $("#loader").hide();

  $(document).on("click", ".toggle-sidebar-btn", function () {
    $("body").toggleClass("toggle-sidebar");
  });
});
