// Add any interactive JavaScript functionality here
// Example: Rating stars interaction
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        star.addEventListener('click', function () {
            alert(`You rated this movie ${this.dataset.rating} stars!`);
        });
    });
});