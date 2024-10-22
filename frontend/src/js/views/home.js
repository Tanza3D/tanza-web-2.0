import '../../css/views/home.css'
import {DoRequest} from "../utils/requests";
import {Div, Text, LucideIcon} from "../utils/dom";


const email = document.getElementById("contact-email");
const name = document.getElementById("contact-name");
const body = document.getElementById("contact-body");
document.getElementById("contact-send").addEventListener("click", async () => {
    document.getElementById("contact").classList.add("loading");
    await DoRequest("POST", "/contact", {
        "from": email.value,
        "name": name.value,
        "body": body.value
    })
    document.getElementById("contact").classList.remove("loading");
    document.getElementById("contact").querySelector(".page-container").innerHTML = "<h1>Thanks! I'll get back to you soon!</h1>";
})

function checkInputs() {
    if (
        email.value == ""
        ||
        name.value == ""
        ||
        body.value == ""
    ) {
        document.getElementById("contact-send").classList.add("disabled");
    } else {
        document.getElementById("contact-send").classList.remove("disabled");
    }
}
checkInputs();

email.addEventListener("keyup", checkInputs)
name.addEventListener("keyup", checkInputs)
body.addEventListener("keyup", checkInputs)

window.CopyDiscord = (event) => {
    var clickPopup = Div("div", "click-popup");
    clickPopup.appendChild(LucideIcon("copy"))
    clickPopup.appendChild(Text("h1", "copied!"));

    var mouse_x = event.clientX;
    var mouse_y = event.clientY;
    clickPopup.style.left = mouse_x + "px";
    clickPopup.style.top = mouse_y + "px";
    document.body.appendChild(clickPopup);

    navigator.clipboard.writeText("tanza3d");
}