// --- GLOBAL VARIABLES ---
let slideIndex = 1; // Start at the first slide
let autoSlideTimer; // This variable will hold our automatic timer

// === MODIFIED ===
// We DECLARE the modal variables here, but we don't assign them yet.
var modal;
var modalTitle;
var modalContent;

// === NEW ===
// Global variable for the SECOND slideshow (services)
let serviceSlideIndex = 1;

// INITIALIZE THE SLIDESHOW AND MODAL
// Wait for the HTML document to be fully loaded before starting
document.addEventListener('DOMContentLoaded', function() {
    
    // This code will now wait to run until the page is ready
    showSlides(slideIndex);

    // === NEW ===
    // Initialize the NEW service slideshow
    // We must check if the elements exist before trying to show them
    if (document.getElementsByClassName("service-slide").length > 0) {
        showServiceSlides(serviceSlideIndex);
    }

    // === NEW ===
    // Now that the page is loaded, we can safely find and assign
    // our modal elements to the variables.
    modal = document.getElementById("infoModal");
    modalTitle = document.getElementById("modalTitle");
    modalContent = document.getElementById("modalContent"); // This is the <div> wrapper

    
    // =======================================================
    // === UPGRADED CONTACT FORM ALERT ===
    // =======================================================
    
    // Find the form
    var contactForm = document.getElementById("contactForm");
    
    // Find our new modal and its close button
    var feedbackModal = document.getElementById("feedbackModal"); // Renamed to avoid conflict
    var closeBtn = document.querySelector(".custom-alert-close");

    // Check if the form exists on this page
    if (contactForm && feedbackModal && closeBtn) {
        
        // Listen for the form to be submitted
        contactForm.addEventListener("submit", function(event) {
            
            // 1. Prevent the page from reloading
            event.preventDefault();
            
            // 2. Show our new custom modal
            feedbackModal.style.display = "block";
            
            // 3. Clear all the form fields
            contactForm.reset();
        });

        // When the user clicks on (x), close the modal
        closeBtn.onclick = function() {
            feedbackModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.addEventListener("click", function(event) { // Changed to window.addEventListener
            if (event.target == feedbackModal) {
                feedbackModal.style.display = "none";
            }
        });
    }
    // =======================================================
    // === END OF UPGRADED CODE ===
    // =======================================================

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
    clearTimeout(autoSlideTimer);  
    
    // Set a new timer that calls autoAdvance after 3 seconds (3000ms)
    autoSlideTimer = setTimeout(autoAdvance, 3000);
}

// --- THE MAIN SLIDESHOW FUNCTION ---

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // This check prevents errors if the elements haven't loaded
    if (slides.length === 0 || dots.length === 0) {
        return; 
    }

    // 1. Handle wrap-around
    if (n > slides.length) {
        slideIndex = 1;
    }
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
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";

    // 5. Reset the automatic timer
    startAutoPlay();
}


// === MODAL FUNCTIONS (UPDATED) ===

// Function to OPEN the modal with specific content AND a link
function openModal(title, content, linkUrl) {
    // Find the <a> tag for the "Learn More" button using its ID
    var learnMoreLink = document.getElementById("modalLearnMoreLink");

    // Add a check to make sure the modal AND the link button were found
    if (modal && modalTitle && modalContent && learnMoreLink) {
        modalTitle.innerText = title;
        
        // Use .innerHTML to make the browser read the HTML tags
        modalContent.innerHTML = content; 
        
        // --- THIS IS THE NEW PART ---
        // Set the 'href' attribute of the <a> tag dynamically
        learnMoreLink.href = linkUrl;
        // --- END OF NEW PART ---
        
        modal.style.display = "block";
    } else {
        // This will show an error in the console if any element is missing
        console.error("Error: Modal or Learn More link element not found!");
    }
}

// Function to CLOSE the modal
function closeModal() {
    if (modal) {
        modal.style.display = "none";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.addEventListener("click", function(event) { // Changed to window.addEventListener
    if (event.target == modal) {
        modal.style.display = "none";
    }
});


// ==========================================
// === NEW SERVICE SLIDESHOW JAVASCRIPT ===
// ==========================================

// --- MANUAL CONTROLS for Service Slideshow ---

function plusServiceSlides(n) {
    showServiceSlides(serviceSlideIndex += n);
}

// Dot controls
function currentServiceSlide(n) {
    showServiceSlides(serviceSlideIndex = n);
}

// --- THE MAIN SERVICE SLIDESHOW FUNCTION ---
// This is separate from the main showSlides()
function showServiceSlides(n) {
    let i;
    let slides = document.getElementsByClassName("service-slide");
    let dots = document.getElementsByClassName("service-dot");

    // This check prevents errors if the elements haven't loaded
    if (slides.length === 0 || dots.length === 0) {
        return; 
    }

    // 1. Handle wrap-around
    if (n > slides.length) {
        serviceSlideIndex = 1;
    }
    if (n < 1) {
        serviceSlideIndex = slides.length;
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
    slides[serviceSlideIndex - 1].style.display = "block";
    dots[serviceSlideIndex - 1].className += " active";
}