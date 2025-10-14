/**
 * Indoor Admin JavaScript
 * Handles all admin functionality for Indoor management
 */

jQuery(document).ready(function($) {
    
    // Image Upload Handler
    $('.upload-image-btn').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var targetInput = $(button.data('target'));
        var previewContainer = $(button.data('preview'));
        
        // Create media frame
        var mediaFrame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        
        // When image is selected
        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            targetInput.val(attachment.url);
            previewContainer.html('<img src="' + attachment.url + '" alt="Preview" />');
        });
        
        // Open media frame
        mediaFrame.open();
    });
    
    // Remove Image Handler
    $('.remove-image-btn').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var targetInput = $(button.data('target'));
        var previewContainer = $(button.data('preview'));
        
        targetInput.val('');
        previewContainer.empty();
    });
    
    // Settings Form Submit
    $('#indoor-settings-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var spinner = form.find('.spinner');
        var notice = form.find('.notice-message');
        
        // Show spinner
        spinner.addClass('is-active');
        submitBtn.prop('disabled', true);
        notice.removeClass('success error').text('');
        
        // Prepare data
        var formData = form.serialize();
        formData += '&action=save_indoor_settings';
        formData += '&nonce=' + indoor_ajax.nonce;
        
        // Send AJAX request
        $.post(indoor_ajax.ajax_url, formData, function(response) {
            spinner.removeClass('is-active');
            submitBtn.prop('disabled', false);
            
            if (response.success) {
                notice.addClass('success').text(response.data.message);
            } else {
                notice.addClass('error').text(response.data.message || 'An error occurred');
            }
            
            // Clear message after 3 seconds
            setTimeout(function() {
                notice.removeClass('success error').text('');
            }, 3000);
        });
    });
    
    // Category Form Submit
    $('#indoor-category-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var spinner = form.find('.spinner');
        var notice = form.find('.notice-message');
        
        // Show spinner
        spinner.addClass('is-active');
        submitBtn.prop('disabled', true);
        notice.removeClass('success error').text('');
        
        // Prepare data
        var formData = form.serialize();
        formData += '&action=save_indoor_category';
        formData += '&nonce=' + indoor_ajax.nonce;
        
        // Send AJAX request
        $.post(indoor_ajax.ajax_url, formData, function(response) {
            spinner.removeClass('is-active');
            submitBtn.prop('disabled', false);
            
            if (response.success) {
                notice.addClass('success').text(response.data.message);
                
                // Reset form and reload page after 1 second
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                notice.addClass('error').text(response.data.message || 'An error occurred');
            }
        });
    });
    
    // Edit Category Button
    $('.edit-category-btn').on('click', function() {
        var btn = $(this);
        var form = $('#indoor-category-form');
        var container = $('.category-form-container');
        
        // Fill form with category data
        $('#category_id').val(btn.data('id'));
        $('#category_name').val(btn.data('name'));
        $('#category_slug').val(btn.data('slug'));
        $('#is_active').val(btn.data('active'));
        
        // Update form title
        $('#category-form-title').text('Edit Category');
        container.addClass('edit-mode');
        
        // Scroll to form
        $('html, body').animate({
            scrollTop: container.offset().top - 50
        }, 500);
    });
    
    // Delete Category Button
    $('.delete-category-btn').on('click', function() {
        var btn = $(this);
        var categoryId = btn.data('id');
        var productCount = btn.data('count');
        
        if (productCount > 0) {
            alert('Cannot delete category with ' + productCount + ' products. Please delete or reassign products first.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this category?')) {
            return;
        }
        
        // Send delete request
        $.post(indoor_ajax.ajax_url, {
            action: 'delete_indoor_category',
            category_id: categoryId,
            nonce: indoor_ajax.nonce
        }, function(response) {
            if (response.success) {
                alert(response.data.message);
                location.reload();
            } else {
                alert(response.data.message || 'An error occurred');
            }
        });
    });
    
    // Product Form Submit
    $('#indoor-product-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var spinner = form.find('.spinner');
        var notice = form.find('.notice-message');
        
        // Show spinner
        spinner.addClass('is-active');
        submitBtn.prop('disabled', true);
        notice.removeClass('success error').text('');
        
        // Prepare data
        var formData = form.serialize();
        formData += '&action=save_indoor_product';
        formData += '&nonce=' + indoor_ajax.nonce;
        
        // Send AJAX request
        $.post(indoor_ajax.ajax_url, formData, function(response) {
            spinner.removeClass('is-active');
            submitBtn.prop('disabled', false);
            
            if (response.success) {
                notice.addClass('success').text(response.data.message);
                
                // Reset form and reload page after 1 second
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                notice.addClass('error').text(response.data.message || 'An error occurred');
            }
        });
    });
    
    // Edit Product Button
    $('.edit-product-btn').on('click', function() {
        var btn = $(this);
        var form = $('#indoor-product-form');
        var container = $('.product-form-container');
        
        // Fill form with product data
        $('#product_id').val(btn.data('id'));
        $('#product_category').val(btn.data('category'));
        $('#product_name').val(btn.data('name'));
        $('#product_slug').val(btn.data('slug'));
        $('#product_link').val(btn.data('link'));
        $('#product_image').val(btn.data('image'));
        $('#product_active').val(btn.data('active'));
        
        // Update image preview
        if (btn.data('image')) {
            $('#product-preview').html('<img src="' + btn.data('image') + '" alt="Preview" />');
        } else {
            $('#product-preview').empty();
        }
        
        // Update form title
        $('#product-form-title').text('Edit Product');
        container.addClass('edit-mode');
        
        // Scroll to form
        $('html, body').animate({
            scrollTop: container.offset().top - 50
        }, 500);
    });
    
    // Delete Product Button
    $('.delete-product-btn').on('click', function() {
        var btn = $(this);
        var productId = btn.data('id');
        
        if (!confirm('Are you sure you want to delete this product?')) {
            return;
        }
        
        // Send delete request
        $.post(indoor_ajax.ajax_url, {
            action: 'delete_indoor_product',
            product_id: productId,
            nonce: indoor_ajax.nonce
        }, function(response) {
            if (response.success) {
                alert(response.data.message);
                location.reload();
            } else {
                alert(response.data.message || 'An error occurred');
            }
        });
    });
    
    // Cancel Edit Button
    $('.cancel-edit-btn').on('click', function() {
        var form = $(this).closest('form');
        var container = form.parent();
        
        // Reset form
        form[0].reset();
        
        // Clear hidden fields
        form.find('input[type="hidden"]').val('');
        
        // Clear image preview
        form.find('.image-preview').empty();
        
        // Update title
        if (container.hasClass('category-form-container')) {
            $('#category-form-title').text('Add New Category');
        } else {
            $('#product-form-title').text('Add New Product');
        }
        
        // Remove edit mode
        container.removeClass('edit-mode');
    });
    
    // Category Filter for Products
    $('#category-filter').on('change', function() {
        var selectedCategory = $(this).val();
        var rows = $('.product-row');
        
        if (selectedCategory === '') {
            // Show all products
            rows.removeClass('hidden');
        } else {
            // Show only products from selected category
            rows.each(function() {
                var row = $(this);
                if (row.data('category') == selectedCategory) {
                    row.removeClass('hidden');
                } else {
                    row.addClass('hidden');
                }
            });
        }
    });
    
    // Make categories sortable
    $('#categories-list').sortable({
        handle: '.drag-handle',
        placeholder: 'ui-sortable-placeholder',
        update: function(event, ui) {
            var order = [];
            
            $('#categories-list tr').each(function() {
                order.push($(this).data('id'));
            });
            
            // Send new order to server
            $.post(indoor_ajax.ajax_url, {
                action: 'reorder_indoor_items',
                type: 'category',
                order: order,
                nonce: indoor_ajax.nonce
            }, function(response) {
                if (response.success) {
                    // Show brief success message
                    var notice = $('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                    $('.indoor-admin-wrap h1').after(notice);
                    
                    setTimeout(function() {
                        notice.fadeOut(function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
        }
    });
    
    // Make products sortable within their category
    $('#products-list').sortable({
        handle: '.drag-handle',
        placeholder: 'ui-sortable-placeholder',
        items: 'tr:not(.hidden)',
        update: function(event, ui) {
            var order = [];
            
            $('#products-list tr:not(.hidden)').each(function() {
                order.push($(this).data('id'));
            });
            
            // Send new order to server
            $.post(indoor_ajax.ajax_url, {
                action: 'reorder_indoor_items',
                type: 'product',
                order: order,
                nonce: indoor_ajax.nonce
            }, function(response) {
                if (response.success) {
                    // Show brief success message
                    var notice = $('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                    $('.indoor-admin-wrap h1').after(notice);
                    
                    setTimeout(function() {
                        notice.fadeOut(function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
        }
    });
    
    // Auto-generate slug from name
    $('#category_name').on('blur', function() {
        var name = $(this).val();
        var slugField = $('#category_slug');
        
        if (name && !slugField.val()) {
            // Simple slug generation
            var slug = name.toLowerCase()
                          .replace(/[^a-z0-9\s-]/g, '')
                          .replace(/\s+/g, '-')
                          .replace(/-+/g, '-');
            slugField.val(slug);
        }
    });
    
    $('#product_name').on('blur', function() {
        var name = $(this).val();
        var slugField = $('#product_slug');
        
        if (name && !slugField.val()) {
            // Simple slug generation
            var slug = name.toLowerCase()
                          .replace(/[^a-z0-9\s-]/g, '')
                          .replace(/\s+/g, '-')
                          .replace(/-+/g, '-');
            slugField.val(slug);
        }
    });
    
    // Initialize tooltips if available
    if ($.fn.tooltip) {
        $('.help-tip').tooltip();
    }
});