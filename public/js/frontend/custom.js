// ...existing code...

// Updated closeAllMenus function to include cart and wishlist
function closeAllMenus() {
    const menus = ['mobileMenu', 'mobileCategoryMenu', 'cartSidebar', 'wishlistSidebar'];
    const contents = ['menuContent', 'categoryContent', 'cartContent', 'wishlistContent'];
    
    menus.forEach((menuId, index) => {
        const menu = document.getElementById(menuId);
        const content = document.getElementById(contents[index]);
        
        if (menu && content && !menu.classList.contains('hidden')) {
            if (contents[index] === 'cartContent' || contents[index] === 'wishlistContent') {
                content.classList.add('translate-x-full');
            } else {
                content.classList.add('-translate-x-full');
            }
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    });
}

// Updated toggleMenu function
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const menuContent = document.getElementById('menuContent');
    
    if (menu.classList.contains('hidden')) {
        closeAllMenus(); // Close other menus first
        menu.classList.remove('hidden');
        setTimeout(() => {
            menuContent.classList.remove('-translate-x-full');
        }, 1);
    } else {
        menuContent.classList.add('-translate-x-full');
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 300);
    }
}

// Updated toggleCategoryMenu function
function toggleCategoryMenu() {
    const menu = document.getElementById('mobileCategoryMenu');
    const content = document.getElementById('categoryContent');
    
    if (menu.classList.contains('hidden')) {
        closeAllMenus(); // Close other menus first
        menu.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('-translate-x-full');
        }, 1);
    } else {
        content.classList.add('-translate-x-full');
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 300);
    }
}

// Updated toggleCart function
function toggleCart() {
    const cartSidebar = document.getElementById('cartSidebar');
    const cartContent = document.getElementById('cartContent');
    
    if (cartSidebar.classList.contains('hidden')) {
        closeAllMenus(); // Close other menus first
        cartSidebar.classList.remove('hidden');
        setTimeout(() => {
            cartContent.classList.remove('translate-x-full');
        }, 1);
    } else {
        cartContent.classList.add('translate-x-full');
        setTimeout(() => {
            cartSidebar.classList.add('hidden');
        }, 300);
    }
}

// Wishlist Toggle Function
function toggleWishlist() {
    const wishlistSidebar = document.getElementById('wishlistSidebar');
    const wishlistContent = document.getElementById('wishlistContent');
    
    if (wishlistSidebar.classList.contains('hidden')) {
        closeAllMenus(); // Close other menus first
        wishlistSidebar.classList.remove('hidden');
        setTimeout(() => {
            wishlistContent.classList.remove('translate-x-full');
        }, 1);
    } else {
        wishlistContent.classList.add('translate-x-full');
        setTimeout(() => {
            wishlistSidebar.classList.add('hidden');
        }, 300);
    }
}

// Function to move item from wishlist to cart
function moveToCart(itemId) {
    // Add to cart logic here
    const item = document.getElementById(`wishlist-item-${itemId}`);
    if (item) {
        // You can implement the actual cart addition logic here
        // alert('Item added to cart!');
        removeFromWishlist(itemId);
    }
}

// Function to remove item from wishlist
function removeFromWishlist(itemId) {
    const item = document.getElementById(`wishlist-item-${itemId}`);
    if (item) {
        item.remove();
        // Update wishlist count
        const wishlistItems = document.querySelectorAll('.wishlist-item').length;
        document.querySelectorAll('.wishlist-count').forEach(counter => {
            counter.textContent = wishlistItems;
        });
    }
}

// Function to move all items from wishlist to cart
function moveAllToCart() {
    const wishlistItems = document.querySelectorAll('.wishlist-item');
    wishlistItems.forEach(item => {
        const itemId = item.id.split('-')[2];
        moveToCart(itemId);
    });
    toggleWishlist(); // Close wishlist after moving all items
}

