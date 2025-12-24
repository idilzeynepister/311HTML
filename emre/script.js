// Basic script for student project level interactivity
document.addEventListener('DOMContentLoaded', function() {
    console.log('n11 clone loaded');

    // Simple interaction: Alert on 'Add to Cart' or clicking items (simulation)
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        card.addEventListener('click', function() {
            console.log('Product clicked');
        });
    });
});
