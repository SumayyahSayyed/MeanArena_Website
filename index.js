let dropdown = document.getElementById("dropdown");
let profile = document.getElementById("profile");
profile.addEventListener("click", () => {
    dropdown.classList.toggle("hide");
})

document.getElementById('contact').addEventListener('submit', function (event) {
    // Change the button text to 'Submitted'
    document.getElementById('submitBtn').innerText = 'Submitted';
})