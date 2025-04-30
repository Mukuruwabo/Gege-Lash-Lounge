// main.js
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu');
    const nav = document.querySelector('.nav');
    const navLinks = document.querySelectorAll('.nav ul li a');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
            this.classList.toggle('open');
        });
    }
    
    // Close mobile menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768 && nav) {
                nav.classList.remove('active');
                mobileMenuBtn.classList.remove('open');
            }
        });
    });
    
    // Header scroll effect
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }
    
    // Responsive adjustments
    function handleResize() {
        if (window.innerWidth > 768 && nav) {
            nav.classList.remove('active');
            if (mobileMenuBtn) {
                mobileMenuBtn.classList.remove('open');
            }
        }
    }
    
    window.addEventListener('resize', handleResize);
    handleResize();
    
    // Initialize animations when elements come into view
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.fade-in, .slide-up, .slide-left, .slide-right');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.style.visibility = 'visible';
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on page load
});

// booking.js
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const payNowBtn = document.getElementById('payNowBtn');
    const bookingModal = document.getElementById('bookingModal');
    const paymentModal = document.getElementById('paymentModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const bookNowBtns = document.querySelectorAll('.book-now-btn');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    
    // Set minimum date to today
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
        
        // Available times (could be fetched from server in real app)
        const availableTimes = [
            '09:00', '10:00', '11:00', '12:00', 
            '13:00', '14:00', '15:00', '16:00'
        ];
        
        // Populate time slots when date is selected
        dateInput.addEventListener('change', function() {
            if (timeSelect) {
                timeSelect.innerHTML = '<option value="">Select a time</option>';
                
                if (this.value) {
                    availableTimes.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeSelect.appendChild(option);
                    });
                }
            }
        });
    }
    
    // Book Now button functionality
    if (bookNowBtns.length && bookingModal && bookingForm) {
        bookNowBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Reset form
                bookingForm.reset();
                
                // Show modal
                bookingModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                
                // If clicked on a service card, preselect that service
                if (this.dataset.service) {
                    document.getElementById('service').value = this.dataset.service;
                }
            });
        });
    }
    
    // Close modal functionality
    if (closeModalBtns.length) {
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                if (bookingModal) bookingModal.style.display = 'none';
                if (paymentModal) paymentModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === bookingModal) {
            bookingModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (e.target === paymentModal) {
            paymentModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Handle pay now button
    if (payNowBtn && bookingForm && paymentModal) {
        payNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validate form
            const requiredFields = ['username', 'email', 'phone', 'service', 'date', 'time'];
            let isValid = true;
            
            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value) {
                    element.style.borderColor = 'red';
                    isValid = false;
                } else {
                    element.style.borderColor = '#ddd';
                }
            });
            
            if (isValid) {
                bookingModal.style.display = 'none';
                paymentModal.style.display = 'block';
            }
        });
    }
    
    // Handle payment confirmation
    if (confirmPaymentBtn && bookingForm) {
        confirmPaymentBtn.addEventListener('click', function() {
            // In a real app, you would verify payment with MTN/Airtel API here
            // For this demo, we'll just submit the form
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Submit the form
                bookingForm.submit();
                
                // Reset button in case form submission fails
                this.innerHTML = originalText;
                this.disabled = false;
            }, 1500);
        });
    }
});
