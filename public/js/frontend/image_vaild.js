// image handel for profile 

function handleFile(file) {
    // Validate file type
    if (!file.type.match('image.*')) {
        alert('Please upload an image file (JPG, PNG)');
        return;
    }

    // Validate file size  check (5MB)
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
