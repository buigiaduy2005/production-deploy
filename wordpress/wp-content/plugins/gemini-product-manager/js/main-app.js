jQuery(document).ready(function($) {
    // ====[ Global Variables & Elements ]====
    const productTableBody = $('#gpm-product-table tbody');
    const formContainer = $('#gpm-edit-form-container');
    const listContainer = $('.gpm-product-list-container');
    const productForm = $('#gpm-product-form');
    const formTitle = $('#gpm-form-title');
    const productIdField = $('#gpm-product-id');
    const galleryContainer = $('#gpm-gallery-container');
    const galleryIdsField = $('#gpm-product-gallery-ids');
    let mediaFrame;

    // ====[ Main Product Loading Function ]====
    function loadProducts() {
        productTableBody.html('<tr><td colspan="8">Đang tải sản phẩm...</td></tr>');
        $.ajax({
            url: gpm_ajax.ajax_url, type: 'POST', data: { action: 'gpm_get_products', nonce: gpm_ajax.nonce },
            success: function(response) {
                productTableBody.empty();
                if (response.success && response.data.length > 0) {
                    response.data.forEach(function(product) {
                        const productRow = `
                            <tr id="product-${product.id}">
                                <td><img src="${product.thumbnail}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"></td>
                                <td><strong>${product.name}</strong></td>
                                <td>${product.classification}</td>
                                <td>${product.categories}</td>
                                <td>${product.stock_status}</td>
                                <td>${product.status}</td>
                                <td>${product.updated_date}</td>
                                <td>
                                    <button class="button edit-product-btn" data-id="${product.id}">Sửa</button>
                                    <button class="button button-link-delete delete-product-btn" data-id="${product.id}">Xóa</button>
                                </td>
                            </tr>`;
                        productTableBody.append(productRow);
                    });
                } else {
                    productTableBody.html('<tr><td colspan="8">Không tìm thấy sản phẩm nào.</td></tr>');
                }
            },
            error: function() {
                productTableBody.html('<tr><td colspan="8">Lỗi khi tải sản phẩm.</td></tr>');
            }
        });
    }
    loadProducts(); // Initial load

    // ====[ UI Interaction Handlers ]====

    // Show the form for adding a new product
    $('#gpm-add-new-btn').on('click', function() {
        formTitle.text('Thêm sản phẩm mới');
        productForm[0].reset();
        productIdField.val('');
        galleryContainer.empty();
        galleryIdsField.val('');
        listContainer.hide();
        formContainer.show();
    });

    // Cancel editing/adding and return to the list
    $('#gpm-cancel-btn').on('click', function() {
        formContainer.hide();
        listContainer.show();
    });

    // Handle clicks on the "Edit" button in the table
    productTableBody.on('click', '.edit-product-btn', function() {
        const productId = $(this).data('id');
        formTitle.text('Đang tải...');
        productForm[0].reset();
        galleryContainer.empty();
        listContainer.hide();
        formContainer.show();
        
        $.ajax({
            url: gpm_ajax.ajax_url, type: 'POST', data: { action: 'gpm_get_single_product', nonce: gpm_ajax.nonce, product_id: productId },
            success: function(response) {
                if (response.success) {
                    const product = response.data;
                    formTitle.text('Chỉnh sửa sản phẩm');
                    productIdField.val(product.id);
                    $('#gpm-product-name').val(product.name);
                    $('#gpm-product-description').val(product.description);
                    $('#gpm-product-price').val(product.price);
                    $('#gpm-product-category').val(product.category_id);
                    $('#gpm-product-classification').val(product.classification);
                    $('#gpm-product-status').val(product.status);
                    $('#gpm-stock-status').val(product.stock_status);
                    renderGallery(product.gallery_images);
                } else {
                    alert('Lỗi: Không thể tải dữ liệu sản phẩm.');
                    formContainer.hide();
                    listContainer.show();
                }
            }
        });
    });

    // Handle clicks on the "Delete" button
    productTableBody.on('click', '.delete-product-btn', function() {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) return;
        const productId = $(this).data('id');
        $.ajax({
            url: gpm_ajax.ajax_url, type: 'POST', data: { action: 'gpm_delete_product', nonce: gpm_ajax.nonce, product_id: productId },
            success: function(response) { response.success ? loadProducts() : alert('Lỗi: Không thể xóa sản phẩm.'); }
        });
    });

    // ====[ Image Gallery Functions ]====

    // Open the WordPress media uploader
    $('#gpm-add-gallery-images-btn').on('click', function() {
        if (mediaFrame) { mediaFrame.open(); return; }
        mediaFrame = wp.media({ title: 'Chọn ảnh cho thư viện', button: { text: 'Sử dụng các ảnh này' }, multiple: 'add' });
        mediaFrame.on('select', function() {
            const selection = mediaFrame.state().get('selection');
            selection.each(function(attachment) {
                const attachmentJson = attachment.toJSON();
                if ($(`.gpm-gallery-item[data-id="${attachmentJson.id}"]`).length === 0) {
                    const imageUrl = attachmentJson.sizes.thumbnail ? attachmentJson.sizes.thumbnail.url : attachmentJson.url;
                    renderSingleImage(attachmentJson.id, imageUrl);
                }
            });
            updateGalleryIds();
        });
        mediaFrame.open();
    });

    // Remove an image from the gallery view
    galleryContainer.on('click', '.remove-image', function() {
        $(this).closest('.gpm-gallery-item').remove();
        updateGalleryIds();
    });

    // Make the gallery sortable
    galleryContainer.sortable({ stop: function() { updateGalleryIds(); } }).disableSelection();

    function renderSingleImage(id, url) {
        galleryContainer.append(`<div class="gpm-gallery-item" data-id="${id}"><img src="${url}" alt=""><button type="button" class="remove-image">×</button></div>`);
    }

    function updateGalleryIds() {
        const ids = galleryContainer.find('.gpm-gallery-item').map(function() { return $(this).data('id'); }).get();
        galleryIdsField.val(ids.join(','));
    }

    function renderGallery(images) {
        galleryContainer.empty();
        if (images) { for (const id in images) { renderSingleImage(id, images[id]); } }
        updateGalleryIds();
    }

    // ====[ Form Submission ]====
    productForm.on('submit', function(e) {
        e.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.text('Đang lưu...').prop('disabled', true);

        const productData = {
            action: 'gpm_save_product',
            nonce: gpm_ajax.nonce,
            product_id: productIdField.val(),
            name: $('#gpm-product-name').val(),
            description: $('#gpm-product-description').val(),
            price: $('#gpm-product-price').val(),
            category_id: $('#gpm-product-category').val(),
            classification: $('#gpm-product-classification').val(),
            status: $('#gpm-product-status').val(),
            stock_status: $('#gpm-stock-status').val(),
            gallery_ids: galleryIdsField.val()
        };

        $.ajax({
            url: gpm_ajax.ajax_url, type: 'POST', data: productData,
            success: function(response) {
                if (response.success) {
                    formContainer.hide();
                    listContainer.show();
                    loadProducts();
                } else {
                    alert('Lỗi khi lưu sản phẩm: ' + (response.data.message || 'Unknown error'));
                }
            },
            error: function() { alert('Đã có lỗi không xác định xảy ra.'); },
            complete: function() { submitBtn.text('Lưu thay đổi').prop('disabled', false); }
        });
    });
});