// Close menus when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlays = ['mobileMenu', 'mobileCategoryMenu', 'cartSidebar'];
    
    overlays.forEach(overlayId => {
        const overlay = document.getElementById(overlayId);
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    switch(overlayId) {
                        case 'mobileMenu':
                            toggleMenu();
                            break;
                        case 'mobileCategoryMenu':
                            toggleCategoryMenu();
                            break;
                        case 'cartSidebar':
                            toggleCart();
                            break;
                    }
                }
            });
        }
    });

    // Add click handlers for cart and wishlist overlays
    ['cartSidebar', 'wishlistSidebar'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (id === 'cartSidebar') {
                        toggleCart();
                    } else {
                        toggleWishlist();
                    }
                }
            });
        }
    });

    // Initialize click handlers for menu buttons
    const menuButton = document.querySelector('[onclick="toggleMenu()"]');
    if (menuButton) {
        menuButton.onclick = function(e) {
            e.preventDefault();
            toggleMenu();
        };
    }

    const categoryButton = document.querySelector('[onclick="toggleCategoryMenu()"]');
    if (categoryButton) {
        categoryButton.onclick = function(e) {
            e.preventDefault();
            toggleCategoryMenu();
        };
    }

    // Update cart button handlers
    const cartButtons = document.querySelectorAll('[onclick="toggleCart()"]');
    cartButtons.forEach(button => {
        button.onclick = function(e) {
            e.preventDefault();
            toggleCart();
        };
    });

    // Add wishlist button handlers
    const wishlistButtons = document.querySelectorAll('[onclick="toggleWishlist()"]');
    wishlistButtons.forEach(button => {
        button.onclick = function(e) {
            e.preventDefault();
            toggleWishlist();
        };
    });

    // Close menu on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllMenus();
        }
    });
});

// Initialize Swiper
const swiper = new Swiper('.bannerSwiper', {
  loop: true,
  autoplay: {
      delay: 3000,
      disableOnInteraction: false,
  }
});
// Initialize Flash Sales Swiper with autoplay
const flashSalesSwiper = new Swiper('.flashSalesSwiper', {
  slidesPerView: 2,
  spaceBetween: 12,
  loop: true, // Enable loop
  autoplay: {
      delay: 3000,
      disableOnInteraction: false,
  },
  breakpoints: {
      640: {
          slidesPerView: 2,
          spaceBetween: 16
      },
      768: {
          slidesPerView: 3,
          spaceBetween: 16
      },
      1024: {
          slidesPerView: 4,
          spaceBetween: 16
      },
      1280: {
          slidesPerView: 5,
          spaceBetween: 16
      }
  }
});
// Add scroll event listener for sticky search
let lastScroll = 0;
const stickySearch = document.getElementById('stickySearch');
window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  if (currentScroll > 150) { // Show after scrolling 150px
      if (currentScroll > lastScroll) {
          // Scrolling down
          stickySearch.style.transform = 'translateY(0)';
      }
  } else {
      // At top
      stickySearch.style.transform = 'translateY(-100%)';
  }
  
  lastScroll = currentScroll;
});
// Set the countdown date (24 hours from now)
const countDownDate = new Date().getTime() + (24 * 60 * 60 * 1000);
// Update the countdown every 1 second
const countdownTimer = setInterval(function() {
  const now = new Date().getTime();
  const distance = countDownDate - now;
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);
  document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
  document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
  document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');
  // If the countdown is over
  if (distance < 0) {
      clearInterval(countdownTimer);
      document.getElementById("hours").textContent = "00";
      document.getElementById("minutes").textContent = "00";
      document.getElementById("seconds").textContent = "00";
  }
}, 1000);
// Scroll to top functionality
const scrollToTopBtn = document.getElementById('scrollToTop');
window.addEventListener('scroll', () => {
  if (window.pageYOffset > 300) { // Show button after scrolling 300px
      scrollToTopBtn.classList.replace('scale-0', 'scale-100');
  } else {
      scrollToTopBtn.classList.replace('scale-100', 'scale-0');
  }
});
scrollToTopBtn.addEventListener('click', () => {
  window.scrollTo({
      top: 0,
      behavior: 'smooth'
  });
});
// Chat Widget Toggle Function
function toggleChat() {
  const chatWidget = document.getElementById('chatWidget');
  if (chatWidget.classList.contains('invisible')) {
      // Show chat
      chatWidget.classList.remove('invisible', 'opacity-0', 'translate-y-full');
      chatWidget.classList.add('opacity-100', 'translate-y-0');
  } else {
      // Hide chat
      chatWidget.classList.remove('opacity-100', 'translate-y-0');
      chatWidget.classList.add('opacity-0', 'translate-y-full');
      setTimeout(() => {
          chatWidget.classList.add('invisible');
      }, 300);
  }
}
// Floating Buttons Toggle Function
function toggleFloatingButtons() {
  const hiddenButtons = document.getElementById('hiddenButtons');
  if (hiddenButtons.classList.contains('scale-0')) {
      // Show buttons
      hiddenButtons.classList.remove('scale-0', 'opacity-0');
      hiddenButtons.classList.add('scale-100', 'opacity-100');
  } else {
      // Hide buttons
      hiddenButtons.classList.remove('scale-100', 'opacity-100');
      hiddenButtons.classList.add('scale-0', 'opacity-0');
  }
}
// Close floating buttons when clicking outside
document.addEventListener('click', function(event) {
  const floatingButtons = document.querySelector('.fixed.left-4.bottom-28');
  const hiddenButtons = document.getElementById('hiddenButtons');
  
  if (!floatingButtons.contains(event.target) && !hiddenButtons.classList.contains('scale-0')) {
      toggleFloatingButtons();
  }
});
// Update scroll to top functionality for anchor tag
document.getElementById('scrollToTop').addEventListener('click', (e) => {
  e.preventDefault(); // Prevent default anchor behavior
  window.scrollTo({
      top: 0,
      behavior: 'smooth'
  });
});
// Update other click handlers to prevent default anchor behavior
document.querySelectorAll('a[onclick]').forEach(anchor => {
  anchor.addEventListener('click', (e) => {
      e.preventDefault();
  });
});

