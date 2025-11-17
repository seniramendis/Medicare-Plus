/*
======================================================
=== MEDICARE PLUS - HOME PAGE SCRIPT ===
======================================================
* This script handles all interactivity for the home page.
* 1. Main Slideshow
* 2. Service Carousel
* 3. "About Us" Modal (Fixed: Will NOT show on page load)
*/

// --- GLOBAL VARIABLES ---

// For Main Slideshow
let slideIndex = 1; // Start at the first slide
let autoSlideTimer; // This variable will hold our automatic timer

// For Service Carousel
let serviceSlideIndex = 1;

// For Modal
var modal;
var modalTitle;
var modalContent;
var modalLearnMoreLink;
var modalCloseBtn;

// --- INITIALIZATION ---
// Wait for the HTML document to be fully loaded before running any JS
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. Initialize Main Slideshow ---
    if (document.getElementsByClassName("mySlides").length > 0) {
        showSlides(slideIndex);
    }

    // --- 2. Initialize Service Carousel ---
    if (document.getElementsByClassName("service-slide").length > 0) {
        showServiceSlides(serviceSlideIndex);
    }

    // --- 3. Initialize Modal Elements ---
    modal = document.getElementById("infoModal");

    if (modal) { // Only proceed if modal element is found
        modalTitle = document.getElementById("modalTitle");
        modalContent = document.getElementById("modalContent");
        modalLearnMoreLink = document.getElementById("modalLearnMoreLink");
        // Get the close buttons
        modalCloseBtn = document.getElementById("modalCloseBtn");
        
        // Add listeners
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                closeModal();
            }
        });

        if (modalCloseBtn) {
            modalCloseBtn.addEventListener('click', closeModal);
        }
        
        // CRITICAL FIX: Ensure the modal is hidden right away.
        // This is a safety check in case CSS hasn't loaded or was overwritten.
        modal.style.display = "none";
    }

}); // --- END OF 'DOMContentLoaded' LISTENER ---


/*
======================================================
=== 1. MAIN SLIDESHOW FUNCTIONS ===
======================================================
*/
// --- MANUAL CONTROLS (Called by HTML onclick) ---

function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Dot/thumbnail controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

// --- AUTOMATIC TIMER FUNCTIONS ---

function autoAdvance() {
    slideIndex++;
    showSlides(slideIndex);
}

function startAutoPlay() {
    if (autoSlideTimer) {
        clearTimeout(autoSlideTimer);
    }
    autoSlideTimer = setTimeout(autoAdvance, 3000);
}

// --- THE MAIN SLIDESHOW LOGIC ---
function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (!slides || !dots || slides.length === 0 || dots.length === 0) {
        return;
    }

    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }

    for (i = 0; i < slides.length; i++) {
        if (slides[i]) slides[i].style.display = "none";
    }

    for (i = 0; i < dots.length; i++) {
        if (dots[i]) dots[i].className = dots[i].className.replace(" active", "");
    }

    if (slides[slideIndex - 1]) slides[slideIndex - 1].style.display = "block";
    if (dots[slideIndex - 1]) dots[slideIndex - 1].className += " active";
    startAutoPlay();
}

/*
======================================================
=== 2. SERVICE CAROUSEL FUNCTIONS ===
======================================================
*/

function plusServiceSlides(n) {
    showServiceSlides(serviceSlideIndex += n);
}

function currentServiceSlide(n) {
    showServiceSlides(serviceSlideIndex = n);
}

function showServiceSlides(n) {
    let i;
    let slides = document.getElementsByClassName("service-slide");
    let dots = document.getElementsByClassName("service-dot");

    if (!slides || !dots || slides.length === 0 || dots.length === 0) {
        return;
    }

    if (n > slides.length) {
        serviceSlideIndex = 1;
    }
    if (n < 1) {
        serviceSlideIndex = slides.length;
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" service-active", "");
    
}

    slides[serviceSlideIndex - 1].style.display = "block";
    dots[serviceSlideIndex - 1].className += " service-active";
}


/*
======================================================
=== 3. MODAL FUNCTIONS (FIXED) ===
======================================================
*/

function openModal(title, content, linkUrl) {
    if (modal && modalTitle && modalContent && modalLearnMoreLink) {
        modalTitle.innerText = title;
        modalContent.innerHTML = content;
        modalLearnMoreLink.href = linkUrl;
        modal.style.display = "flex"; 
    }
}

function closeModal() {
    if (modal) {
        modal.style.display = "none";
    }
}