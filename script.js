



const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
  navbarLinks.classList.toggle('active')


  setTimeout(() => {
    navbarLinks.style.display = navbarLinks.classList.contains('active') ? 'flex' : 'none';
}, 300); 
});
document.addEventListener('DOMContentLoaded', function() {
    const experienceSpan = document.getElementById('experience');
    const startCount = 0;
    const endCount = 9;
    const duration = 2000; // Duration in milliseconds
    const incrementTime = Math.abs(Math.floor(duration / (endCount - startCount)));

    function animateCountUp() {
        let currentCount = startCount;
        const interval = setInterval(() => {
            currentCount += 1;
            experienceSpan.textContent = currentCount;
            if (currentCount === endCount) {
                clearInterval(interval);
            }
        }, incrementTime);
    }

    // Check if the element is in view
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }


    function handleScroll() {
        if (isInViewport(experienceSpan)) {
            animateCountUp();
            window.removeEventListener('scroll', handleScroll);
        }
    }

    window.addEventListener('scroll', handleScroll);
});