// --- GLOBAL VARIABLES ---
let slideIndex = 1; // Start at the first slide
let autoSlideTimer; // This variable will hold our automatic timer

// --- INITIALIZE THE SLIDESHOW ---
// Wait for the HTML document to be fully loaded before starting
document.addEventListener('DOMContentLoaded', function() {
    // This code will now wait to run until the page is ready
    showSlides(slideIndex);
});

// --- MANUAL CONTROLS (Called by your HTML) ---

// Next/previous buttons
function plusSlides(n) {
    // Pass the new slide number to showSlides
    showSlides(slideIndex += n);
}

// Dot/thumbnail controls
function currentSlide(n) {
    // Pass the specific slide number to showSlides
    showSlides(slideIndex = n);
}

// --- AUTOMATIC TIMER FUNCTIONS ---

// This function is called by the timer
function autoAdvance() {
    slideIndex++; // Increment the slide index
    showSlides(slideIndex); // Show the next slide
}

// This function starts (or restarts) the timer
function startAutoPlay() {
    // Clear any existing timer to prevent bugs
    // === THIS LINE IS NOW FIXED ===
    clearTimeout(autoSlideTimer);  
    
    // Set a new timer that calls autoAdvance after 3 seconds (3000ms)
    // You can change 3000 to 2000 if you want 2 seconds.
    autoSlideTimer = setTimeout(autoAdvance, 3000);
}

// --- THE MAIN FUNCTION (Does all the work) ---

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // This check prevents errors if the elements haven't loaded
    // (though 'DOMContentLoaded' should already handle this)
    if (slides.length === 0 || dots.length === 0) {
        return; 
    }

    // 1. Handle wrap-around
    // If 'n' is greater than the number of slides, go to slide 1
    if (n > slides.length) {
        slideIndex = 1;
    }
    // If 'n' is less than 1 (e.g., clicking 'prev' on slide 1), go to the last slide
    if (n < 1) {
        slideIndex = slides.length;
    }

    // 2. Hide all slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // 3. Deactivate all dots
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // 4. Show the correct slide and activate its dot
    // (slideIndex is 1-based, array is 0-based)
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";

    // 5. IMPORTANT: Reset the automatic timer
    // Every time a slide is shown (manually or automatically),
    // we restart the 3-second timer.
    startAutoPlay();
}