const urlParams = new URLSearchParams(window.location.search);
const errorMessage = urlParams.get('error');
const email = urlParams.get('email');

document.querySelector('input[name="email"]').value = email;

if (errorMessage === 'invalid_email') {
    const errorLabelEmail = createErrorLabel('Incorrect email');
    insertErrorLabel('input[name="email"]', errorLabelEmail);
} else if (errorMessage === 'invalid_password') {
    const errorLabelPassword = createErrorLabel('Incorrect password');
    insertErrorLabel('input[name="password"]', errorLabelPassword);
}

function createErrorLabel(errorMessage) {
    const errorLabel = document.createElement('label');
    errorLabel.innerText = errorMessage;
    errorLabel.style.color = 'red';
    errorLabel.style.fontSize = '14px';
    return errorLabel;
}

function insertErrorLabel(selector, errorLabel) {
    const element = document.querySelector(selector);
    if (element) {
        element.parentElement.insertAdjacentElement('beforeend', errorLabel);
    }
}
