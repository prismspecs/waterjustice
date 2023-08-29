document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            const menuItemsContainer = document.querySelector('.menu-items');
            menuItemsContainer.classList.toggle('menu-expanded');
        });
    }

    // same but for 2nd menu
    const menuToggleDropper = document.querySelector('.menu-toggle-dropper');

    if (menuToggleDropper) {
        menuToggleDropper.addEventListener('click', function () {
            const menuItemsContainer = document.querySelector('.menu-items-dropper');
            menuItemsContainer.classList.toggle('menu-expanded');
        });
    }

    // make navbar fixed if scrolled down
    const navbar = document.querySelector('.navbar');
    const navbar_dropper = document.querySelector('.navbar-dropper');
    const offsetTop = navbar.offsetTop;

    window.addEventListener('scroll', function () {
        if (window.pageYOffset > offsetTop) {
            navbar_dropper.classList.add('visible');
        } else {
            navbar_dropper.classList.remove('visible');
        }
    });




    // if .swiper exists
    if (document.querySelector('.swiper')) {
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // multiple items per page
            slidesPerView: 3,
            centerMode: true,
            spaceBetween: 30,


            // automatic slide
            // autoplay: {
            //     delay: 3000,
            // },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            // scrollbar: {
            //     el: '.swiper-scrollbar',
            // },
        });
    }
});


