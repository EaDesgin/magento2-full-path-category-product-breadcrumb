require([
    "jquery"
], function ($) {
    $(document).ready(function () {
        var newbreadcrumb = $('.replacebreadcrumbs').html();
        $('.breadcrumbs').hide();
        $(".replacebreadcrumbs").prependTo("#maincontent");
        $('.replacebreadcrumbs').fadeIn();
    });
});