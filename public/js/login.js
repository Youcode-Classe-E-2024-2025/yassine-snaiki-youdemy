document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const errors = {};
        const emailErrorDiv = document.getElementById('email-error');
        const passwordErrorDiv = document.getElementById('password-error');

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
            errors.email = 'Invalid email format.';
        }
        if (password.length < 4) {
            errors.password = 'Password must be greater than 4 characters.';
        }
        if (Object.keys(errors).length > 0) {
            emailErrorDiv.textContent = errors.email || '';
            passwordErrorDiv.textContent = errors.password || '';
        }
        if (Object.keys(errors).length === 0) {
            e.target.submit();
        }
    });
});