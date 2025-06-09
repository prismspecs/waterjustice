document.addEventListener('DOMContentLoaded', function () {
    const indexMenu = document.querySelector('.index-menu');
    const indexContent = document.querySelector('.index-content');
    const allButton = indexMenu ? indexMenu.querySelector('a[data-category-slug="all"]') : null;
    let allPosts = []; // To store all posts once they are fetched.

    /**
     * Initializes the entire index functionality.
     */
    function init() {
        if (!indexMenu || !indexContent || !allButton) {
            console.error('Index component is missing required elements.');
            return;
        }
        
        setupEventListeners();
        fetchAllWaterStories();
    }

    /**
     * Sets up all the necessary click handlers for the filter menu.
     */
    function setupEventListeners() {
        indexMenu.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;

            e.preventDefault();
            const listItem = link.parentElement;

            if (listItem.classList.contains('has-children')) {
                listItem.classList.toggle('open');
            } else if (listItem.classList.contains('is-filterable')) {
                handleFilterClick(link);
            }
        });
    }

    /**
     * Handles the logic for a click on a filterable link.
     * @param {HTMLElement} clickedLink - The filter link that was clicked.
     */
    function handleFilterClick(clickedLink) {
        const clickedSlug = clickedLink.dataset.categorySlug;

        if (clickedSlug === 'all') {
            // Scroll to the top of the index section, accounting for the nav bar
            const indexSection = document.querySelector('#menu_index');
            const navbarDropper = document.querySelector('.navbar-dropper');

            if (indexSection && navbarDropper) {
                const navHeight = navbarDropper.offsetHeight;
                const sectionTop = indexSection.getBoundingClientRect().top + window.scrollY;

                window.scrollTo({
                    top: sectionTop - navHeight,
                    behavior: 'smooth'
                });
            }

            indexMenu.querySelectorAll('.is-filterable a').forEach(a => a.classList.remove('active'));
            clickedLink.classList.add('active');
        } else {
            if (allButton) allButton.classList.remove('active');
            clickedLink.classList.toggle('active');
        }

        const anyActive = indexMenu.querySelector('.is-filterable a.active');
        if (!anyActive && allButton) {
            allButton.classList.add('active');
        }
        
        runFilter();
    }
    
    /**
     * Fetches all water stories from the REST API on page load.
     */
    function fetchAllWaterStories() {
        indexContent.innerHTML = '<p>Loading...</p>';
        const url = `/wp-json/wp/v2/water_story?_embed&per_page=100`;
        
        fetch(url)
            .then(response => response.json())
            .then(posts => {
                if (posts && posts.length > 0) {
                    allPosts = posts; // Store all posts
                    renderAllItems(); // Render them all at once
                    
                    // Set up the initial state
                    allButton.classList.add('active');
                    runFilter();
                } else {
                    indexContent.innerHTML = '<p>No stories found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
                indexContent.innerHTML = '<p>Error loading stories.</p>';
            });
    }

    /**
     * Renders all post items into the DOM at once and hides them.
     */
    function renderAllItems() {
        const isMobile = window.innerWidth <= 768;
        let html = '';

        const storyItems = allPosts.map(post => {
            const tags = post._embedded['wp:term'] ? post._embedded['wp:term'].flat().filter(term => term.taxonomy === 'post_tag') : [];
            if (tags.some(tag => tag.slug === 'hide-carousel')) return '';

            const categoryTerms = post._embedded['wp:term']?.find(termArray => termArray[0]?.taxonomy === 'category');
            const categorySlugs = categoryTerms ? categoryTerms.map(term => term.slug).join(' ') : '';
            const title = post.short_title || post.title.rendered;
            
            if (isMobile) {
                // For mobile, we just show a list of titles and authors
                const authorName = post.author_name ? `<span class="mobile-author"> - ${post.author_name}</span>` : '';
                return `<li class="index-list-item hidden" data-category-slugs="${categorySlugs}"><a href="${post.link}">${title}${authorName}</a></li>`;
            } else {
                // For desktop, we use the overlay grid
                const imageUrl = post._embedded['wp:featuredmedia']?.[0]?.source_url || '';
                const authorName = post.author_name ? `<p class="index-grid-item-author">${post.author_name}</p>` : '';

                return `
                    <div class="index-grid-item hidden" data-category-slugs="${categorySlugs}">
                        <a href="${post.link}">
                            <div class="index-grid-item-image" style="background-image: url(${imageUrl})"></div>
                            <div class="index-grid-item-text">
                                <p class="index-grid-item-title">${title}</p>
                                ${authorName}
                            </div>
                        </a>
                    </div>
                `;
            }
        }).join('');

        if (isMobile) {
            html = `<ul>${storyItems}</ul>`;
        } else {
            html = `<div class="index-grid">${storyItems}</div>`;
        }
        indexContent.innerHTML = html;
    }

    /**
     * Applies the current filters to the visible items and animates the container height.
     */
    function runFilter() {
        const activeFilterLinks = indexMenu.querySelectorAll('.is-filterable a.active');
        const selectedSlugs = Array.from(activeFilterLinks).map(link => link.dataset.categorySlug);
        const showAll = selectedSlugs.includes('all');
        const allItems = indexContent.querySelectorAll('.index-grid-item, .index-list-item');

        const onTransitionEnd = () => {
            indexContent.removeEventListener('transitionend', onTransitionEnd);
            indexContent.style.height = 'auto'; // Set to auto when animation finishes
        };
        indexContent.addEventListener('transitionend', onTransitionEnd);

        // Get the container's starting height.
        const startHeight = indexContent.getBoundingClientRect().height;

        // Apply the new filters by toggling classes.
        allItems.forEach(item => {
            const itemCategorySlugs = item.dataset.categorySlugs.split(' ');
            const hasMatch = showAll || selectedSlugs.some(slug => itemCategorySlugs.includes(slug));
            item.classList.toggle('hidden', !hasMatch);
        });

        // Get the container's final height.
        const endHeight = indexContent.getBoundingClientRect().height;
        
        // If height isn't changing, just set to auto and finish.
        if (startHeight === endHeight) {
            indexContent.style.height = 'auto';
            indexContent.removeEventListener('transitionend', onTransitionEnd);
            return;
        }

        // Animate from start to end height.
        indexContent.style.height = `${startHeight}px`;

        // Force browser to repaint/reflow before starting the transition.
        indexContent.offsetHeight;

        // In the next frame, set the target height to trigger the animation.
        requestAnimationFrame(() => {
            indexContent.style.height = `${endHeight}px`;
        });
    }

    // Start the process
    init();
}); 