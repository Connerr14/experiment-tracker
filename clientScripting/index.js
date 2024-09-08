let experimentName = document.querySelector("select");
let submitButton = document.getElementById("submitButton");
const form = document.getElementById("logStats");

console.log(submitButton);
console.log(experimentName.textContent);

if (experimentName.textContent.trim() === "No experiments started!")
{
    // Just removing the submit button and adding a message (further error handling done server side)
    submitButton.style.display = "none";
    let message = document.createElement("h3");
    message.textContent = "You have no active experiments!";
    form.appendChild(message);

}

