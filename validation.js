function showError(input, msg) {
    let err = input.parentElement.querySelector('.err-msg');
    if (!err) {
        err = document.createElement('span');
        err.className = 'err-msg';
        err.style.cssText = 'color:red;font-size:12px;display:block;margin-top:2px;';
        input.parentElement.appendChild(err);
    }
    err.textContent = msg;
    input.style.border = '1px solid red';
}

function clearError(input) {
    const err = input.parentElement.querySelector('.err-msg');
    if (err) err.textContent = '';
    input.style.border = '';
}

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validatePhone(phone) {
    return /^[6-9]\d{9}$/.test(phone.trim());
}

function validatePincode(pin) {
    return /^\d{6}$/.test(pin.trim());
}

// ---- LOGIN ----
const loginForm = document.querySelector('form.login-form[action*="ulogin"]');
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        let valid = true;
        const email = this.querySelector('[name="email"]');
        const pass = this.querySelector('[name="password"]');

        if (!validateEmail(email.value)) { showError(email, 'Valid email required'); valid = false; } else clearError(email);
        if (pass.value.length < 6) { showError(pass, 'Password must be at least 6 characters'); valid = false; } else clearError(pass);

        if (!valid) e.preventDefault();
    });
}

// ---- REGISTER ----
const registerForm = document.querySelector('form.login-form[action*="usignup"]');
if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
        let valid = true;
        const username = this.querySelector('[name="username"]');
        const email = this.querySelector('[name="email"]');
        const pass = this.querySelector('[name="password"]');

        if (username.value.trim().length < 3) { showError(username, 'Username must be at least 3 characters'); valid = false; } else clearError(username);
        if (!validateEmail(email.value)) { showError(email, 'Valid email required'); valid = false; } else clearError(email);
        if (pass.value.length < 6) { showError(pass, 'Password must be at least 6 characters'); valid = false; } else clearError(pass);
        if (!/[A-Z]/.test(pass.value)) { showError(pass, 'Password must contain at least one uppercase letter'); valid = false; }

        if (!valid) e.preventDefault();
    });
}

// ---- CONTACT ----
const contactForm = document.querySelector('form[action*="contact.php"]');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        let valid = true;
        const name = this.querySelector('[name="name"]');
        const email = this.querySelector('[name="email"]');
        const subject = this.querySelector('[name="subject"]');
        const message = this.querySelector('[name="message"]');

        if (name.value.trim().length < 2) { showError(name, 'Name must be at least 2 characters'); valid = false; } else clearError(name);
        if (!validateEmail(email.value)) { showError(email, 'Valid email required'); valid = false; } else clearError(email);
        if (subject.value.trim().length < 3) { showError(subject, 'Subject is too short'); valid = false; } else clearError(subject);
        if (message.value.trim().length < 10) { showError(message, 'Message must be at least 10 characters'); valid = false; } else clearError(message);

        if (!valid) e.preventDefault();
    });
}

// ---- BOOKING FORM ----
const bookingForm = document.querySelector('form[action*="booking.php"]');
if (bookingForm) {
    bookingForm.addEventListener('submit', function (e) {
        let valid = true;
        const phone = this.querySelector('[name="phone"]');
        const pincode = this.querySelector('[name="pincode"]');
        const checkIn = this.querySelector('[name="check_in"]');
        const checkOut = this.querySelector('[name="check_out"]');
        const persons = this.querySelector('[name="persons"]');
        const location = this.querySelector('[name="tour_location"]');

        if (!validatePhone(phone.value)) { showError(phone, 'Enter valid 10-digit phone number'); valid = false; } else clearError(phone);
        if (!validatePincode(pincode.value)) { showError(pincode, 'Enter valid 6-digit pincode'); valid = false; } else clearError(pincode);

        if (checkIn.value && checkOut.value) {
            if (new Date(checkOut.value) <= new Date(checkIn.value)) { showError(checkOut, 'Check-out must be after check-in'); valid = false; } else clearError(checkOut);
            if (new Date(checkIn.value) < new Date().setHours(0,0,0,0)) { showError(checkIn, 'Check-in cannot be in the past'); valid = false; } else clearError(checkIn);
        }

        if (parseInt(persons.value) < 1) { showError(persons, 'At least 1 person required'); valid = false; } else clearError(persons);
        if (location.value === 'select the place') { showError(location, 'Please select a destination'); valid = false; } else clearError(location);

        if (!valid) e.preventDefault();
    });
}

// ---- FLIGHT FORM ----
const flightForm = document.querySelector('form[action*="flight.php"]');
if (flightForm) {
    flightForm.addEventListener('submit', function (e) {
        let valid = true;
        const phone = this.querySelector('[name="phone"]');
        const pincode = this.querySelector('[name="pincode"]');
        const pincode1 = this.querySelector('[name="pincode1"]');
        const checkIn = this.querySelector('[name="check_in"]');

        if (!validatePhone(phone.value)) { showError(phone, 'Enter valid 10-digit phone number'); valid = false; } else clearError(phone);
        if (!validatePincode(pincode.value)) { showError(pincode, 'Enter valid 6-digit pincode'); valid = false; } else clearError(pincode);
        if (!validatePincode(pincode1.value)) { showError(pincode1, 'Enter valid 6-digit pincode'); valid = false; } else clearError(pincode1);
        if (checkIn.value && new Date(checkIn.value) < new Date().setHours(0,0,0,0)) { showError(checkIn, 'Pickup date cannot be in the past'); valid = false; } else clearError(checkIn);

        if (!valid) e.preventDefault();
    });
}

