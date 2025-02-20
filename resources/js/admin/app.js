import '../bootstrap';
import Alpine from 'alpinejs';

// Make Alpine globally available
window.Alpine = Alpine;
Alpine.start();

// Sidebar functionality
const sidebarToggle = document.querySelector('.sidebar-toggle')
const sidebarOverlay = document.querySelector('.sidebar-overlay')
const sidebarMenu = document.querySelector('.sidebar-menu')
const main = document.querySelector('.main')

// Initialize sidebar state based on screen size
const initializeSidebar = () => {
    const isMobileOrTablet = window.innerWidth < 1024;
    
    if(isMobileOrTablet) {
        sidebarMenu.classList.add('-translate-x-full')
        main.classList.remove('lg:ml-64')
        sidebarOverlay.classList.add('hidden')
    } else {
        sidebarMenu.classList.remove('-translate-x-full')
        main.classList.add('lg:ml-64')
        sidebarOverlay.classList.add('hidden')
    }
}

// Update sidebar toggle click handler
sidebarToggle.addEventListener('click', function (e) {
    e.preventDefault()
    const isMobileOrTablet = window.innerWidth < 1024
    
    if (isMobileOrTablet) {
        sidebarMenu.classList.toggle('-translate-x-full')
        sidebarOverlay.classList.toggle('hidden')
    } else {
        if (sidebarMenu.classList.contains('lg:-translate-x-full')) {
            sidebarMenu.classList.remove('lg:-translate-x-full', 'hidden')
            main.classList.add('lg:ml-64')
        } else {
            sidebarMenu.classList.add('lg:-translate-x-full')
            main.classList.remove('lg:ml-64')
            setTimeout(() => {
                sidebarMenu.classList.add('hidden')
            }, 300)
        }
    }
})

// Initialize on load and resize
initializeSidebar()
window.addEventListener('resize', initializeSidebar)

// Update overlay click handler
sidebarOverlay.addEventListener('click', function (e) {
    e.preventDefault()
    const isMobileOrTablet = window.innerWidth < 1024
    
    if (isMobileOrTablet) {
        sidebarMenu.classList.add('-translate-x-full')
        sidebarOverlay.classList.add('hidden')
    }
})

// end: Sidebar

// side bar menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    
    // First, check for active links and expand their parent dropdowns
    document.querySelectorAll('.sidebar-link').forEach(function(link) {
        const href = link.getAttribute('href');
        if (href && href !== 'javascript:void()' && (currentPath === href || currentPath.startsWith(href))) {
            // Mark link as active
            link.classList.add('active');
            
            // Find and expand all parent dropdowns
            let parentGroup = link.closest('.group');
            while (parentGroup) {
                parentGroup.classList.add('selected', 'active');
                parentGroup = parentGroup.parentElement.closest('.group');
            }
        }
    });

    // Handle dropdown toggles
    document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = item.closest('.group');
            
            // Don't close dropdown if it contains active link
            if (!parent.querySelector('.sidebar-link.active')) {
                parent.classList.toggle('selected');
                
                // Close other dropdowns that don't contain active items
                document.querySelectorAll('.group.selected').forEach(function(group) {
                    if (group !== parent && !group.querySelector('.sidebar-link.active')) {
                        group.classList.remove('selected');
                    }
                });
            }
        });
    });
});

// side bar menu toggle


// start: Popper
const popperInstance = {}
document.querySelectorAll('.dropdown').forEach(function (item, index) {
    const popperId = 'popper-' + index
    const toggle = item.querySelector('.dropdown-toggle')
    const menu = item.querySelector('.dropdown-menu')
    menu.dataset.popperId = popperId
    popperInstance[popperId] = Popper.createPopper(toggle, menu, {
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, 8],
                },
            },
            {
                name: 'preventOverflow',
                options: {
                    padding: 24,
                },
            },
        ],
        placement: 'bottom-end'
    });
})
document.addEventListener('click', function (e) {
    const toggle = e.target.closest('.dropdown-toggle')
    const menu = e.target.closest('.dropdown-menu')
    if (toggle) {
        const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu')
        const popperId = menuEl.dataset.popperId
        if (menuEl.classList.contains('hidden')) {
            hideDropdown()
            menuEl.classList.remove('hidden')
            showPopper(popperId)
        } else {
            menuEl.classList.add('hidden')
            hidePopper(popperId)
        }
    } else if (!menu) {
        hideDropdown()
    }
})

