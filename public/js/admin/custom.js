// image handel for profile 

function handleFile(file) {
    // Validate file type
    if (!file.type.match('image.*')) {
        alert('Please upload an image file (JPG, PNG)');
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size should not exceed 2MB');
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


// text editor for admin panel


 // Move summernote initialization to after vite loads
 var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'align': []
            }],
            ['link', 'image'],
            ['clean']
        ]
    },
    placeholder: 'Write your content here...'
});

// Save content to hidden input when editor changes
quill.on('text-change', function() {
    var content = quill.root.innerHTML;
    document.getElementById('content').value = content;
});

// Auto-save functionality
let autoSaveTimeout;
quill.on('text-change', function() {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(function() {
        localStorage.setItem('quill-content', quill.root.innerHTML);
        console.log('Content auto-saved');
    }, 1000);
});

// Load saved content if exists
document.addEventListener('DOMContentLoaded', function() {
    const savedContent = localStorage.getItem('quill-content');
    if (savedContent) {
        quill.root.innerHTML = savedContent;
    }
});


