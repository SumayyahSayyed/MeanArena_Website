let hamburger = document.getElementById("hamburger");
hamburger.addEventListener("click", () => {
    if (hamburger.classList.contains("clockwise")) {
        hamburger.classList.remove("clockwise");
        hamburger.classList.add("counterclockwise");
    } else {
        hamburger.classList.remove("counterclockwise");
        hamburger.classList.add("clockwise");
    }
});

let sidePanel = document.getElementById("side");
hamburger.addEventListener("click", () => {
    sidePanel.classList.toggle("show");
})

let dropdown = document.getElementById("dropdown");
let profile = document.getElementById("profile");
profile.addEventListener("click", () => {
    dropdown.classList.toggle("hide");
})

function deleteWord(wordId, trashIcon) {
    // Define the request parameters
    const params = {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + wordId
    };

    // Send the request using fetch
    fetch('http://localhost/Practice/php/delete.php', params)
        .then(response => {
            if (response.ok) {
                // Remove the HTML for the word entry
                trashIcon.closest('.box').remove();
            } else {
                console.error('Error deleting word:', response.status);
            }
        })
        .catch(error => console.error('Error deleting word:', error));
}
