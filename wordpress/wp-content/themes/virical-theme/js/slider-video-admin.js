jQuery(document).ready(function ($) {
    // Video uploader
    $('.upload-video-button').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var targetId = button.data('target');
        var targetInput = $('#' + targetId);
        var previewContainer = $('.video-preview-container');

        var mediaUploader = wp.media({
            title: 'Choose Video',
            button: {
                text: 'Use this video'
            },
            library: {
                type: 'video'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            targetInput.val(attachment.url);

            // Update or create preview
            if (previewContainer.length) {
                previewContainer.find('source').attr('src', attachment.url);
                previewContainer.find('video')[0].load();
            } else {
                var previewHtml = '<div class="video-preview-container">' +
                    '<p><strong>Video Preview:</strong></p>' +
                    '<video width="400" controls>' +
                    '<source src="' + attachment.url + '" type="video/mp4">' +
                    'Your browser does not support the video tag.' +
                    '</video>' +
                    '</div>';
                button.closest('.slider-video-meta-box').find('p.description').before(previewHtml);
            }
        });

        mediaUploader.open();
    });
});
