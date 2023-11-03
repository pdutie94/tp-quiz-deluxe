(function($) {
    $(document).ready(function() {
        var tabList = $('.tpquizdeluxe-tablist');
        var tabContent = $('.tpquizdeluxe-tabcontent');
        if ( tabList.length > 0 && tabContent.length > 0) {
            var tabItems = tabList.find('.nav-tab')
            tabItems.on('click', function() {
                var currTabItem = $(this)
                var tabContentID = currTabItem.data('tab')
                
                tabItems.removeClass('nav-tab-active')
                tabContent.find('.tpquizdeluxe-tab-content').removeClass('active')

                currTabItem.addClass('nav-tab-active')
                tabContent.find('#' + tabContentID).addClass('active')
            })
        }
    })
}) (jQuery)