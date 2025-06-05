document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', function () {
      if (mobileMenu.classList.contains('hidden')) {
        openMobileMenu();
      } else {
        closeMobileMenu();
      }
    });
  }

  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
      closeMobileMenu();
    }
  });

  function openMobileMenu() {
    mobileMenu.classList.remove('hidden');
    mobileMenu.classList.add('flex');
    mobileMenu.classList.remove('animate-slide-up');
    void mobileMenu.offsetWidth;
    mobileMenu.classList.add('animate-slide-down');

    menuToggle.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>`;
  }

  function closeMobileMenu() {
    mobileMenu.classList.remove('animate-slide-down');
    mobileMenu.classList.add('animate-slide-up');

    setTimeout(() => {
      mobileMenu.classList.add('hidden');
      mobileMenu.classList.remove('flex', 'animate-slide-up');
    }, 300);

    menuToggle.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>`;
  }

  const mobileMenuItems = document.querySelectorAll('.mobile-nav a');
  mobileMenuItems.forEach(item => {
    item.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        closeMobileMenu();
      }
    });
  });
});

    document.addEventListener('DOMContentLoaded', function() {
      const modalOverlay = document.getElementById('modalOverlay');
      const editProfileBtn = document.getElementById('editProfileBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      
      // Modal open
      editProfileBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'flex';
      });
      
      // Modal close with cancel button
      cancelBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'none';
      });
      
      // Modal close when clicking outside
      modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
          modalOverlay.style.display = 'none';
        }
      });
    });