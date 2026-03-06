// assets/js/animations.js

document.addEventListener('DOMContentLoaded', () => {

    // 1. Initialize Lenis for buttery smooth scrolling
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // cinematic custom easing
        direction: 'vertical',
        gestureDirection: 'vertical',
        smooth: true,
        mouseMultiplier: 1,
        smoothTouch: false,
        touchMultiplier: 2,
        infinite: false,
    });

    // Sync Lenis with GSAP ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000)
    });

    gsap.ticker.lagSmoothing(0)

    // Cinematic Easing standard from guidelines
    const cinematicEase = "power3.out"; // Maps closely to cubic-bezier(0.23, 1, 0.32, 1)

    // 2. Navbar Mutating Logic
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                // Scrolled state
                navbar.classList.add('bg-deep-surface/80', 'py-2');
                navbar.classList.remove('bg-deep-surface/40', 'py-4');
            } else {
                // Top state
                navbar.classList.add('bg-deep-surface/40', 'py-4');
                navbar.classList.remove('bg-deep-surface/80', 'py-2');
            }
        });
    }

    // 3. Global Reveal Animations (staggered fade-up)
    const revealElements = document.querySelectorAll('.gsap-reveal');

    revealElements.forEach((el) => {
        gsap.fromTo(el,
            {
                y: 50,
                opacity: 0,
            },
            {
                scrollTrigger: {
                    trigger: el,
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                },
                y: 0,
                opacity: 1,
                duration: 1.2,
                ease: cinematicEase,
                stagger: 0.15
            }
        );
    });

    // 4. Parallax Image Effects
    const parallaxImages = document.querySelectorAll('.gsap-parallax');
    parallaxImages.forEach(img => {
        gsap.to(img, {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: img.parentElement,
                start: "top bottom",
                end: "bottom top",
                scrub: true
            }
        });
    });

    // 5. Sticking/Pinning Sections (like 'Protocol')
    const stickySection = document.querySelector('.gsap-sticky-container');
    if (stickySection) {
        const cards = gsap.utils.toArray('.gsap-sticky-card');

        cards.forEach((card, index) => {
            if (index === cards.length - 1) return; // Don't animate the last one out

            gsap.to(card, {
                scale: 0.9,
                opacity: 0.5,
                filter: 'blur(5px)',
                scrollTrigger: {
                    trigger: card,
                    start: "top 10%",
                    end: "bottom top",
                    scrub: true,
                    pin: true,
                    pinSpacing: false
                }
            });
        });
    }

    // 6. Final Reveal (WhatsApp)
    gsap.to("#whatsapp-btn", {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: "power3.out",
        delay: 1.5
    });
});
