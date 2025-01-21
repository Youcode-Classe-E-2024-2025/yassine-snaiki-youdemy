document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', event => {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        let valid = true;
        let errors = {};

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            valid = false;
            errors.email = 'Invalid email format.\n';
        }

        if (password.length <= 4) {
            valid = false;
            errors.password = 'Password must be greater than 4 characters.\n';
        }

        if (valid) {
            event.target.submit();
        }
    });
});
