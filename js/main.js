document.addEventListener('DOMContentLoaded', function () {

    // ---- MAKE ALL EXTERNAL LINKS OPEN IN NEW TAB ----
    const links = document.querySelectorAll('a');

    // Filter and modify external links
    Array.from(links)
        .filter(link => link.hostname && link.hostname !== window.location.hostname)
        .forEach(link => link.setAttribute('target', '_blank'));


    const navbar = document.querySelector('.navbar');
    const navbarDropper = document.querySelector('.navbar-dropper');
    const menuToggle = document.querySelector('.menu-toggle');
    const menuToggleDropper = document.querySelector('.menu-toggle-dropper');

    const offsetTop = navbar ? navbar.offsetTop : 0; // Ensure navbar exists
    const scrollBuffer = 40;

    let menuDropdownActive = false;
    let menuScrollActive = false;

    // Function to handle visibility of navbar dropper
    function toggleNavbarDropper(visible) {
        if (visible) {
            navbarDropper?.classList.add('visible');
        } else {
            navbarDropper?.classList.remove('visible');
        }
    }

    // Function to handle toggling menu visibility
    function toggleMenu() {
        const navItemsContainer = document.querySelector('.menu-items');
        const dropdownContainer = document.querySelector('.menu-items-dropper');

        navItemsContainer?.classList.toggle('menu-expanded');
        dropdownContainer?.classList.toggle('menu-expanded');

        menuDropdownActive = !menuDropdownActive;
        toggleNavbarDropper(menuScrollActive || menuDropdownActive);
    }

    // Event listener for scroll
    window.addEventListener('scroll', function () {
        if (window.scrollY > offsetTop + scrollBuffer) {
            menuScrollActive = true;
            toggleNavbarDropper(true);
        } else {
            if (!menuDropdownActive) {
                menuScrollActive = false;
                toggleNavbarDropper(false);
            }
        }
    });






    // Event listener for hamburger menu toggle
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleMenu);
    }

    // Event listener for second menu toggle
    if (menuToggleDropper) {
        menuToggleDropper.addEventListener('click', toggleMenu);
    }

    // Initialize menu state based on its visibility
    function initializeMenuState() {
        const navItemsContainer = document.querySelector('.menu-items');
        const dropdownContainer = document.querySelector('.menu-items-dropper');

        if (navItemsContainer?.classList.contains('menu-expanded')) {
            menuDropdownActive = true;
        } else {
            menuDropdownActive = false;
        }

        toggleNavbarDropper(menuDropdownActive || menuScrollActive);
    }

    // if nav-darkener exists, make it the size of navbar
    // Function to set the nav-darkener height
    function setNavDarkenerHeight() {
        const navDarkener = document.querySelector('.nav-darkener');
        if (navDarkener && navbar) {
            navDarkener.style.height = `${navbar.offsetHeight}px`;
        }
    }

    // Ensure DOM is ready and then set nav-darkener height
    window.addEventListener('load', setNavDarkenerHeight);  // Wait for all assets (images, fonts) to load

    // Call it once on DOMContentLoaded in case some heights are available
    setNavDarkenerHeight();
    initializeMenuState();





    // OVERLAY FOOTNOTE TEXT
    document.querySelectorAll('.fn a').forEach(anchor => {
        // Mouse enter event
        anchor.addEventListener('mouseenter', (event) => {
            //console.log("hovered");

            // Get mouse position
            const mouseX = event.pageX;
            const mouseY = event.pageY;

            // Set position of footnote-overlay
            const footnoteOverlay = document.getElementById('footnote-overlay');
            footnoteOverlay.style.top = mouseY + 20 + 'px';
            footnoteOverlay.style.left = mouseX + 'px';

            // Get the target section ID from the href attribute
            let targetSectionID = anchor.getAttribute('href');
            targetSectionID = targetSectionID.replace('#', '');

            // Get the parent of the target section
            const targetSection = document.getElementById(targetSectionID);
            if (targetSection) {
                // Get the inner HTML of the target section and remove the last <a> tag
                let targetSectionText = targetSection.innerHTML;
                targetSectionText = targetSectionText.substring(0, targetSectionText.lastIndexOf('<a'));

                // Add text to footnoteOverlay
                footnoteOverlay.innerHTML = targetSectionText;

                // Check if the overlay goes off-screen and adjust its position
                const footnoteOverlayWidth = footnoteOverlay.offsetWidth;
                const windowWidth = window.innerWidth;
                if (mouseX + footnoteOverlayWidth > windowWidth) {
                    footnoteOverlay.style.left = (mouseX - footnoteOverlayWidth - 20) + 'px';
                }

                // Add the visible class
                footnoteOverlay.classList.add('visible');
                const fullcover = document.getElementById('fullcover');
                if (fullcover) fullcover.classList.add('visible');
            }
        });

        // Mouse leave event
        anchor.addEventListener('mouseleave', () => {
            setTimeout(() => {
                const footnoteOverlay = document.getElementById('footnote-overlay');
                if (footnoteOverlay) footnoteOverlay.classList.remove('visible');

                const fullcover = document.getElementById('fullcover');
                if (fullcover) fullcover.classList.remove('visible');
            }, 180);

        });
    });





    // WIGGLE TOC LINKS
    document.querySelectorAll('.toc-link').forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.classList.add('toc-highlight');
        });

        link.addEventListener('mouseleave', () => {
            link.classList.remove('toc-highlight');
        });
    });


    // SCROLL WITH SCROLL-LINK (maybe not in use)
    document.querySelectorAll('.scroll-link').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const navbarHeight = document.querySelector('.navbar-dropper').offsetHeight;
            const targetSectionID = link.getAttribute('href');
            const targetSection = document.querySelector(targetSectionID);

            if (targetSection) {
                const targetOffset = targetSection.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                    top: targetOffset - navbarHeight,
                    behavior: 'smooth'
                });
            }
        });
    });

    // scroll to area when .fn a is clicked
    document.querySelectorAll('.fn a').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const navbarHeight = document.querySelector('.navbar-dropper').offsetHeight;
            const scrollBuffer = 20; // Adjust as needed

            // Get target element
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                // Calculate scroll position
                const targetOffset = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - scrollBuffer;

                // Smooth scroll
                window.scrollTo({
                    top: targetOffset,
                    behavior: 'smooth'
                });

                // Add highlight classes
                targetElement.classList.add('highlight', 'wiggle');

                // Remove classes after delay
                setTimeout(() => {
                    targetElement.classList.remove('highlight', 'wiggle');
                }, 3000);
            }
        });
    });



    // scroll up when last a within wp-block-footnotes is clicked
    document.querySelectorAll('.wp-block-footnotes a:last-child').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const navbarHeight = document.querySelector('.navbar-dropper').offsetHeight;
            const scrollBuffer = 20;
            const targetId = link.getAttribute('href');

            // Debug logging
            //console.log('Target ID:', targetId);

            // Remove hash if present
            const cleanId = targetId.replace('#', '');
            const targetElement = document.getElementById(cleanId);

            if (targetElement) {
                const rect = targetElement.getBoundingClientRect();
                console.log('Element position:', {
                    top: rect.top,
                    offset: window.pageYOffset,
                    navHeight: navbarHeight,
                    total: rect.top + window.pageYOffset
                });

                const targetOffset = Math.max(0, rect.top + window.pageYOffset - navbarHeight - (scrollBuffer * 2));

                window.scrollTo({
                    top: targetOffset,
                    behavior: 'smooth'
                });
            } else {
                console.error('Target element not found:', targetId);
            }
        });
    });



    function getLastSentence(text) {
        // Define a regular expression to split the text into sentences
        var sentenceRegex = /[^.!?]+[.!?]+(?=\s|$)/g;

        // Use the regular expression to split the text into sentences
        var sentences = text.match(sentenceRegex);

        // If there are sentences, return the last one; otherwise, return an empty string
        if (sentences && sentences.length > 0) {
            return sentences[sentences.length - 1].trim(); // Trim to remove leading/trailing whitespace
        } else {
            return "";
        }
    }




    // if .swiper exists
    if (document.querySelector('.swiper')) {
        console.log('Swiper element found, attempting to initialize...');
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // multiple items per page
            slidesPerView: 1,
            centerMode: true,
            spaceBetween: 12,
            // allowTouchMove: false,

            mousewheel: {
                forceToAxis: true
            },

            breakpoints: {
                510: {
                    slidesPerView: 2,
                },
                780: {
                    slidesPerView: 3,
                },
                1100: {
                    slidesPerView: 4,
                },
                1400: {
                    slidesPerView: 5,
                },
                1650: {
                    slidesPerView: 6,
                }
            },


            // automatic slide
            autoplay: {
                delay: 3000,
            },

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
        swiper.setGrabCursor()
    }



    // IMAGE POPOVERS
    const imageoverlay = document.getElementsByClassName("image-overlay")[0];
    const hovers = document.getElementsByClassName("image-hover");

    // add event listener to each hover, creating a popover image using the data-image attribute
    for (let i = 0; i < hovers.length; i++) {
        hovers[i].addEventListener("mouseover", function (e) {

            // if target doesnt have image data attribute
            if (!e.target.dataset.image) {
                return;
            }

            // const image = document.createElement("img");
            // image.src = e.target.dataset.image;
            // image.classList.add("popover");
            // imageoverlay.appendChild(image);

            // popunder
            const toctext = document.getElementsByClassName("toc-text")[0];
            // change background-image of toctext
            toctext.style.backgroundImage = "url('" + e.target.dataset.image + "')";

        });

        hovers[i].addEventListener("mouseout", function (e) {

            // if imageoverlay has no children, return
            // if (!imageoverlay.hasChildNodes()) {
            //     return;
            // }

            // imageoverlay.removeChild(imageoverlay.lastChild);

            // remove background image of toctext
            const toctext = document.getElementsByClassName("toc-text")[0];
            toctext.style.backgroundImage = "none";
        });
    }






    // ---- AUTHOR HOVER ----
    document.querySelectorAll('.author-hover').forEach(item => {
        item.addEventListener('mouseenter', (event) => {
            const mouseX = event.pageX;
            const mouseY = event.pageY;

            // Get site URL
            const siteURL = window.location.origin;

            // Get postID from data-author-id
            const postID = item.getAttribute('data-author-id');

            // Fetch author data
            fetch(`${siteURL}/wp-json/wp/v2/authors/${postID}`)
                .then(response => response.json())
                .then(data => {
                    const postContent = data.content.rendered;

                    // Convert "<BR>" in postContent to actual <br> tag
                    const escapedContent = postContent.replace(/<br>/g, '&lt;br&gt;');

                    // Set position of author-overlay
                    const authorOverlay = document.getElementById('author-overlay');
                    authorOverlay.style.top = mouseY + 20 + 'px';
                    authorOverlay.innerHTML = escapedContent;

                    // Adjust horizontal position of authorOverlay
                    const authorOverlayWidth = authorOverlay.offsetWidth;
                    const windowWidth = window.innerWidth;
                    authorOverlay.style.left = (windowWidth / 2 - authorOverlayWidth / 2) + 'px';

                    // Add visible class
                    authorOverlay.classList.add('visible');

                    const fullcover = document.getElementById('fullcover');
                    fullcover.classList.add('visible');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        item.addEventListener('mouseleave', () => {
            setTimeout(() => {
                const authorOverlay = document.getElementById('author-overlay');
                authorOverlay.classList.remove('visible');

                const fullcover = document.getElementById('fullcover');
                fullcover.classList.remove('visible');
            }, 250);
        });
    });



    // author-overlay remain visible while hovered
    const authorOverlay = document.getElementById('author-overlay');
    const fullcover = document.getElementById('fullcover');

    if (authorOverlay && fullcover) {
        // Mouse enter handler
        authorOverlay.addEventListener('mouseenter', () => {
            authorOverlay.classList.add('visible2');
            fullcover.classList.add('visible2');
        });

        // Mouse leave handler
        authorOverlay.addEventListener('mouseleave', () => {
            setTimeout(() => {
                authorOverlay.classList.remove('visible2', 'visible');
                fullcover.classList.remove('visible2', 'visible');
            }, 180);
        });
    }




    // if .water-stories-dropper is clicked, show its .sub-menu
    // Handle top-level menu clicks (only one open at a time)
    document.querySelectorAll(".water-stories-dropper").forEach(dropdownParent => {
        const dropdownTrigger = dropdownParent.querySelector("a:first-child");

        if (dropdownTrigger) {
            dropdownTrigger.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                const submenu = dropdownParent.querySelector(".sub-menu");

                if (submenu) {
                    // Close all other top-level submenus before opening this one
                    document.querySelectorAll(".water-stories-dropper .sub-menu").forEach(menu => {
                        if (menu !== submenu) {
                            closeSubmenu(menu);
                        }
                    });

                    submenu.classList.toggle("active");

                    // If submenu is now inactive, remove 'active' from all children
                    if (!submenu.classList.contains("active")) {
                        closeAllChildren(submenu);
                    }
                }
            });
        }
    });

    // Handle nested submenus (only one submenu per level should stay open)
    document.addEventListener("click", (e) => {
        const submenuItem = e.target.closest(".water-stories-dropper .sub-menu li");

        if (submenuItem) {
            const childSubmenu = submenuItem.querySelector(".sub-menu");

            if (childSubmenu) {
                e.preventDefault();
                e.stopPropagation();

                // Close all sibling submenus before opening this one
                submenuItem.parentElement.querySelectorAll(":scope > li > .sub-menu").forEach(menu => {
                    if (menu !== childSubmenu) {
                        closeSubmenu(menu);
                    }
                });

                childSubmenu.classList.toggle("active");

                // If submenu is now inactive, remove 'active' from all children
                if (!childSubmenu.classList.contains("active")) {
                    closeAllChildren(childSubmenu);
                }
            }
        }
    });

    // Function to close a submenu and update its arrow
    function closeSubmenu(submenu) {
        submenu.classList.remove("active");
        closeAllChildren(submenu); // Also close all child submenus
    }

    // Function to remove 'active' from all child submenus
    function closeAllChildren(parentSubmenu) {
        parentSubmenu.querySelectorAll(".sub-menu.active").forEach(childSubmenu => {
            childSubmenu.classList.remove("active");
        });
    }




    // debug key handler
    document.addEventListener('keydown', (event) => {
        if (event.key === 'h') {
            const dropper = document.querySelector('.water-stories-dropper');
            if (dropper) {
                dropper.classList.toggle('hidden');
            }
        }
    });


});