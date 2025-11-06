jQuery(document).ready(function($) {
    try {
        console.log('Virical Admin Product Edit Script Loaded');

        const categoryChecklist = $('#categorychecklist');
        if (!categoryChecklist.length) {
            console.error('Category checklist not found.');
            return;
        }
        console.log('Category checklist found.');

        const parentCategoryDropdown = $('<select id="parent_category" name="parent_category" style="width:100%; margin-bottom: 10px;"></select>');
        const childCategoryDropdown = $('<select id="child_category" name="child_category" style="width:100%;"></select>');

        // Hide the original checklist
        categoryChecklist.hide();

        // Create the dropdowns
        categoryChecklist.after(parentCategoryDropdown);
        parentCategoryDropdown.after(childCategoryDropdown);
        console.log('Dropdowns created.');

        // Populate the parent category dropdown
        parentCategoryDropdown.append('<option value="">Select Parent Category</option>');
        categoryChecklist.find('.popular-category > label > input[type="checkbox"]').each(function() {
            const checkbox = $(this);
            const label = checkbox.parent().text().trim();
            const value = checkbox.val();
            parentCategoryDropdown.append('<option value="' + value + '">' + label + '</option>');
        });
        console.log('Parent category dropdown populated.');

        // Function to populate the child category dropdown
        function populateChildCategories(parentId) {
            console.log('Populating child categories for parent ID: ' + parentId);
            childCategoryDropdown.empty().append('<option value="">Select Sub-category</option>');
            if (parentId) {
                const parentListItem = categoryChecklist.find('input[value="' + parentId + '"]').closest('li');
                parentListItem.find('.children > li > label > input[type="checkbox"]').each(function() {
                    const checkbox = $(this);
                    const label = checkbox.parent().text().trim();
                    const value = checkbox.val();
                    childCategoryDropdown.append('<option value="' + value + '">' + label + '</option>');
                });
            }
            console.log('Child category dropdown populated.');
        }

        // Event listener for the parent category dropdown
        parentCategoryDropdown.on('change', function() {
            const parentId = $(this).val();
            populateChildCategories(parentId);
        });

        // Set initial state
        const initialParentId = categoryChecklist.find('input[type="checkbox"]:checked').closest('.children').siblings('label').find('input').val();
        if (initialParentId) {
            console.log('Initial parent ID found: ' + initialParentId);
            parentCategoryDropdown.val(initialParentId);
            populateChildCategories(initialParentId);
            const initialChildId = categoryChecklist.find('input[type="checkbox"]:checked').not('[value="' + initialParentId + '"]').val();
            if (initialChildId) {
                console.log('Initial child ID found: ' + initialChildId);
                childCategoryDropdown.val(initialChildId);
            }
        } else {
            const initialCategoryId = categoryChecklist.find('input[type="checkbox"]:checked').val();
            if (initialCategoryId) {
                console.log('Initial category ID found: ' + initialCategoryId);
                parentCategoryDropdown.val(initialCategoryId);
            }
        }

        // Update the hidden checklist when the dropdowns change
        parentCategoryDropdown.on('change', function() {
            categoryChecklist.find('input[type="checkbox"]').prop('checked', false);
            const parentId = $(this).val();
            if (parentId) {
                categoryChecklist.find('input[value="' + parentId + '"]').prop('checked', true);
                console.log('Parent category ' + parentId + ' checked.');
            }
        });

        childCategoryDropdown.on('change', function() {
            const parentId = parentCategoryDropdown.val();
            categoryChecklist.find('input[value="' + parentId + '"]').closest('li').find('.children input[type="checkbox"]').prop('checked', false);
            const childId = $(this).val();
            if (childId) {
                categoryChecklist.find('input[value="' + childId + '"]').prop('checked', true);
                console.log('Child category ' + childId + ' checked.');
            }
        });

    } catch (error) {
        console.error('An error occurred in the Virical Admin Product Edit Script:');
        console.error(error);
    }
});