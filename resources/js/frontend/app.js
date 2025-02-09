import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// ...existing code...


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

// ...existing code...

// Make functions available globally
window.closeAllMenus = function() {
    const menus = ['mobileMenu', 'mobileCategoryMenu'];
    const contents = ['menuContent', 'categoryContent'];
    
    menus.forEach((menuId, index) => {
        const menu = document.getElementById(menuId);
        const content = document.getElementById(contents[index]);
        
        if (menu && content && !menu.classList.contains('hidden')) {
            content.classList.add('-translate-x-full');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    });
}

window.toggleMenu = function() {
    const menu = document.getElementById('mobileMenu');
    const menuContent = document.getElementById('menuContent');
    
    if (!menu || !menuContent) return;
    
    if (menu.classList.contains('hidden')) {
        window.closeAllMenus(); // Close other menus first
        menu.classList.remove('hidden');
        requestAnimationFrame(() => {
            menuContent.classList.remove('-translate-x-full');
        });
    } else {
        menuContent.classList.add('-translate-x-full');
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 300);
    }
}

window.toggleCategoryMenu = function() {
    const menu = document.getElementById('mobileCategoryMenu');
    const content = document.getElementById('categoryContent');
    
    if (!menu || !content) return;
    
    if (menu.classList.contains('hidden')) {
        window.closeAllMenus(); // Close other menus first
        menu.classList.remove('hidden');
        requestAnimationFrame(() => {
            content.classList.remove('-translate-x-full');
        });
    } else {
        content.classList.add('-translate-x-full');
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 300);
    }
}

window.toggleSubcategory = function(id) {
    const currentSubmenu = document.getElementById(`${id}-sub`);
    const currentIcon = document.getElementById(`${id}-icon`);
    
    if (!currentSubmenu || !currentIcon) return;
    
    const allSubmenus = document.querySelectorAll('[id$="-sub"]');
    const allIcons = document.querySelectorAll('[id$="-icon"]');
    
    allSubmenus.forEach(submenu => {
        if (submenu !== currentSubmenu) {
            submenu.style.maxHeight = null;
        }
    });
    
    allIcons.forEach(icon => {
        if (icon !== currentIcon) {
            icon.style.transform = 'rotate(0deg)';
        }
    });
    
    if (currentSubmenu.style.maxHeight) {
        currentSubmenu.style.maxHeight = null;
        currentIcon.style.transform = 'rotate(0deg)';
    } else {
        currentSubmenu.style.maxHeight = currentSubmenu.scrollHeight + "px";
        currentIcon.style.transform = 'rotate(180deg)';
    }
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileCategoryMenu = document.getElementById('mobileCategoryMenu');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === this) {
                window.toggleMenu();
            }
        });
    }

    if (mobileCategoryMenu) {
        mobileCategoryMenu.addEventListener('click', function(e) {
            if (e.target === this) {
                window.toggleCategoryMenu();
            }
        });
    }
});