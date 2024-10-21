
import '../../css/views/portfolio_admin.css'
import {DoRequest} from "../utils/requests";
import {Div, Text, Image} from "../utils/dom";
export * from "../elements/image-drag-area.js";
console.log("gm!!!");

var data = [];
var list = document.getElementById("item-list");

function generateItem(item) {
    console.log(item);
    var div = Div("div", "portfolio-item");

    div.appendChild(Image("/img/portfolio/" + item.ID + "/" + item.Images[0]))
    div.appendChild(Text("h3", item.Name));

    var edit = Div("a", "button");
    edit.innerText = "Edit";
    edit.href = "/admin/portfolio/" + item.ID;
    div.appendChild(edit);

    if(item.Visible === 0) {
        div.style.opacity = 0.5;
    }

    return div;
}
async function Load() {
    data = await DoRequest("POST", "/admin/api/portfolio")

    for(var item of data) {
        item.Images = JSON.parse(item.Images);
        var output = generateItem(item);
        item.Element = output;
        list.appendChild(output);
    }

    document.getElementById("upload").addEventListener("click", async () => {
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "/admin/api/portfolio/upload", true);


        const formData = new FormData();
        if (document.getElementById("file").files.length > 0) {
            var x = 0;
            for(var file of document.getElementById("file").files) {
                formData.append(x, file);
                x++;
            }
        }
        var id = Math.round(Date.now()/1000);
        formData.append("id", id); // don't ask

        xhr.onload = () => {
            location.href = "/admin/portfolio/" + id;
        }

        xhr.send(formData);
    })
}

Load();