// Cart Management Functions
function updateCartItem(itemId, quantity) {
    const item = document.getElementById(`cart-item-${itemId}`);
    if (!item) return;

    const quantityElement = item.querySelector('.quantity-value');
    const priceElement = item.querySelector('.item-price');
    const basePrice = parseFloat(item.dataset.basePrice);
    
    // Update quantity
    quantityElement.textContent = quantity;
    
    // Update item total price
    const totalPrice = (basePrice * quantity).toFixed(2);
    priceElement.textContent = `$${totalPrice}`;

    // Update cart subtotal
    updateCartSubtotal();
}

function incrementQuantity(itemId) {
    const item = document.getElementById(`cart-item-${itemId}`);
    const quantityElement = item.querySelector('.quantity-value');
    const currentQuantity = parseInt(quantityElement.textContent);
    const newQuantity = currentQuantity + 1;
    
    updateCartItem(itemId, newQuantity);
}

function decrementQuantity(itemId) {
    const item = document.getElementById(`cart-item-${itemId}`);
    const quantityElement = item.querySelector('.quantity-value');
    const currentQuantity = parseInt(quantityElement.textContent);
    if (currentQuantity > 1) {
        const newQuantity = currentQuantity - 1;
        updateCartItem(itemId, newQuantity);
    }
}

function removeCartItem(itemId) {
    const item = document.getElementById(`cart-item-${itemId}`);
    item.remove();
    updateCartSubtotal();
    
    // Update cart count
    const cartItems = document.querySelectorAll('.cart-item').length;
    document.querySelectorAll('.cart-count').forEach(counter => {
        counter.textContent = cartItems;
    });
}

function updateCartSubtotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let subtotal = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.item-price').textContent.replace('$', ''));
        subtotal += price;
    });

    // Update subtotal
    document.getElementById('cart-subtotal').textContent = `$${subtotal.toFixed(2)}`;
    // Update total (same as subtotal since shipping is free)
    document.getElementById('cart-total').textContent = `$${subtotal.toFixed(2)}`;
}

// ...existing code...
  // Tab switching functionality
  function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Show selected tab content
    const selectedTab = document.getElementById(`${tabName}-tab`);
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }

    // Remove active state from all menu items
    document.querySelectorAll(
            '.dashboard-tab-btn, .orders-tab-btn, .wishlist-tab-btn, .addresses-tab-btn, .settings-tab-btn')
        .forEach(item => {
            item.classList.remove('text-orange-400', 'bg-orange-50');
            item.classList.add('text-gray-600');
        });

    // Add active state to selected menu item
    const activeMenuItem = document.querySelector(`.${tabName}-tab-btn`);
    if (activeMenuItem) {
        activeMenuItem.classList.remove('text-gray-600');
        activeMenuItem.classList.add('text-orange-400', 'bg-orange-50');
    }
}

// Address form toggle functionality
function toggleAddressForm() {
    const form = document.getElementById('newAddressForm');
    if (form) {
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            form.classList.add('hidden');
        }
    }
}

// Initialize dashboard tab on page load
document.addEventListener('DOMContentLoaded', () => {
    showTab('dashboard');

    // Add click event listeners to all tab buttons
    const tabButtons = document.querySelectorAll('[onclick^="showTab"]');
    tabButtons.forEach(button => {
        const tabName = button.getAttribute('onclick').match(/'([^']+)'/)[1];
        button.addEventListener('click', (e) => {
            e.preventDefault();
            showTab(tabName);
        });
    });
});