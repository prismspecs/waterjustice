document.addEventListener('DOMContentLoaded', function () {
    const swimmingQuotes = document.querySelectorAll('.swimming-quote-block');

    // Detect if the device is mobile or desktop
    const isMobile = window.innerWidth <= 768; // Adjust the breakpoint as needed

    swimmingQuotes.forEach((quoteElement) => {
        // Clear the div's content
        quoteElement.innerHTML = '';

        if (isMobile) {
            // Mobile behavior: fade in/out quotes (unchanged)
            quoteElement.style.opacity = 0;
            quoteElement.style.transition = 'opacity 0.5s ease';

            let currentQuoteIndex = -1;

            function updateQuote() {
                quoteElement.style.opacity = 0;

                setTimeout(() => {
                    let randomIndex;
                    do {
                        randomIndex = Math.floor(Math.random() * quotes.length);
                    } while (randomIndex === currentQuoteIndex);

                    currentQuoteIndex = randomIndex;
                    const newQuote = quotes[randomIndex];

                    quoteElement.innerHTML = `
                        <blockquote>${newQuote.quote}</blockquote>
                        <p>${newQuote.author_info}</p>
                    `;

                    quoteElement.style.opacity = 1;
                }, 500);
            }

            updateQuote();
            setInterval(updateQuote, 8000);

        } else {

            // make .swimming-quote-block a child of section with class hero
            // Select the .swimming-quote-block element
            const swimmingQuoteBlock = document.querySelector('.swimming-quote-block');

            // Select the section with the class hero
            const heroSection = document.querySelector('.hero');

            // Append the .swimming-quote-block to the .hero section
            if (swimmingQuoteBlock && heroSection) {
                heroSection.appendChild(swimmingQuoteBlock);
            }

            let currentQuoteIndex = -1;

            function swimQuote() {
                let randomIndex;
                do {
                    randomIndex = Math.floor(Math.random() * quotes.length);
                } while (randomIndex === currentQuoteIndex);

                currentQuoteIndex = randomIndex;
                const newQuote = quotes[randomIndex];

                // Create a new element for the quote
                const quoteText = document.createElement('div');
                // give it class swimming-quote
                quoteText.classList.add('swimming-quote');
                quoteText.innerHTML = `
                    ${newQuote.quote} - ${newQuote.author_info}
                `;


                const words = quoteText.textContent.split(' ');

                // Wrap each word in a span
                quoteText.innerHTML = words.map((word, index) => {
                    return `<span style="--index: ${index}">${word}</span>`;
                }).join(' ');


                // Randomize the initial vertical position within the container
                const containerHeight = quoteElement.offsetHeight;
                const quoteHeight = quoteText.offsetHeight || 50; // Default to 50 if height is not available
                // make it in the lower half of the container
                const maxVerticalOffset = containerHeight / 4;
                let startY = containerHeight * 0.5 + Math.random() * maxVerticalOffset;

                quoteText.style.top = `${startY}px`;

                quoteElement.appendChild(quoteText);

                // Calculate the total distance to travel
                const containerWidth = quoteElement.offsetWidth;
                const quoteWidth = quoteText.offsetWidth;
                const totalDistance = containerWidth + quoteWidth;

                // Set the duration based on the distance to travel
                const speed = 50; // Adjust speed as needed (pixels per second)
                const duration = (totalDistance / speed) * 1000; // Duration in milliseconds

                // calculate vertical amplitude as half of the container height
                const verticalAmplitude = containerHeight / 4;

                const x1 = -quoteWidth;
                const x2 = (containerWidth + quoteWidth) / 2;
                const x3 = containerWidth + quoteWidth;

                // add random offsets
                const y1 = 0 + Math.random() * verticalAmplitude / 4;
                const y2 = verticalAmplitude + Math.random() * verticalAmplitude / 2;
                const y3 = -verticalAmplitude + Math.random() * verticalAmplitude / 2;

                const keyframes = [
                    { transform: `translateX(${x1}px) translateY(${y1}px)` },
                    { offset: .5, transform: `translateX(${x2}px) translateY(${y2}px)` },
                    { offset: 1, transform: `translateX(${x3}px) translateY(${y3}px)` }
                ];

                // Start the animation
                quoteText.animate(
                    keyframes,
                    {
                        duration: duration,
                        easing: 'ease-in-out',
                        fill: 'forwards'
                    }
                );

                // Remove the quote after it has moved across
                setTimeout(() => {
                    quoteElement.removeChild(quoteText);
                }, duration);

                // Schedule the next quote
                setTimeout(swimQuote, 9000); // Adjust timing between quotes as needed
            }

            // Start the swimming quotes
            swimQuote();
        }
    });
});
console.log('Swimming Quotes block loaded');

