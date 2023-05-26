let errorDisplayed = false; // Flag to track if the error message is already displayed

function removeErrorMessage() {
    const errorLabels = document.querySelectorAll(".error-message");
    errorLabels.forEach(label => {
        label.remove();
    });
    errorDisplayed = false; // Reset the flag when the error messages are removed
}

function validateForm() {
    let fName = document.forms[0]["firstname"].value;
    let lName = document.forms[0]["lastname"].value;
    let email = document.forms[0]["email"].value;
    let password = document.forms[0]["password"].value;

    removeErrorMessage(); // Remove any existing error messages before validating again

    if (fName === "") {
        let select = document.querySelector('input[name="firstname"]');
        displayErrorMessage(select.parentElement, "Please fill in your First Name");
        return false;
    }
    if (lName === "") {
        let select = document.querySelector('input[name="lastname"]');
        displayErrorMessage(select.parentElement, "Please fill in your Last Name");
        return false;
    }
    if (email === "") {
        let select = document.querySelector('input[name="email"]');
        displayErrorMessage(select.parentElement, "Please fill in email address");
        return false;
    }
    if (password === "") {
        let select = document.querySelector('input[name="password"]');
        displayErrorMessage(select.parentElement, "Please enter the password");
        return false;
    }

    return true;
}

function displayErrorMessage(parentElement, errorMessage) {
    if (!errorDisplayed) {
        let errorLabel = document.createElement("label");
        errorLabel.classList.add("error-message");
        errorLabel.innerText = errorMessage;
        errorLabel.style.color = "red";
        errorLabel.style.fontSize = "14px";
        parentElement.insertAdjacentElement('beforeend', errorLabel);
        errorDisplayed = true; // Set the flag to true when the error message is displayed
    }
}
