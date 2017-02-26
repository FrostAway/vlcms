(function ($) {
    
    $('#top_menu .dropdown a').on('click', function () {
        var href = $(this).attr('href');
        window.location.href = href;
    });
    $('#top_menu .dropdown').on('mouseover', function () {
        $(this).addClass('open');
    }).on('mouseleave', function () {
        $(this).removeClass('open');
    });
    
    $('body').on('click', '._preview_btn', function (e) {
        e.preventDefault();
        var link = $(this).closest('._preview_group').find('._preview_link').val();
        var post_link = $(this).attr('post-link');
        var preview = $($(this).attr('data-target'));
        if (link.trim() != '') {
            $.ajax({
                url: post_link,
                type: 'POST',
                data: {
                    link: link,
                    _token: _token
                },
                success: function (data) {
                    preview.removeClass('hidden');
                    preview.find('._preview_thumb').attr('src', data.thumbnail);
                    preview.find('._preview_video_id').val(data.video_id);
                    preview.find('._preview_name').val(data.name);
                    preview.find('._preview_desc').val(data.description);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    });
    
})(jQuery);


