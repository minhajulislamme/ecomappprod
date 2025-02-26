// image handel for profile

function handleFile(file) {
    // Validate file type
    if (!file.type.match('image.*')) {
        alert('Please upload an image file (JPG, PNG)');
        return;
    }

    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('File size should not exceed 5MB');
        return;
    }

    const preview = document.getElementById('image-preview-single');
    const uploadText = document.getElementById('upload-text-single');
    const loadingIndicator = document.getElementById('loading-indicator');

    loadingIndicator.classList.remove('hidden');

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        uploadText.classList.add('hidden');
        loadingIndicator.classList.add('hidden');
    };

    reader.onerror = function() {
        alert('Error loading image');
        loadingIndicator.classList.add('hidden');
    };

    reader.readAsDataURL(file);
}

function handleDragOver(event) {
    event.preventDefault();
    event.target.classList.add('border-orange-500');
}

function handleDragLeave(event) {
    event.preventDefault();
    event.target.classList.remove('border-orange-500');
}

function handleDrop(event) {
    event.preventDefault();
    event.target.classList.remove('border-orange-500');
    const file = event.dataTransfer.files[0];
    handleFile(file);
}

// Initialize preview if there's an existing image
document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('image-preview-single');
    const uploadText = document.getElementById('upload-text-single');

    if (preview && preview.src && preview.src !== window.location.href) {
        preview.classList.remove('hidden');
        uploadText.classList.add('hidden');
    }
});

// end image handler for profile

// Custom dropdown functionality
document.querySelectorAll('.dropdown-toggle').forEach(button => {
    button.addEventListener('click', e => {
        e.stopPropagation();
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
});

// Toggle switches update text
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const statusText = this.closest('label').querySelector('.status-text');
        if (statusText) {
            statusText.textContent = this.checked ? 'Active' : 'Inactive';
        }
    });
});

// Handle products table bulk actions
const bulkActionsHandler = () => {
    const checkAll = document.getElementById('check-all');
    const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
    const bulkActionsCount = document.getElementById('bulk-actions-count');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');

    if (!checkAll || !checkboxes.length) return;

    const updateBulkActionsBar = () => {
        const selectedCount = document.querySelectorAll('input[name="selected_products[]"]:checked').length;
        if (selectedCount > 0) {
            bulkActionsCount.textContent = selectedCount;
            bulkActionsBar.classList.remove('hidden');
        } else {
            bulkActionsBar.classList.add('hidden');
        }
    };

    checkAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        updateBulkActionsBar();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionsBar);
    });
};

// Initialize bulk actions handler
document.addEventListener('DOMContentLoaded', bulkActionsHandler);

// Handle status toggle buttons
document.querySelectorAll('.status-toggle').forEach(button => {
    button.addEventListener('click', async function() {
        const productId = this.dataset.productId;
        const currentStatus = this.dataset.status;
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const baseUrl = this.dataset.url;

        try {
            const response = await fetch(`${baseUrl}/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (response.ok) {
                // Update button state
                this.dataset.status = newStatus;
                this.classList.toggle('bg-green-500');
                this.classList.toggle('bg-red-500');

                // Update status text and icon
                const statusText = this.querySelector('.status-text');
                const statusIcon = this.querySelector('.status-icon');

                if (statusText) {
                    statusText.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                }

                if (statusIcon) {
                    statusIcon.className = `status-icon fas fa-${newStatus === 'active' ? 'check' : 'times'} mr-2`;
                }
            }
        } catch (error) {
            console.error('Error updating status:', error);
        }
    });
});




