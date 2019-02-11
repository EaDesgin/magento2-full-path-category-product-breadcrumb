require([
    "jquery"
], function ($) {
    $(document).ready(function () {
        var newbreadcrumb = $('.replacebreadcrumbs').html();
        $('.breadcrumbs').hide().after('<div class="breadcrumbs">'+newbreadcrumb+'</div>');
        $('.breadcrumbs').hide();
        $('.replacebreadcrumbs').fadeIn();
    });
});