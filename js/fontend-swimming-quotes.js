document.addEventListener('DOMContentLoaded', function () {
    const swimmingQuotes = document.querySelectorAll('.swimming-quote-block');

    swimmingQuotes.forEach((quote) => {
        // Add any desired JavaScript behavior here
        quote.style.transition = 'transform 0.5s ease';

        quote.addEventListener('mouseover', function () {
            this.style.transform = 'scale(1.05)';
        });

        quote.addEventListener('mouseout', function () {
            this.style.transform = 'scale(1)';
        });
    });
});