function hideDropdown() {
    document.querySelectorAll('.dropdown-menu').forEach(function (item) {
        item.classList.add('hidden')
    })
}
function showPopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: true },
            ],
        }
    });
    popperInstance[popperId].update();
}
function hidePopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: 'eventListeners', enabled: false },
            ],
        }
    });
}
// end: Popper

// start: Tab
document.querySelectorAll('[data-tab]').forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault()
        const tab = item.dataset.tab
        const page = item.dataset.tabPage
        const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]')
        document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
            i.classList.remove('active')
        })
        document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
            i.classList.add('hidden')
        })
        item.classList.add('active')
        target.classList.remove('hidden')
    })
})
// end: Tab

// start: Chart
new Chart(document.getElementById('order-chart'), {
    type: 'line',
    data: {
        labels: generateNDays(7),
        datasets: [
            {
                label: 'Active',
                data: generateRandomData(7),
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgb(59 130 246 / .05)',
                tension: .2
            },
            {
                label: 'Completed',
                data: generateRandomData(7),
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgb(16, 185, 129)',
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgb(16 185 129 / .05)',
                tension: .2
            },
            {
                label: 'Canceled',
                data: generateRandomData(7),
                borderWidth: 1,
                fill: true,
                pointBackgroundColor: 'rgb(244, 63, 94)',
                borderColor: 'rgb(244, 63, 94)',
                backgroundColor: 'rgb(244 63 94 / .05)',
                tension: .2
            },
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function generateNDays(n) {
    const data = []
    for(let i=0; i<n; i++) {
        const date = new Date()
        date.setDate(date.getDate()-i)
        data.push(date.toLocaleString('en-US', {
            month: 'short',
            day: 'numeric'
        }))
    }
    return data
}
function generateRandomData(n) {
    const data = []
    for(let i=0; i<n; i++) {
        data.push(Math.round(Math.random() * 10))
    }
    return data
}
// end: Chart

// data table js  start

let currentPage = 1;
let rowsPerPage = localStorage.getItem('rowsPerPage') ? parseInt(localStorage.getItem('rowsPerPage'), 10) : 25;
let allRows = [];  // Store all rows for pagination
let filteredRows = []; // Store filtered rows

// Function to render the table
function renderTable() {
    const rows = filteredRows.length > 0 ? filteredRows : allRows;
    const totalRows = rows.length;
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

    // Hide all rows initially
    allRows.forEach(row => row.style.display = 'none');

    // Show only the rows for the current page
    for (let i = startIndex; i < endIndex; i++) {
        rows[i].style.display = '';
    }

    // Show "No results found" message and hide table if no rows match
    document.getElementById('noResults').style.display = filteredRows.length === 0 ? 'block' : 'none';
    document.getElementById('dataTable').style.display = filteredRows.length === 0 ? 'none' : 'table';

    // Update pagination info
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = currentPage === totalPages;
}

// Function to initialize rows
function initializeRows() {
    allRows = Array.from(document.querySelectorAll('#dataTable .data-row'));
    filteredRows = allRows; // Initially, no filter, show all rows
    renderTable();
}

// Event listener for search
document.getElementById('searchInput').addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();

    // Filter rows based on search input
    filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(searchQuery));

    currentPage = 1; // Reset to first page after search
    renderTable();
});

// Event listener for "Show per page" dropdown
document.getElementById('perPage').addEventListener('change', function() {
    rowsPerPage = parseInt(this.value, 10);
    localStorage.setItem('rowsPerPage', rowsPerPage);
    renderTable();
});

// Set the dropdown to the saved value
document.getElementById('perPage').value = rowsPerPage;

// Pagination functionality
document.getElementById('prevPage').addEventListener('click', function() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

document.getElementById('nextPage').addEventListener('click', function() {
    const totalRows = filteredRows.length > 0 ? filteredRows.length : allRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
    }
});

// Print functionality
document.getElementById('printBtn').addEventListener('click', function() {
    var printContents = document.querySelector('#dataTable').outerHTML;
    var originalContents = document.body.innerHTML;
    var originalTitle = document.title;

    document.body.innerHTML = "<h1 class='text-center text-2xl mb-4'>" + originalTitle + "</h1><div class='container mx-auto p-6'>" + printContents + "</div>";
    
    window.print();
    
    // Reload the page after printing to restore original state
    location.reload();
});

// Export to Excel functionality
document.getElementById('exportBtn').addEventListener('click', function() {
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(document.getElementById('dataTable'));
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    XLSX.writeFile(wb, 'DataTable.xlsx');
    
    // Reload the page after exporting to Excel to restore original state
    location.reload();
});

// Initial render
initializeRows();

// data table js  end


// input number validation start 
function validateNumberInput(event) {
    const keyCode = event.keyCode || event.which;
    const keyValue = String.fromCharCode(keyCode);
    if (!/^\d+$/.test(keyValue) && keyCode !== 8 && keyCode !== 46) {
      event.preventDefault();
    }
  }
// input number validation end


// form validation start
window.toggleImageUpload = function() {
    const selectedOption = document.querySelector('input[name="image-upload"]:checked').value;
    if (selectedOption === "single") {
        document.getElementById("single-image-upload").style.display = "block";
        document.getElementById("multiple-image-upload").style.display = "none";
    } else {
        document.getElementById("single-image-upload").style.display = "none";
        document.getElementById("multiple-image-upload").style.display = "block";
    }
}

window.togglePaymentMethod = function() {
    document.querySelectorAll('.payment-option').forEach(option => {
        option.style.display = 'none';
    });
    const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
    document.getElementById(selectedPayment).style.display = 'block';
}

// Single Image Preview
window.previewSingleImage = function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById("image-preview-single");
            preview.src = e.target.result;
            preview.classList.remove("hidden");
            document.getElementById("upload-text-single").classList.add("hidden");
        };
        reader.readAsDataURL(file);
    }
}

