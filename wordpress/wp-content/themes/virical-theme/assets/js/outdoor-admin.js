/**
 * Outdoor Admin JavaScript
 */

jQuery(document).ready(function($) {
    
    // Initialize sortable for sections and products
    if ($('.sortable-list').length) {
        $('.sortable-list').sortable({
            handle: '.drag-handle',
            placeholder: 'ui-sortable-placeholder',
            update: function(event, ui) {
                var type = $(this).attr('id') === 'sections-list' ? 'section' : 'product';
                var order = $(this).sortable('toArray', {attribute: 'data-id'});
                
                $.ajax({
                    url: outdoor_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'reorder_outdoor_items',
                        nonce: outdoor_ajax.nonce,
                        type: type,
                        order: order
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotice('success', response.data.message);
                        }
                    }
                });
            }
        });
    }
    
    // Settings Form Submit
    $('#outdoor-settings-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $spinner = $form.find('.spinner');
        var settings = {};
        
        // Collect all form data
        $form.find('input, textarea, select').each(function() {
            var $field = $(this);
            var name = $field.attr('name');
            
            if (!name) return;
            
            if ($field.attr('type') === 'checkbox') {
                settings[name] = $field.is(':checked') ? '1' : '0';
            } else {
                settings[name] = $field.val();
            }
        });
        
        $spinner.addClass('is-active');
        
        $.ajax({
            url: outdoor_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'save_outdoor_settings',
                nonce: outdoor_ajax.nonce,
                settings: settings
            },
            success: function(response) {
                $spinner.removeClass('is-active');
                if (response.success) {
                    showNotice('success', response.data.message);
                } else {
                    showNotice('error', response.data.message || 'Error saving settings');
                }
            },
            error: function() {
                $spinner.removeClass('is-active');
                showNotice('error', 'Error saving settings');
            }
        });
    });
    
    // Add/Edit Section Modal
    $('.add-section-btn').on('click', function() {
        openSectionModal();
    });
    
    $('.edit-section-btn').on('click', function() {
        var sectionId = $(this).data('id');
        var $row = $(this).closest('tr');
        
        openSectionModal({
            id: sectionId,
            section_name: $row.find('td:eq(1)').text(),
            section_title: $row.find('td:eq(2)').text(),
            section_subtitle: $row.find('td:eq(3)').text(),
            is_active: $row.find('.status-badge').hasClass('active') ? 1 : 0
        });
    });
    
    // Delete Section
    $('.delete-section-btn').on('click', function() {
        if (!confirm('Are you sure you want to delete this section?')) {
            return;
        }
        
        var sectionId = $(this).data('id');
        var $row = $(this).closest('tr');
        
        $.ajax({
            url: outdoor_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'delete_outdoor_section',
                nonce: outdoor_ajax.nonce,
                section_id: sectionId
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(function() {
                        $(this).remove();
                    });
                    showNotice('success', response.data.message);
                } else {
                    showNotice('error', response.data.message);
                }
            }
        });
    });
    
    // Section Form Submit
    $('#section-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'save_outdoor_section',
            nonce: outdoor_ajax.nonce,
            section_id: $('#section_id').val(),
            section_name: $('#section_name').val(),
            section_title: $('#section_title').val(),
            section_subtitle: $('#section_subtitle').val(),
            is_active: $('#section_active').is(':checked') ? 1 : 0
        };
        
        $.ajax({
            url: outdoor_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    closeModal('#section-modal');
                    showNotice('success', response.data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showNotice('error', response.data.message || 'Error saving section');
                }
            }
        });
    });
    
    // Add/Edit Product Modal
    $('.add-product-btn').on('click', function() {
        openProductModal();
    });
    
    $('.edit-product-btn').on('click', function() {
        var productId = $(this).data('id');
        var $row = $(this).closest('tr');
        
        // Get product data from the row
        var productData = {
            id: productId,
            section_id: $row.data('section'),
            product_name: $row.find('td:eq(2) strong').text(),
            product_description: $row.find('td:eq(4)').text(),
            product_image: $row.find('td:eq(1) img').attr('src') || '',
            is_featured: $row.find('td:eq(5) .dashicons-star-filled').length > 0 ? 1 : 0,
            is_active: $row.find('.status-badge').hasClass('active') ? 1 : 0
        };
        
        openProductModal(productData);
    });
    
    // Delete Product
    $('.delete-product-btn').on('click', function() {
        if (!confirm('Are you sure you want to delete this product?')) {
            return;
        }
        
        var productId = $(this).data('id');
        var $row = $(this).closest('tr');
        
        $.ajax({
            url: outdoor_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'delete_outdoor_product',
                nonce: outdoor_ajax.nonce,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(function() {
                        $(this).remove();
                    });
                    showNotice('success', response.data.message);
                } else {
                    showNotice('error', response.data.message);
                }
            }
        });
    });
    
    // Product Form Submit
    $('#product-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'save_outdoor_product',
            nonce: outdoor_ajax.nonce,
            product_id: $('#product_id').val(),
            section_id: $('#product_section').val(),
            product_name: $('#product_name').val(),
            product_description: $('#product_description').val(),
            product_image: $('#product_image').val(),
            is_featured: $('#product_featured').is(':checked') ? 1 : 0,
            is_active: $('#product_active').is(':checked') ? 1 : 0
        };
        
        $.ajax({
            url: outdoor_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    closeModal('#product-modal');
                    showNotice('success', response.data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showNotice('error', response.data.message || 'Error saving product');
                }
            }
        });
    });
    
    // Filter Products by Section
    $('#filter-section').on('change', function() {
        var sectionId = $(this).val();
        
        if (sectionId === '') {
            $('.product-row').show();
        } else {
            $('.product-row').hide();
            $('.product-row[data-section="' + sectionId + '"]').show();
        }
    });
    
    // Image Upload Functionality
    $('.upload-image-btn').on('click', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var fieldId = $button.data('field');
        var $field = $('#' + fieldId);
        var $preview = $('#' + fieldId + '_preview');
        var $removeBtn = $button.siblings('.remove-image-btn');
        
        // Create media frame
        var mediaFrame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        
        // When an image is selected
        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            
            // Set the field value
            $field.val(attachment.url);
            
            // Update preview
            $preview.html('<img src="' + attachment.url + '" />');
            
            // Show remove button
            $removeBtn.show();
        });
        
        // Open the media frame
        mediaFrame.open();
    });
    
    // Remove Image
    $('.remove-image-btn').on('click', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var fieldId = $button.data('field');
        var $field = $('#' + fieldId);
        var $preview = $('#' + fieldId + '_preview');
        
        // Clear field and preview
        $field.val('');
        $preview.empty();
        
        // Hide remove button
        $button.hide();
    });
    
    // Modal Functions
    function openSectionModal(data) {
        data = data || {};
        
        $('#section-modal-title').text(data.id ? 'Edit Section' : 'Add Section');
        $('#section_id').val(data.id || '');
        $('#section_name').val(data.section_name || '');
        $('#section_title').val(data.section_title || '');
        $('#section_subtitle').val(data.section_subtitle || '');
        $('#section_active').prop('checked', data.is_active !== 0);
        
        $('#section-modal').addClass('active').show();
    }
    
    function openProductModal(data) {
        data = data || {};
        
        $('#product-modal-title').text(data.id ? 'Edit Product' : 'Add Product');
        $('#product_id').val(data.id || '');
        $('#product_section').val(data.section_id || '');
        $('#product_name').val(data.product_name || '');
        $('#product_description').val(data.product_description || '');
        $('#product_image').val(data.product_image || '');
        $('#product_featured').prop('checked', data.is_featured == 1);
        $('#product_active').prop('checked', data.is_active !== 0);
        
        // Update image preview
        var $preview = $('#product_image_preview');
        var $removeBtn = $('.remove-image-btn[data-field="product_image"]');
        
        if (data.product_image) {
            $preview.html('<img src="' + data.product_image + '" />');
            $removeBtn.show();
        } else {
            $preview.empty();
            $removeBtn.hide();
        }
        
        $('#product-modal').addClass('active').show();
    }
    
    function closeModal(selector) {
        $(selector).removeClass('active').hide();
    }
    
    // Close modal handlers
    $('.close-modal, .cancel-modal').on('click', function() {
        closeModal($(this).closest('.outdoor-modal'));
    });
    
    // Close modal on outside click
    $('.outdoor-modal').on('click', function(e) {
        if (e.target === this) {
            closeModal(this);
        }
    });
    
    // Show Notice Function
    function showNotice(type, message) {
        var $notice = $('<div class="outdoor-notice ' + type + '">' + message + '</div>');
        
        $('.outdoor-admin-wrap').prepend($notice);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Initialize on page load
    $(window).on('load', function() {
        // Check for any messages in URL params
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('message')) {
            showNotice('success', decodeURIComponent(urlParams.get('message')));
        }
    });
    
});