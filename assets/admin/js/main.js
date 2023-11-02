(function($) {
    $(document).ready(function() {
        if ( $('.tpquizdeluxe-filter-cat').length > 0 ) {
            $('.cat-filter-button').on('click', function() {
                var filter,
                catID = $(this).parent().find('select').val(),
                link = location.href,
                filterName = 'cat-id'
                if( catID != '' ){
                    filter = "&" + filterName + "=" + catID
                    var linkModifiedStart = link.split('?')[0]
                    var linkModified = link.split('?')[1].split('&')
                    for(var i = 0; i < linkModified.length; i++){
                        if(linkModified[i].split("=")[0] == filterName){
                            linkModified.splice(i, 1)
                        }
                    }
                    linkModified = linkModified.join('&')
                    // console.log(linkModifiedStart + "?" + linkModified + filter)
                    document.location.href = linkModifiedStart + "?" + linkModified + filter;
                } else {
                    var linkModifiedStart = link.split('?')[0]
                    var linkModified = link.split('?')[1].split('&')
                    for(var i = 0; i < linkModified.length; i++){
                        if(linkModified[i].split("=")[0] == filterName){
                            linkModified.splice(i, 1)
                        }
                    }
                    linkModified = linkModified.join('&')
                    // console.log(linkModifiedStart + "?" + linkModified + filter)
                    document.location.href = linkModifiedStart + "?" + linkModified;
                }
            })
        }
    })
}) (jQuery)