quotes = [
    {
        "quote": "A leaky hydrant repurposed to create life.",
        "author_info": "Christian L., 32, Bed-Stuy."
    },
    {
        "quote": "I am inspired by the community coming together.",
        "author_info": "Nes S. Bed-Stuy."
    },
    {
        "quote": "I am inspired by the ability of a fire hydrant to bring a community together; I imagine joy, community, togetherness.",
        "author_info": "Betsu, 33, Bed-Stuy."
    },
    {
        "quote": "I imagine more different kinds of fish like puffers.",
        "author_info": "Niko, 8, Bed-Stuy."
    },
    {
        "quote": "I am inspired by the way it happened organically and continues to grow.",
        "author_info": "Matthew R., 29, Bed-Stuy."
    },
    {
        "quote": "I imagine different decorations and color schemes based on the season.",
        "author_info": "Matthew R., 29, Bed-Stuy."
    },
    {
        "quote": "I can imagine a knit winter hat for the top of the Aquarium (like a snowman).",
        "author_info": "Izzy, 25, Clinton Hill."
    },
    {
        "quote": "I am inspired by the community coming together to care for the fish!",
        "author_info": "Courtney J., 31, Flatbush."
    },
    {
        "quote": "I have never seen this kind of artwork before.",
        "author_info": "Tommy, 22, Jersey City."
    },
    {
        "quote": "I am inspired by the creativity of Bed-Stuy Aquarium.",
        "author_info": "Alyssa C., 19, The Bronx, Riverdale."
    },
    {
        "quote": "Fire Hydrants that are not functioning properly or leaking can be repurposed for other projects.",
        "author_info": "Alyssa C., 19, The Bronx, Riverdale."
    },
    {
        "quote": "Bed-Stuy Aquarium is the most wholesome thing ever.",
        "author_info": "Liysa, 37, Crown Heights."
    },
    {
        "quote": "It's so peaceful and sweet and amazing that nobody is bothering with it which gives me hope for the city.",
        "author_info": "Danielle D., 50, Crown Heights."
    },
    {
        "quote": "I am inspired that people are able to find community in the smallest of things like a leak from a fire hydrant.",
        "author_info": "Solana M., 23, Greenwich Vill."
    },
    {
        "quote": "Seeing the fish makes me happy.",
        "author_info": "Nina, 30, Bed-Stuy."
    },
    {
        "quote": "My kids were so excited to see the fish. It inspires me to imagine and dream.",
        "author_info": "Tyler M., 36, Bed-Stuy."
    },
    {
        "quote": "Perspective is important. If the Bed-Stuy Aquarium wasn’t here I wouldn’t imagine this little pit under a tree could be an Aquarium.",
        "author_info": "Carl, 20, Downtown Brooklyn."
    },
    {
        "quote": "I’m inspired by the creativity of using this space to make something unique and beloved by the community.",
        "author_info": "Cristina C., 30, Bed-Stuy."
    },
    {
        "quote": "It is an unexpected moment of calm in the city. It makes me think of Ada Limón’s poem “Miracle Fish.”",
        "author_info": "Nicole A., 26, Flatbush."
    },
    {
        "quote": "You can make something beautiful out of nothing.",
        "author_info": "Pamela G., 26, The Bronx."
    },
    {
        "quote": "The WHOLE idea is adorable.",
        "author_info": "Eae L., 48, Orlando, FL."
    },
    {
        "quote": "Motivational ass fish.",
        "author_info": "Reem H., 24, Canarsie, baby!"
    },
    {
        "quote": "The beauty of NYC.",
        "author_info": "Chad S., 50, Clinton Hill."
    },
    {
        "quote": "I can imagine more fire hydrants for beautiful installations like this.",
        "author_info": "Chad S., 50, Clinton Hill."
    },
    {
        "quote": "Quiet beauty.",
        "author_info": "Matt S., 55, Clinton Hill."
    },
    {
        "quote": "One of a kind.",
        "author_info": "Amanda, 23, Westchester."
    },
    {
        "quote": "Fishies <3.",
        "author_info": "Aly, 17, Clinton Hill."
    },
    {
        "quote": "I love that a community created such an awesome thing out of something many would see as a problem.",
        "author_info": "Bridget M., 50, Snellville, GA (suburb of Atlanta)."
    },
    {
        "quote": "Rediscovered my inner child. Laughed a lot.",
        "author_info": "Carl A., 65, Bed-Stuy."
    },
    {
        "quote": "Fire hydrants were big in the 1960s. They’ve made an unexpected comeback in the public view.",
        "author_info": "Carl A., 65, Bed-Stuy."
    },
    {
        "quote": "I can imagine hydrant decorating contests.",
        "author_info": "Christopher R., 33, Greenpoint."
    },
    {
        "quote": "I am inspired by the way that a little thing can bring so much joy and build community!",
        "author_info": "Ben R., 27, Hell’s Kitchen."
    },
    {
        "quote": "I am inspired by all the fish in there and all of the things inside. I can imagine FISH IN ALL OF THE FIRE HYDRANTS!!!",
        "author_info": "Elián, 8, Bed-Stuy."
    },
    {
        "quote": "I am inspired by the creativity in Bed-Stuy Aquarium. I’ve never seen anything like it!!",
        "author_info": "Lu, V.T., 12, Bed-Stuy."
    },
    {
        "quote": "More street art like this. I’ve noticed that everyone who walks by seems to walk a little taller after.",
        "author_info": "Lu, V.T., 12, Bed-Stuy."
    },
    {
        "quote": "So happy that these fish have a beautiful home and they look happy.",
        "author_info": "Jasmine T., 21, Kips Bay."
    },
    {
        "quote": "It’s a wonderful place for the community to come together and create something beautiful.",
        "author_info": "Emily S., 29, Upper East Side."
    },
    {
        "quote": "Whether or not it’s a fire hydrant, this is a great opportunity to turn the little bits of green space on public streets into something special.",
        "author_info": "Emily S., 29, Upper East Side."
    },
    {
        "quote": "Community connection, a place of peace and reflection, for kids to experience wonder.",
        "author_info": "Hope L., 34, Ridgewood."
    }
]
