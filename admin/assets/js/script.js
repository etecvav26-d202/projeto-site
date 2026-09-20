const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');
    });

    const navLinks =
        mainNav.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            mainNav.classList.remove('active');
        });
    });
}

const revealElements =
    document.querySelectorAll('.reveal');

if (revealElements.length > 0) {
    const observer =
        new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay =
                            `${Math.random() * 0.2}s`;
                        entry.target.style.opacity = '1';
                        observer.unobserve(
                            entry.target
                        );
                    }
                });
            },
            {
                threshold: 0.12
            }
        );

    revealElements.forEach(element => {
        observer.observe(element);
    });

}