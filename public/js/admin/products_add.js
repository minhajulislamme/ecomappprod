
const colorInput = document.getElementById('color-input');
const addColorButton = document.getElementById('add-color');
const colorPreviewContainer = document.getElementById('color-preview-container');
const colors = [];
const hexInput = document.getElementById('hex-input');

colorInput.addEventListener('input', (e) => {
    const color = e.target.value;
    hexInput.value = color.toUpperCase();
});

hexInput.addEventListener('input', (e) => {
    let value = e.target.value;
    if (!value.startsWith('#')) {
        value = '#' + value;
        e.target.value = value;
    }

    if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(value)) {
        colorInput.value = value;
    }
});

addColorButton.addEventListener('click', () => {
    const colorValue = colorInput.value;
    if (colors.includes(colorValue)) {
        alert('This color has already been added!');
        return;
    }

    colors.push(colorValue);
    createChip(colorPreviewContainer, colorValue, 'color');

    // Reset inputs
    colorInput.value = '#000000';
    hexInput.value = '#000000';
});

const sizeInput = document.getElementById('size-input');
const addSizeButton = document.getElementById('add-size');
const sizePreviewContainer = document.getElementById('size-preview-container');
const sizes = [];

addSizeButton.addEventListener('click', () => {
    const sizeValue = sizeInput.value.trim();
    if (!sizeValue) return;

    if (sizes.includes(sizeValue)) {
        alert('This size has already been added!');
        return;
    }

    sizes.push(sizeValue);
    createChip(sizePreviewContainer, sizeValue);

    // Reset inputs
    sizeInput.value = '';
});

const tagInput = document.getElementById('tag-input');
const addTagButton = document.getElementById('add-tag');
const tagPreviewContainer = document.getElementById('tag-preview-container');
const tags = [];

addTagButton.addEventListener('click', () => {
    const tagValue = tagInput.value.trim();
    if (!tagValue) return;

    if (tags.includes(tagValue)) {
        alert('This tag has already been added!');
        return;
    }

    tags.push(tagValue);
    createChip(tagPreviewContainer, tagValue);

    // Reset inputs
    tagInput.value = '';
});

const submitButton = document.getElementById('submit-button');
const productForm = document.getElementById('product-form');

submitButton.addEventListener('click', () => {
    productForm.submit();
});

function createChip(container, value, type = 'tag') {
    const chip = document.createElement('span');
    chip.textContent = value;
    chip.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transform transition-all duration-200 hover:scale-105 ${
        type === 'color' 
            ? 'text-white shadow-sm' 
            : 'bg-white text-gray-700 border border-gray-300 shadow-sm'
    }`;

    if (type === 'color') {
        chip.style.backgroundColor = value;
    }

    // Add delete button
    const deleteBtn = document.createElement('span');
    deleteBtn.innerHTML = '×';
    deleteBtn.className = 'ml-1.5 text-xs hover:text-red-500 cursor-pointer';
    chip.appendChild(deleteBtn);

    deleteBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        chip.classList.add('scale-95', 'opacity-0');
        setTimeout(() => chip.remove(), 200);
    });

    container.appendChild(chip);
    // Animate in
    requestAnimationFrame(() => chip.classList.add('scale-100', 'opacity-100'));
}

// Update color display
colorInput.addEventListener('input', (e) => {
    const color = e.target.value;
    e.target.nextElementSibling.textContent = color;
    e.target.nextElementSibling.style.color = color;
});
