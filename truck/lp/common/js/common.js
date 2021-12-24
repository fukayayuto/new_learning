
$(function() {
    let scrollTop = 0;
    $(document).on("click", ".js-modal-open", function() {
        scrollTop = $(window).scrollTop();
        $("body").css({
            position: "fixed",
            top: -1 * scrollTop
        });
        var target = $(this).data("target");
        var modal = document.getElementById(target);
        $(modal).fadeIn();
        return false;
    });
    $(".js-modal-close").on("click", function() {
        $("body").css({
            position: "static"
        });
        $("html, body").prop({ scrollTop: scrollTop });
        $(".js-modal").fadeOut();
        return false;
    });
});