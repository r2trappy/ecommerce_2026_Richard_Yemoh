
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
    const productForm = document.getElementById('product-form');
    if (productForm) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const maxSize = 2 * 1024 * 1024;
        const imageInput = document.getElementById('product_image');

        function checkImage() {
            clearErrors(['image-error']);
            if (imageInput.files.length === 0) {
                return true;
            }
            const file = imageInput.files[0];
            if (allowedTypes.indexOf(file.type) === -1) {
                showError('image-error', 'Only JPG, PNG, GIF and WEBP images are allowed.');
                return false;
            }
            if (file.size > maxSize) {
                showError('image-error', 'The image must be 2MB or smaller.');
                return false;
            }
            return true;
        }

        imageInput.addEventListener('change', checkImage);

        productForm.addEventListener('submit', function (e) {
            clearErrors(['title-error', 'price-error', 'image-error']);
            let valid = true;
            const title = document.getElementById('product_title').value.trim();
            const price = parseFloat(document.getElementById('product_price').value);

            if (title.length < 2) {
                showError('title-error', 'Please enter a product title.');
                valid = false;
            }
            if (isNaN(price) || price <= 0) {
                showError('price-error', 'Please enter a price greater than 0.');
                valid = false;
            }
            if (!checkImage()) {
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });
    }
});
