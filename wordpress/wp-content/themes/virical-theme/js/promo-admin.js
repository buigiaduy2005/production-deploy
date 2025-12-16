jQuery(document).ready(function ($) {
    // Media uploader
    $('.upload-button').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var targetId = button.data('target');
        var mediaType = button.data('type'); // 'image' or 'video'
        var targetInput = $('#' + targetId);
        var previewContainer = button.siblings(mediaType === 'video' ? '.video-preview' : '.image-preview');

        var mediaUploader = wp.media({
            title: mediaType === 'video' ? 'Chọn video' : 'Chọn hình ảnh',
            button: {
                text: mediaType === 'video' ? 'Sử dụng video này' : 'Sử dụng hình ảnh này'
            },
            library: {
                type: mediaType === 'video' ? 'video' : 'image'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            targetInput.val(attachment.url);

            // Update or create preview
            if (mediaType === 'video') {
                if (previewContainer.length) {
                    previewContainer.find('source').attr('src', attachment.url);
                    previewContainer.find('video')[0].load();
                } else {
                    button.after('<div class="video-preview"><video width="300" controls><source src="' + attachment.url + '" type="video/mp4">Your browser does not support the video tag.</video></div>');
                }
            } else {
                if (previewContainer.length) {
                    previewContainer.find('img').attr('src', attachment.url);
                } else {
                    button.after('<div class="image-preview"><img src="' + attachment.url + '" alt="Preview"></div>');
                }
            }
        });

        mediaUploader.open();
    });

    // Toggle image/video field based on type selection
    $('.promo-type-select').on('change', function () {
        var type = $(this).val();
        var container = $(this).closest('.promo-item-form');
        var imageRow = container.find('.image-row');
        var videoRow = container.find('.video-row');

        if (type === 'image') {
            imageRow.show();
            videoRow.hide();
        } else if (type === 'video') {
            imageRow.hide();
            videoRow.show();
        } else {
            imageRow.hide();
            videoRow.hide();
        }
    });
});
