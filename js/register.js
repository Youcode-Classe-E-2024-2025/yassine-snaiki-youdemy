// document.addEventListener('DOMContentLoaded', function() {
//     const registerForm = document.getElementById('registerForm');
//     registerForm.addEventListener('submit', event=> {
//         event.preventDefault();
//         const email = document.getElementById('email').value;
//         const password = document.getElementById('password').value;
//         const confirmPassword = document.getElementById('confirm_password').value;
//         const username = document.getElementById('username').value;

//         let valid = true;
//         let errors = {};

//         const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         if (!emailPattern.test(email)) {
//             valid = false;
//             errors.email = 'Invalid email format.\n';
//         }

//         if (password.length <= 4) {
//             valid = false;
//             errors.password  = 'Password must be greater than 4 characters.\n';
//         }

//         if (password !== confirmPassword) {
//             valid = false;
//             errors.confirm = 'Passwords do not match.\n';
//         }

//         if (username.length <= 4) {
//             valid = false;
//             errors.username = 'Username must be greater than 4 characters.\n';
//         }

//         if (valid) {
//             event.target.submit()
//         }
//     });
// });
