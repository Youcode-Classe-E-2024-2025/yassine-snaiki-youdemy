document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const errors = {};
        const usernameErrorDiv = document.getElementById('username-error');
        const roleErrorDiv = document.getElementById('role-error');
        const emailErrorDiv = document.getElementById('email-error');
        const passwordErrorDiv = document.getElementById('password-error');
        const confirmErrorDiv = document.getElementById('confirm-error');

        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            errors.email = 'Invalid email format.';
        }
        if (username.length < 4) {
            errors.username = 'Username must be greater than 4 characters.';
        }
        if (password.length < 4) {
            errors.password = 'Password must be greater than 4 characters.';
        }
        if (password !== confirmPassword) {
            errors.confirm = 'Passwords do not match.';
        }
        if (Object.keys(errors).length > 0) {
            usernameErrorDiv.textContent = errors.username || '';
            roleErrorDiv.textContent = errors.role || '';
            emailErrorDiv.textContent = errors.email || '';
            passwordErrorDiv.textContent = errors.password || '';
            confirmErrorDiv.textContent = errors.confirm || '';
        }
        if (Object.keys(errors).length === 0) {
            e.target.submit();
        }
    });
});