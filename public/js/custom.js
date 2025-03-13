document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
    dropdown.addEventListener('mouseenter', function () {
        this.querySelector('.dropdown-menu').classList.add('show');
    });
    dropdown.addEventListener('mouseleave', function () {
        this.querySelector('.dropdown-menu').classList.remove('show');
    });
});

$(document).ready(function() {
    $('#temaList .list-group-item').click(function() {
        var target = $(this).data('target');
        $('.content-section').removeClass('active');
        $(target).addClass('active');
    });

    function searchContent() {
        var searchText = $('#searchInput').val().toLowerCase();
        
        // Filter content in the sidebar
        var sidebarMatches = 0;
        $('#temaList .list-group-item').each(function() {
            var text = $(this).text().toLowerCase();
            if (text.includes(searchText)) {
                $(this).show();
                sidebarMatches++;
            } else {
                $(this).hide();
            }
        });

        // Filter content in the main section
        var contentSections = $('.content-section');
        contentSections.each(function() {
            var cards = $(this).find('.content-card');
            var sectionMatches = 0;
            cards.each(function() {
                var title = $(this).data('title');
                var description = $(this).data('description');
                if (title.includes(searchText) || description.includes(searchText)) {
                    $(this).show();
                    sectionMatches++;
                } else {
                    $(this).hide();
                }
            });
            if (sectionMatches > 0) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

        // Show no results message if no matches found
        if (sidebarMatches === 0 && $('.content-card:visible').length === 0) {
            $('.no-results').show();
        } else {
            $('.no-results').hide();
        }
    }

    $('#searchButton').click(searchContent);
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            searchContent();
        }
    });
});
