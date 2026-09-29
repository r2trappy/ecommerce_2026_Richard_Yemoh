function showError(id, message) {
    const el = document.getElementById(id);
    if (el) el.textContent = message;
}

function clearErrors(ids) {
    ids.forEach((id) => showError(id, ''));
}

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneRegex = /^[0-9+\-\s]{7,15}$/;
const passRegex  = /^(?=.*\d).{8,}$/;

document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            clearErrors(['name-error', 'email-error', 'pass-error', 'contact-error']);
            let valid = true;

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const pass = document.getElementById('pass').value;
            const contact = document.getElementById('contact').value.trim();

            if (name.length < 2) {
                showError('name-error', 'Please enter your full name.');
                valid = false;
            }
            if (!emailRegex.test(email)) {
                showError('email-error', 'Please enter a valid email.');
                valid = false;
            }
            if (!passRegex.test(pass)) {
                showError('pass-error', 'Password needs 8+ characters and a number.');
                valid = false;
            }
            if (contact && !phoneRegex.test(contact)) {
                showError('contact-error', 'Please enter a valid phone number.');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            } else {
                const btn = document.getElementById('register-submit');
                if (btn) { btn.disabled = true; btn.textContent = 'Creating account...'; }
            }
        });
    }

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            clearErrors(['login-email-error']);
            const email = document.getElementById('login-email').value.trim();
            if (!emailRegex.test(email)) {
                showError('login-email-error', 'Please enter a valid email.');
                e.preventDefault();
            }
        });
    }
});
