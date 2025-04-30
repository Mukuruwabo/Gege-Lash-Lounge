document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const payNowBtn = document.getElementById('payNowBtn');
    const paymentModal = document.getElementById('paymentModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
    
    // Available times (could be fetched from server in real app)
    const availableTimes = [
        '09:00', '10:00', '11:00', '12:00', 
        '13:00', '14:00', '15:00', '16:00'
    ];
    
    // Populate time slots when date is selected
    dateInput.addEventListener('change', function() {
        timeSelect.innerHTML = '<option value="">Select a time</option>';
        
        if (this.value) {
            availableTimes.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });
        }
    });
    
    // Handle pay now button
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
    
    // Handle payment confirmation
    confirmPaymentBtn.addEventListener('click', function() {
        // In a real app, you would verify payment with MTN/Airtel API here
        // For this demo, we'll just submit the form
        
        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        this.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            bookingForm.submit();
        }, 1500);
    });
});