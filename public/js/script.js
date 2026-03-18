
// 1. Theme Toggle (Always runs)
const body = document.body;
const toggleBtn = document.querySelector('.theme-toggle');
if (toggleBtn) {
    const icon = toggleBtn.querySelector('i');
    // Load saved mode
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        icon.classList.replace("bx-moon", "bx-sun");
    }
    toggleBtn.addEventListener("click", () => {
        body.classList.toggle("dark-mode");
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            icon.classList.replace("bx-moon", "bx-sun");
        } else {
            localStorage.setItem("theme", "light");
            icon.classList.replace("bx-sun", "bx-moon");
        }
    });
}

// 2. Hero content animation
window.addEventListener('load', () => {
    const hero = document.querySelector('.header-content');
    if (hero) hero.classList.add('show');
});

// 3. Navbar logic (Only if navbar exists)
const navbar = document.querySelector('.navbar');
const menuIcon = document.querySelector('.menu-icon');
const navLinks = document.querySelector('.nav-links');
const overlay = document.querySelector('.overlay');

let scrollPos = 0;

if (navbar && menuIcon && navLinks && overlay) {
    menuIcon.addEventListener('click', () => {
        const isOpen = navbar.classList.toggle('menu-active');
        navLinks.classList.toggle('mobile-menu');
        overlay.classList.toggle("active");

        if (isOpen) {
            scrollPos = window.scrollY;
            body.style.position = 'fixed';
            body.style.top = `-${scrollPos}px`;
            body.style.width = '100%';
            menuIcon.classList.toggle('bx-x', isOpen);
            menuIcon.classList.toggle('bx-menu', !isOpen);
        } else {
            body.style.position = '';
            body.style.top = '';
            body.style.width = '';
            window.scrollTo(0, scrollPos);
            menuIcon.classList.toggle('bx-x', isOpen);
            menuIcon.classList.toggle('bx-menu', !isOpen);
        }
        body.classList.toggle('no-scroll');
    });

    function closeMobileMenu() {
        navbar.classList.remove('menu-active');
        navLinks.classList.remove('mobile-menu');
        overlay.classList.remove('active');
        body.classList.remove('no-scroll');
        body.style.position = '';
        body.style.top = '';
        body.style.width = '';
        menuIcon.classList.replace('bx-x', 'bx-menu');
        window.scrollTo(0, scrollPos);
    }

    window.addEventListener("resize", () => {
        if (window.innerWidth > 1250) {
            closeMobileMenu();
        }
    });

    function checkScroll() {
        const scroll = window.scrollY || window.pageYOffset;
        if (scroll > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', checkScroll);
    window.addEventListener('load', checkScroll);

    // Search Wrapper
    const searchWrapper = document.querySelector('.search-wrapper');
    const searchInput = document.querySelector('.search-input');
    const searchIcon = document.querySelector('.search-icon');
    const searchForm = document.getElementById('navbar-search-form');
    
    if (searchWrapper && searchIcon && searchInput) {
        searchIcon.addEventListener('click', (e) => {
            if (searchWrapper.classList.contains('active')) {
                // If it's already active and user clicks icon, submit the form if there's text
                if (searchInput.value.trim() !== "") {
                    searchForm.submit();
                } else {
                    searchWrapper.classList.remove('active');
                }
            } else {
                // If not active, expand it
                searchWrapper.classList.add('active');
                searchInput.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchWrapper.contains(e.target)) {
                searchWrapper.classList.remove('active');
            }
        });
    }
}

// 4. Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerOffset = 20;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    });
});
