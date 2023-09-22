document.addEventListener('DOMContentLoaded', function () {


    const scrollBuffer = 40;
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



    // OVERLAY FOOTNOTE TEXT and wiggle?
    jQuery('.fn a').hover(function () {

        console.log("hovered");

        // var targetId = jQuery(this).attr('href');
        // var listItem = jQuery(targetId);

        // if (listItem.length) {
        //     // Add a class to trigger the "wiggle" effect
        //     listItem.addClass('wiggle');
        // }

        // position footnote-overlay just below the mouse
        // get mouse position on screen
        var mouseX = event.pageX;
        var mouseY = event.pageY;

        // set position of footnote-overlay
        var footnoteOverlay = document.getElementById('footnote-overlay');
        footnoteOverlay.style.top = mouseY + 20 + 'px';
        footnoteOverlay.style.left = mouseX + 'px';


        // set footnote-overlay text
        var targetSectionID = jQuery(this).attr('href');
        // strip # from targetSectionID
        targetSectionID = targetSectionID.replace('#', '');
        // get parent of targetsectionID
        var targetSection = document.getElementById(targetSectionID);
        // log the html of targetSection
        var targetSectionText = targetSection.innerHTML;
        // remove the last a tag from targetSectionText
        targetSectionText = targetSectionText.substring(0, targetSectionText.lastIndexOf('<a'));
        // add text to footnoteOverlay
        footnoteOverlay.innerHTML = targetSectionText;

        // if footnoteOverlay goes off screen, move it to the left
        var footnoteOverlayWidth = footnoteOverlay.offsetWidth;
        var windowWidth = window.innerWidth;
        if (mouseX + footnoteOverlayWidth > windowWidth) {
            footnoteOverlay.style.left = mouseX - footnoteOverlayWidth - 20 + 'px';
        }

        // add class visible
        footnoteOverlay.classList.add('visible');
        var fullcover = document.getElementById('fullcover');
        fullcover.classList.add('visible');


    }, function () {

        // remove class visible after 1 second
        setTimeout(function () {
            var footnoteOverlay = document.getElementById('footnote-overlay');
            footnoteOverlay.classList.remove('visible');
            var fullcover = document.getElementById('fullcover');
            fullcover.classList.remove('visible');
        }, 180);

        // Remove the wiggle class when the hover ends
        // var targetId = jQuery(this).attr('href');
        // var listItem = jQuery(targetId);

        // if (listItem.length) {
        //     listItem.removeClass('wiggle');
        // }
    });

    // footnote-overlay remain visible while hovered
    jQuery('#footnote-overlay').hover(function () {
        // add class visible
        this.classList.add('visible2');
        // make fullcover visible
        var fullcover = document.getElementById('fullcover');
        fullcover.classList.add('visible2');

    }, function () {
        // remove class visible after 1 second
        setTimeout(function () {
            var footnoteOverlay = document.getElementById('footnote-overlay');
            footnoteOverlay.classList.remove('visible2');
            var fullcover = document.getElementById('fullcover');
            fullcover.classList.remove('visible2');
        }, 180);
    });




    // WIGGLE TOC LINKS
    jQuery('.toc-link').hover(function () {
        // jQuery(this).addClass('wiggle');
        jQuery(this).addClass('toc-highlight');
    }, function () {
        // jQuery(this).removeClass('wiggle');
        jQuery(this).removeClass('toc-highlight');
    });



    // SCROLL WITH SCROLL-LINK
    jQuery('.scroll-link').click(function (event) {

        // get height of .navbar-dropper
        var navbarHeight = jQuery('.navbar-dropper').outerHeight();

        event.preventDefault(); // Prevent default link behavior

        // Get the target section ID from the href attribute of the clicked link
        var targetSectionID = jQuery(this).attr('href');

        // Calculate the target section's offset from the top of the page
        // but account for navbar height
        // var targetOffset = jQuery(targetSectionID).offset().top - navbarHeight - scrollBuffer;
        var targetOffset = jQuery(targetSectionID).offset().top;

        // Smoothly scroll to the target section
        jQuery('html, body').animate(
            {
                scrollTop: targetOffset
            },
            200 // Animation duration in milliseconds
        );
    });

    // scroll to area when .fn a is clicked
    jQuery('.fn a').click(function (event) {

        // get height of .navbar-dropper
        var navbarHeight = jQuery('.navbar-dropper').outerHeight();

        event.preventDefault(); // Prevent default link behavior

        // Get the target section ID from the href attribute of the clicked link
        var targetSectionID = jQuery(this).attr('href');

        // Calculate the target section's offset from the top of the page
        // but account for navbar height
        var targetOffset = jQuery(targetSectionID).offset().top - navbarHeight - scrollBuffer;


        // Smoothly scroll to the target section
        jQuery('html, body').animate(
            {
                scrollTop: targetOffset
            },
            200 // Animation duration in milliseconds
        );

        // get the li parent of this a element
        var targetId = jQuery(this).attr('href');
        var listItem = jQuery(targetId);

        if (listItem.length) {

            listItem.addClass('highlight');
            listItem.addClass('wiggle');

            // remove highlight class after 1 second
            setTimeout(function () {
                listItem.removeClass('highlight');
                listItem.removeClass('wiggle');
            }, 3000);
        }

    });

    // scroll up when last a within wp-block-footnotes is clicked
    jQuery('.wp-block-footnotes a:last-child').click(function (event) {

        // get height of .navbar-dropper
        var navbarHeight = jQuery('.navbar-dropper').outerHeight();

        event.preventDefault(); // Prevent default link behavior

        // Get the target section ID from the href attribute of the clicked link
        var targetSectionID = jQuery(this).attr('href');

        // Calculate the target section's offset from the top of the page
        // but account for navbar height
        var targetOffset = jQuery(targetSectionID).offset().top - navbarHeight - scrollBuffer * 2;

        // Smoothly scroll to the target section
        jQuery('html, body').animate(
            {
                scrollTop: targetOffset
            },
            200 // Animation duration in milliseconds
        );

        // add a temporary highlight to the text which the footnote is referring to

        // // strip # from targetSectionID
        // targetSectionID = targetSectionID.replace('#', '');
        // // get parent of targetsectionID
        // var targetSection = document.getElementById(targetSectionID);
        // var targetSectionParent = targetSection.parentNode;
        // // get parent paragraph of targetSectionParent
        // var targetSectionParentParent = targetSectionParent.parentNode;
        // // log the html of targetSectionParentParent
        // var targetSectionParentParentText = targetSectionParentParent.innerHTML;
        // // locate targetSection in targetSectionParentParentText
        // var targetSectionIndex = targetSectionParentParentText.indexOf(targetSectionID);
        // // get the text before targetSection
        // var targetSectionParentParentTextBefore = targetSectionParentParentText.substring(0, targetSectionIndex);
        // // only take the text before "<sup>"
        // var targetSectionParentParentTextBefore = targetSectionParentParentTextBefore.substring(0, targetSectionParentParentTextBefore.lastIndexOf('<sup'));
        // // only take the last sentence of targetSectionParentParentTextBefore
        // var lastSentence = getLastSentence(targetSectionParentParentTextBefore);
        // // remove all html tags from lastSentence
        // lastSentence = lastSentence.replace(/(<([^>]+)>)/gi, "");
        // // Create a new span element with the "highlight" class
        // var highlightSpan = document.createElement("span");
        // // give highlightSpan an ID
        // highlightSpan.id = 'temp-highlight';
        // // Set the text content of the span to the lastSentence
        // highlightSpan.textContent = lastSentence;
        // // save old html for a sec
        // const oldHtml = targetSectionParentParent.innerHTML;
        // // Replace the lastSentence within targetSectionParentParent with the highlightSpan
        // targetSectionParentParent.innerHTML = targetSectionParentParentText.replace(lastSentence, highlightSpan.outerHTML);

        // // add class highlight to #temp-highlight
        // var tempHighlight = document.getElementById('temp-highlight');
        // tempHighlight.classList.add('highlight');
        // // remove after 3 seconds
        // setTimeout(function () {
        //     tempHighlight.classList.remove('highlight');
        //     targetSectionParentParent.innerHTML = oldHtml;
        // }, 3000);

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
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // multiple items per page
            slidesPerView: 1,
            centerMode: true,
            spaceBetween: 12,
            // allowTouchMove: false,

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



    // ---- MAKE ALL EXTERNAL LINKS OPEN IN NEW TAB ----
    jQuery(document).ready(function ($) {
        // Find all external links on the page
        $('a').filter(function () {
            return this.hostname && this.hostname !== location.hostname;
        }).attr('target', '_blank');
    });


    // ---- AUTHOR HOVER ----
    jQuery('.author-hover').hover(function () {

        var mouseX = event.pageX;
        var mouseY = event.pageY;


        // get site URL
        var siteURL = window.location.origin;

        // get postID from data-author-id
        var postID = jQuery(this).attr('data-author-id');

        fetch(`${siteURL}/wp-json/wp/v2/authors/${postID}`)
            .then(response => response.json())
            .then(data => {

                const postContent = data.content.rendered;

                // set position of author-overlay
                var authorOverlay = document.getElementById('author-overlay');
                authorOverlay.style.top = mouseY + 20 + 'px';

                authorOverlay.innerHTML = postContent;

                // if authorOverlay goes off screen, move it to the left
                var authorOverlayWidth = authorOverlay.offsetWidth;
                var windowWidth = window.innerWidth;
                // put authorOverlay in the middle
                authorOverlay.style.left = windowWidth / 2 - authorOverlayWidth / 2 + 'px';

                // add class visible
                authorOverlay.classList.add('visible');
                var fullcover = document.getElementById('fullcover');
                fullcover.classList.add('visible');


            })
            .catch(error => {
                console.error('Error:', error);
            });

    },
        function () {
            setTimeout(function () {
                var authorOverlay = document.getElementById('author-overlay');
                authorOverlay.classList.remove('visible');
                var fullcover = document.getElementById('fullcover');
                fullcover.classList.remove('visible');
            }, 180);
        });


    // author-overlay remain visible while hovered
    jQuery('#author-overlay').hover(function () {
        // add class visible
        this.classList.add('visible2');
        // make fullcover visible
        var fullcover = document.getElementById('fullcover');
        fullcover.classList.add('visible2');

    }, function () {
        // remove class visible after 1 second
        setTimeout(function () {
            var authorOverlay = document.getElementById('author-overlay');
            authorOverlay.classList.remove('visible2');
            var fullcover = document.getElementById('fullcover');
            fullcover.classList.remove('visible2');
        }, 180);
    });


    // if nav-darkener exists, make it the size of navbar
    if (document.querySelector('.nav-darkener')) {
        const navDarkener = document.querySelector('.nav-darkener');
        const navbar = document.querySelector('.navbar');
        navDarkener.style.height = navbar.offsetHeight + 'px';
    }

    // if page isnt tall enough...
    function adjustFooter() {
        var windowHeight = jQuery(window).height();
        var bodyHeight = jQuery('body').height();
        
        if (windowHeight > bodyHeight) {
            jQuery('footer').css({
                position: 'absolute',
                bottom: 0,
                width: '100%'
            });
        } else {
            jQuery('footer').css({
                position: 'static'
            });
        }
    }

    // Adjust the footer on page load and window resize
    adjustFooter();
    jQuery(window).resize(adjustFooter);
});