// Multiple Image Previews with Add, Remove, Replace functionality
window.previewMultipleImages = function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById("image-previews");

    Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement("div");
            imgContainer.classList.add("relative", "w-20", "h-20", "object-cover", "rounded-lg", "mb-2");

            const img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("w-20", "h-20", "rounded-lg", "object-cover");

            const removeBtn = document.createElement("button");
            removeBtn.innerText = "X";
            removeBtn.classList.add("absolute", "top-0", "right-0", "bg-red-500", "text-white", "rounded-full", "p-1");
            removeBtn.onclick = function() {
                imgContainer.remove();
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);
            previewContainer.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });

    document.getElementById("upload-text-multiple").classList.add("hidden");
}

window.handleDropSingle = function(event) {
    event.preventDefault();
    document.getElementById("drop-area-single").classList.remove("border-blue-500");
    const files = event.dataTransfer.files;
    document.getElementById("file-input-single").files = files;
    window.previewSingleImage({ target: { files } });
}

window.handleDropMultiple = function(event) {
    event.preventDefault();
    document.getElementById("drop-area-multiple").classList.remove("border-blue-500");
    const files = event.dataTransfer.files;
    document.getElementById("file-input-multiple").files = files;
    window.previewMultipleImages({ target: { files } });
}

window.handleDragOver = function(event) {
    event.preventDefault();
    event.target.classList.add("border-blue-500");
}

window.handleDragLeave = function(event) {
    event.target.classList.remove("border-blue-500");
}

// Initialize default image upload option and payment method when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if(document.querySelector('input[name="image-upload"]')) {
        window.toggleImageUpload();
    }
    if(document.querySelector('input[name="payment"]')) {
        window.togglePaymentMethod();
    }
});


