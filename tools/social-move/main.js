console.log("success");

function doToast(text, colour) {
    var toast = document.createElement("div");
    toast.style = "--col: " + colour;
    toast.innerHTML = text;
    toast.className = "toast";
    document.getElementById("toasts").appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

var templates = {
    "bsky": {
        "pos": [1500/2, 347],
        "fontSize": 30,
        "fontColor": "#111",
        "fontAlign": "center",
    },
    "bsky-classic": {
        "pos": [810, 296],
        "fontSize": 35,
        "fontColor": "#111",
        "fontAlign": "left",
    }
}
var current_template = "bsky";

document.getElementById("style").addEventListener("change", () => {
    current_template = document.getElementById("style").value;
    renderBanner(current_template);
})

var canvas = document.getElementById('render'),
    context = canvas.getContext('2d');


var current_tag = "";
function renderBanner(template, text = null) {
    if(text == null) text = current_tag;

    current_tag = text;
    base_image = new Image();
    base_image.src = 'templates/' + template + '.png';
    /*  document.getElementById("temp").appendChild(base_image); */
    console.log("loading image");
    base_image.addEventListener("load", () => {
        console.log("load 2");
        console.log("drawing image");
        context.drawImage(base_image, 0, 0);
        context.font = templates[template].fontSize + "px ClashDisplay";
        context.textAlign = templates[template].fontAlign;
        context.fillText(text, templates[template].pos[0], templates[template].pos[1]);
    })

}
renderBanner(current_template, "");

document.getElementById("input").addEventListener("keyup", function () {
    renderBanner(current_template, document.getElementById("input").value);
})

function save() {
    let downloadLink = document.createElement('a');
    downloadLink.setAttribute('download', current_tag + '.png');
    if (current_tag == "") {
        doToast("You haven't put anything in the input box! Try again.", "#f73747");
        return;
    }
    let dataURL = canvas.toDataURL('image/png');
    let url = dataURL.replace(/^data:image\/png/, 'data:application/octet-stream');
    downloadLink.setAttribute('href', url);
    downloadLink.click();
    doToast("Saved!", "#3F99E9");
}

function copy() {
    if (current_tag == "") {
        doToast("You haven't put anything in the input box! Try again.", "#f73747");
        return;
    }

    canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})]))
    doToast("Copied!", "#3F99E9");

}

try {
    // ? firefox doesn't support clipboard, so we hide it in that case
    if(typeof(ClipboardItem) == "undefined") {
        document.getElementById("copy").style = "display: none";
    }
} catch {
    document.getElementById("copy").style = "display: none";
}
document.getElementById("save").addEventListener("click", save);
document.getElementById("copy").addEventListener("click", copy);
