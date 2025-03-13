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
// Chat Widget Toggle Function with improved transitions
window.toggleChat = function() {
    const chatWidget = document.getElementById('chatWidget');
    if (!chatWidget) return;

    // Define transition classes
    const transitionClasses = 'transition-all duration-300 ease-in-out';

    if (!chatWidget.classList.contains(transitionClasses)) {
        chatWidget.classList.add(...transitionClasses.split(' '));
    }

    if (chatWidget.classList.contains('invisible')) {
        // Show chat with smooth animation
        chatWidget.classList.remove('invisible');
        requestAnimationFrame(() => {
            chatWidget.classList.remove('opacity-0', 'translate-y-full', 'scale-95');
            chatWidget.classList.add('opacity-100', 'translate-y-0', 'scale-100');
        });
    } else {
        // Hide chat with smooth animation
        chatWidget.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
        chatWidget.classList.add('opacity-0', 'translate-y-full', 'scale-95');

        // Wait for animation to complete
        chatWidget.addEventListener('transitionend', function handler() {
            chatWidget.classList.add('invisible');
            chatWidget.removeEventListener('transitionend', handler);
        });
    }
}

// Floating Buttons Toggle Function with improved animations
window.toggleFloatingButtons = function() {
    const hiddenButtons = document.getElementById('hiddenButtons');
    if (!hiddenButtons) return;

    if (hiddenButtons.classList.contains('scale-0')) {
        // Show buttons with bottom-up stagger effect
        hiddenButtons.classList.remove('scale-0', 'opacity-0');
        hiddenButtons.classList.add('scale-100', 'opacity-100');

        // Animate each button with delay and bottom-up transition
        const buttons = hiddenButtons.querySelectorAll('a');
        buttons.forEach((button, index) => {
            button.style.transitionDelay = `${index * 100}ms`;
            requestAnimationFrame(() => {
                button.classList.remove('scale-0', 'opacity-0', 'translate-y-10');
                button.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            });
        });
    } else {
        // Hide buttons with reverse stagger effect
        const buttons = hiddenButtons.querySelectorAll('a');
        [...buttons].reverse().forEach((button, index) => {
            button.style.transitionDelay = `${index * 100}ms`;
            button.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            button.classList.add('scale-0', 'opacity-0', 'translate-y-10');
        });

        // Final cleanup after all buttons have animated
        setTimeout(() => {
            hiddenButtons.classList.remove('scale-100', 'opacity-100');
            hiddenButtons.classList.add('scale-0', 'opacity-0');
            // Reset transition delays
            buttons.forEach(button => {
                button.style.transitionDelay = '0s';
            });
        }, buttons.length * 100);
    }
}

// Enhanced click outside handler for floating buttons
document.addEventListener('click', function(event) {
    const floatingButtons = document.querySelector('.fixed.left-4.bottom-20');
    const hiddenButtons = document.getElementById('hiddenButtons');
    const toggleButton = event.target.closest('[onclick*="toggleFloatingButtons"]');

    if (!floatingButtons || !hiddenButtons) return;

    if (!toggleButton &&
        !floatingButtons.contains(event.target) &&
        !hiddenButtons.classList.contains('scale-0')) {
        toggleFloatingButtons();
    }
});
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

    const hiddenButtons = document.getElementById('hiddenButtons');
    const mainButton = document.querySelector('.fixed.left-4.bottom-20');

    if (hiddenButtons && mainButton) {
        // Add initial state classes
        hiddenButtons.classList.add('transition-all', 'duration-300', 'ease-in-out', 'scale-0', 'opacity-0', 'origin-bottom-left');

        // Add initial state to child buttons with translate-y for bottom-up animation
        const buttons = hiddenButtons.querySelectorAll('a');
        buttons.forEach(button => {
            button.classList.add('scale-0', 'opacity-0', 'translate-y-10', 'transition-all', 'duration-300', 'ease-in-out');
            button.style.transformOrigin = 'bottom left';
        });

        // Trigger initial animation after a small delay
        setTimeout(() => {
            mainButton.classList.add('animate-bounce');
            setTimeout(() => {
                mainButton.classList.remove('animate-bounce');
            }, 1000);
        }, 1500);
    }
});