// ---- TAXI FORM ----
const taxiForm = document.querySelector('form[action*="taxi"]');
if (taxiForm) {
    taxiForm.addEventListener('submit', function (e) {
        let valid = true;
        const phone = this.querySelector('[name="phone"]');
        const pincode = this.querySelector('[name="pincode"]');
        const checkIn = this.querySelector('[name="check_in"]');
        const checkOut = this.querySelector('[name="check_out"]');

        if (!validatePhone(phone.value)) { showError(phone, 'Enter valid 10-digit phone number'); valid = false; } else clearError(phone);
        if (!validatePincode(pincode.value)) { showError(pincode, 'Enter valid 6-digit pincode'); valid = false; } else clearError(pincode);

        if (checkIn.value && checkOut.value) {
            if (new Date(checkOut.value) <= new Date(checkIn.value)) { showError(checkOut, 'Dropout date must be after pickup date'); valid = false; } else clearError(checkOut);
            if (new Date(checkIn.value) < new Date().setHours(0,0,0,0)) { showError(checkIn, 'Pickup date cannot be in the past'); valid = false; } else clearError(checkIn);
        }

        if (!valid) e.preventDefault();
    });
}

// ---- CREDIT CARD FORM ----
const creditForm = document.querySelector('#credit-form');
if (creditForm) {
    creditForm.addEventListener('submit', function (e) {
        let valid = true;
        const cardNumber = this.querySelector('[name="card_number"]');
        const expiry = this.querySelector('[name="expiry_date"]');
        const name = this.querySelector('[name="cardholder_name"]');
        const cvv = this.querySelector('[name="cvv"]');
        const otp = this.querySelector('[name="otp_pin"]');
        const amount = this.querySelector('[name="amount"]');

        if (!/^\d{16}$/.test(cardNumber.value.trim())) { showError(cardNumber, 'Enter valid 16-digit card number'); valid = false; } else clearError(cardNumber);

        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry.value.trim())) {
            showError(expiry, 'Enter valid expiry date (MM/YY)'); valid = false;
        } else {
            const [mm, yy] = expiry.value.split('/');
            const exp = new Date(2000 + parseInt(yy), parseInt(mm) - 1, 1);
            if (exp < new Date()) { showError(expiry, 'Card is expired'); valid = false; } else clearError(expiry);
        }

        if (name.value.trim().length < 3) { showError(name, 'Enter valid cardholder name'); valid = false; } else clearError(name);
        if (!/^\d{3,4}$/.test(cvv.value.trim())) { showError(cvv, 'Enter valid 3 or 4-digit CVV'); valid = false; } else clearError(cvv);
        if (!/^\d{6}$/.test(otp.value.trim())) { showError(otp, 'Enter valid 6-digit OTP/PIN'); valid = false; } else clearError(otp);
        if (!/^\d+(\.\d{1,2})?$/.test(amount.value.trim()) || parseFloat(amount.value) <= 0) { showError(amount, 'Enter valid amount'); valid = false; } else clearError(amount);

        if (!valid) e.preventDefault();
    });
}

// ---- DEBIT CARD FORM ----
const debitForm = document.querySelector('#debit-form');
if (debitForm) {
    debitForm.addEventListener('submit', function (e) {
        let valid = true;
        const cardNumber = this.querySelector('[name="card_number"]');
        const expiry = this.querySelector('[name="expiry_date"]');
        const name = this.querySelector('[name="cardholder_name"]');
        const cvv = this.querySelector('[name="cvv"]');
        const otp = this.querySelector('[name="otp_pin"]');
        const amount = this.querySelector('[name="amount"]');

        if (!/^\d{16}$/.test(cardNumber.value.trim())) { showError(cardNumber, 'Enter valid 16-digit card number'); valid = false; } else clearError(cardNumber);

        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry.value.trim())) {
            showError(expiry, 'Enter valid expiry date (MM/YY)'); valid = false;
        } else {
            const [mm, yy] = expiry.value.split('/');
            const exp = new Date(2000 + parseInt(yy), parseInt(mm) - 1, 1);
            if (exp < new Date()) { showError(expiry, 'Card is expired'); valid = false; } else clearError(expiry);
        }

        if (name.value.trim().length < 3) { showError(name, 'Enter valid cardholder name'); valid = false; } else clearError(name);
        if (!/^\d{3,4}$/.test(cvv.value.trim())) { showError(cvv, 'Enter valid 3 or 4-digit CVV'); valid = false; } else clearError(cvv);
        if (!/^\d{6}$/.test(otp.value.trim())) { showError(otp, 'Enter valid 6-digit OTP/PIN'); valid = false; } else clearError(otp);
        if (!/^\d+(\.\d{1,2})?$/.test(amount.value.trim()) || parseFloat(amount.value) <= 0) { showError(amount, 'Enter valid amount'); valid = false; } else clearError(amount);

        if (!valid) e.preventDefault();
    });
}

// ---- UPI FORM ----
const upiForm = document.querySelector('#upi-form');
if (upiForm) {
    upiForm.addEventListener('submit', function (e) {
        let valid = true;
        const name = this.querySelector('[name="name"]');

        if (name.value.trim().length < 2) { showError(name, 'Enter your full name'); valid = false; } else clearError(name);

        if (!valid) e.preventDefault();
    });
}
