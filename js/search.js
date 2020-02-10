function open_search() {
    $('#search-wrap').removeClass('invisible');
    $('#search-input').focus();
}
function close_search() {
    $('#search-wrap').addClass('invisible');
}
$(document).ready(function () {
    $(".hamburger").click(function () {
        $(".sidebar").toggleClass("is-active");
        $(".shade").toggleClass("is-active");
    });
    $(".shade").click(function () {
        $(this).toggleClass("is-active");
        $(".sidebar").toggleClass("is-active");
    });
});