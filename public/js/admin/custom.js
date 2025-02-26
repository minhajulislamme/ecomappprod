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


// text editor for admin panel
// document.addEventListener('DOMContentLoaded', function() {
//     // Add a small delay to ensure DOM is fully ready
//     setTimeout(() => {
//         // Function to initialize Quill for a specific editor
//         function initializeQuill(editorId, contentInputId) {
//             // Check if editor element exists before initializing Quill
//             const editorElement = document.getElementById(editorId);
//             if (!editorElement) {
//                 console.warn(`Editor element with ID "${editorId}" not found`);
//                 return null;
//             }

//             // Add a custom class to ensure unique styling
//             editorElement.classList.add('quill-editor-custom');

//             try {
//                 // Initialize Quill with proper configuration
//                 const quill = new Quill(`#${editorId}`, {
//                     theme: 'snow',
//                     modules: {
//                         table: false,
//                         'better-table': {
//                             operationMenu: {
//                                 items: {
//                                     insertColumnRight: {
//                                         text: 'Insert Column Right'
//                                     },
//                                     insertColumnLeft: {
//                                         text: 'Insert Column Left'
//                                     },
//                                     insertRowUp: {
//                                         text: 'Insert Row Up'
//                                     },
//                                     insertRowDown: {
//                                         text: 'Insert Row Down'
//                                     },
//                                     deleteColumn: {
//                                         text: 'Delete Column'
//                                     },
//                                     deleteRow: {
//                                         text: 'Delete Row'
//                                     }
//                                 }
//                             }
//                         },
//                         toolbar: [
//                             [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
//                             ['bold', 'italic', 'underline', 'strike'],
//                             [{ 'color': [] }, { 'background': [] }],
//                             [{ 'list': 'ordered' }, { 'list': 'bullet' }],
//                             [{ 'align': [] }],
//                             ['link', 'code-block'],
//                             ['clean']
//                         ]
//                     },
//                     placeholder: 'Write your content here...'
//                 });

//                 console.log(`Quill editor initialized for ${editorId}`);

//                 // Save content to hidden input when editor changes
//                 const contentInput = document.getElementById(contentInputId);
//                 if (contentInput) {
//                     // Load old value into Quill editor if available (for form validation failures)
//                     if (contentInput.value) {
//                         quill.root.innerHTML = contentInput.value;
//                     }

//                     // Update hidden input when content changes
//                     quill.on('text-change', function() {
//                         contentInput.value = quill.root.innerHTML;
//                     });
//                 } else {
//                     console.warn(`Hidden input with ID "${contentInputId}" not found`);
//                 }

//                 return quill;
//             } catch (error) {
//                 console.error(`Error initializing Quill for ${editorId}:`, error);
//                 return null;
//             }
//         }

//         // Clear any existing Quill instances that might be cached
//         document.querySelectorAll('.ql-toolbar').forEach(toolbar => {
//             if (toolbar.parentNode) {
//                 toolbar.parentNode.removeChild(toolbar);
//             }
//         });

//         console.log('Initializing Quill editors...');

//         // Initialize both editors with a slight delay between them
//         const shortDescEditor = initializeQuill('short-description-editor', 'short-description-content');

//         // Small delay before initializing the second editor to avoid conflicts
//         setTimeout(() => {
//             const longDescEditor = initializeQuill('long-description-editor', 'long-description-content');
//         }, 100);

//         // For backward compatibility (if there are any old editor instances)
//         setTimeout(() => {
//             initializeQuill('editor', 'content');
//         }, 200);
//     }, 50);
// });




