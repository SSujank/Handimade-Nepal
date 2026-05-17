/* ============================================
   Handicraft Online Store — Contact Form Validation
   Client-side checks support the store contact form.
   If validation passes, the form submits normally to contact.php.
   ============================================ */

(function () {
    'use strict';

    const form = document.getElementById('contact-form');
    if (!form) return;

    const feedback = document.getElementById('form-feedback');

    function showFeedback(type, message) {
        if (!feedback) return;
        feedback.className = 'form-feedback ' + type;
        feedback.textContent = message;
    }

    function clearFeedback() {
        if (!feedback) return;
        feedback.className = 'form-feedback';
        feedback.textContent = '';
    }

    function setError(field, message) {
        const wrapper = field.closest('.form-field') || field.closest('.checkbox-field');
        if (!wrapper) return;
        wrapper.classList.add('has-error');
        field.setAttribute('aria-invalid', 'true');
        let errorMsg = wrapper.querySelector('.error-msg');
        if (!errorMsg && wrapper.classList.contains('form-field')) {
            errorMsg = document.createElement('div');
            errorMsg.className = 'error-msg';
            errorMsg.setAttribute('role', 'alert');
            wrapper.appendChild(errorMsg);
        }
        if (errorMsg) errorMsg.textContent = message;
    }

    function clearError(field) {
        const wrapper = field.closest('.form-field') || field.closest('.checkbox-field');
        if (!wrapper) return;
        wrapper.classList.remove('has-error');
        field.setAttribute('aria-invalid', 'false');
        const errorMsg = wrapper.querySelector('.error-msg');
        if (errorMsg) errorMsg.textContent = '';
    }

    function validateField(field) {
        const value = field.value ? field.value.trim() : '';
        let valid = true;
        let message = '';

        if (field.type === 'checkbox') {
            if (field.hasAttribute('required') && !field.checked) {
                valid = false;
                message = 'This agreement is required.';
            }
        } else if (field.hasAttribute('required') && value === '') {
            valid = false;
            message = 'This field is required.';
        } else if (field.type === 'email' && value !== '') {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                valid = false;
                message = 'Please enter a valid email address.';
            }
        } else if (field.type === 'tel' && value !== '') {
            const digitCount = (value.match(/\d/g) || []).length;
            if (digitCount < 8) {
                valid = false;
                message = 'Please enter a valid phone number with at least 8 digits.';
            }
        } else if (field.hasAttribute('minlength') && value !== '') {
            const min = parseInt(field.getAttribute('minlength'), 10);
            if (value.length < min) {
                valid = false;
                message = 'Please enter at least ' + min + ' characters.';
            }
        }

        if (valid) {
            clearError(field);
        } else {
            setError(field, message);
        }
        return valid;
    }

    form.querySelectorAll('input, textarea, select').forEach(function (field) {
        field.addEventListener('blur', function () {
            validateField(field);
        });
        field.addEventListener('input', function () {
            clearFeedback();
            if (field.closest('.has-error')) validateField(field);
        });
        field.addEventListener('change', function () {
            clearFeedback();
            if (field.closest('.has-error')) validateField(field);
        });
    });

    form.addEventListener('submit', function (event) {
        clearFeedback();
        let formIsValid = true;

        form.querySelectorAll('input, textarea, select').forEach(function (field) {
            if (!validateField(field)) formIsValid = false;
        });

        if (!formIsValid) {
            event.preventDefault();
            showFeedback('error', 'Please review the highlighted fields and try again.');
            const firstInvalid = form.querySelector('[aria-invalid="true"]');
            if (firstInvalid) firstInvalid.focus();
        }
        // When valid, do not prevent default; the message will be saved for store follow-up.
    });
})();
