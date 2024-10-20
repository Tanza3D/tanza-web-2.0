
import '../../css/views/portfolio_admin.css'
import {DoRequest} from "../utils/requests";
import {Div, Text, Image} from "../utils/dom";

info.Images = JSON.parse(info.Images);

var key = -1;
for(var image of info.Images) {
    key++;
    var imageCont = Div();
    var imageEl = Image(`/img/portfolio/${info.ID}/${image}`)

    var markdownPlaceholder = Text("p", `![Image ${key}]({IMAGE_${key}})`);

    imageCont.appendChild(imageEl);
    imageCont.appendChild(markdownPlaceholder);

    document.getElementById("image-grid").appendChild(imageCont);
}

var values = {}

function addInput(key, input) {
    input.value = info[key];
    values[key] = {
        "key": key,
        "input": input
    }
}

addInput("Name", document.getElementById("title"));
addInput("Link", document.getElementById("link"));
addInput("Content", document.getElementById("content"));
addInput("Type", document.getElementById("type"));
addInput("Date", document.getElementById("date"));
addInput("Visible", document.getElementById("visible"));

document.getElementById("submit").addEventListener("click", async () => {
    var post = {};
    for(var key in values) {
        post[key] = values[key].input.value
    }
    document.body.classList.add("loading");
    await DoRequest("POST", "/admin/api/portfolio/update/"+info.ID, post);
    document.body.classList.remove("loading");
})