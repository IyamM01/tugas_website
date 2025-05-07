/**
 * profile.js - JavaScript for hhibookstore Profile Page
 * Handles responsive navigation and UI interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Mobile menu toggle functionality
    if (menuToggle && mobileMenu) {
      menuToggle.addEventListener('click', function() {
        if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
          openMobileMenu();
        } else {
          closeMobileMenu();
        }
      });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        closeMobileMenu();
      }
    });
    
    // Helper functions for mobile menu
    function openMobileMenu() {
      mobileMenu.style.display = 'flex';
      menuToggle.classList.remove('fa-bars');
      menuToggle.classList.add('fa-times');
      
      // Optional animation
      mobileMenu.style.opacity = '0';
      setTimeout(() => {
        mobileMenu.style.opacity = '1';
      }, 10);
    }
    
    function closeMobileMenu() {
      mobileMenu.style.display = 'none';
      menuToggle.classList.remove('fa-times');
      menuToggle.classList.add('fa-bars');
    }
    
    // Add event listeners to mobile menu items (optional)
    const mobileMenuItems = document.querySelectorAll('.mobile-nav a');
    mobileMenuItems.forEach(item => {
      item.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          closeMobileMenu();
        }
      });
    });
    
    // Initialize any tooltips or popovers (if using Bootstrap)
    if (typeof bootstrap !== 'undefined') {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    }
  });