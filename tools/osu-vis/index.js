function badges(el) {
    document.body.className = "badges";
    for (button of document.querySelectorAll(".tab")) {
        button.classList.remove("tab-sel");
    }
    el.classList.add("tab-sel");
}
function news(el) {
    document.body.className = "news";

    for (button of document.querySelectorAll(".tab")) {
        button.classList.remove("tab-sel");
    }
    el.classList.add("tab-sel");
}


const myElement = document.body;

myElement.addEventListener("dragstart", (evt) => {
    document.getElementById("dragdrop").classList.remove("hidden");
    evt.dataTransfer.setData("id", "my-element");
});

document.documentElement.addEventListener("dragover", (evt) => {
    document.getElementById("dragdrop").classList.remove("hidden");
    evt.preventDefault();
});
document.documentElement.addEventListener("dragleave", (evt) => {
    document.getElementById("dragdrop").classList.add("hidden");
    evt.preventDefault();
});
document.documentElement.addEventListener("dragend", (evt) => {
    document.getElementById("dragdrop").classList.add("hidden");
    evt.preventDefault();
});

document.documentElement.addEventListener("drop", (ev) => {
    document.getElementById("dragdrop").classList.add("hidden");
    ev.preventDefault();
    if (ev.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        [...ev.dataTransfer.items].forEach((item, i) => {
            // If dropped items aren't files, reject them
            if (item.kind === "file") {
                const file = item.getAsFile();
                console.log(`… file[${i}].name = ${file.name}`);
                let newURL = URL.createObjectURL(file);
                document.getElementById("newspost-items").style = `--image: url("` + newURL + `")`;
            }
        });
    } else {
        // Use DataTransfer interface to access the file(s)
        [...ev.dataTransfer.files].forEach((file, i) => {
            console.log(`… file[${i}].name = ${file.name}`);
            let newURL = URL.createObjectURL(file);
            document.getElementById("newspost-items").style = `--image: url("` + newURL + `")`;
        });
    }
});

document.onpaste = function(event){
    var items = (event.clipboardData || event.originalEvent.clipboardData).items;
    console.log(JSON.stringify(items)); // will give you the mime types
    for (index in items) {
      var item = items[index];
      if (item.kind === 'file') {
        var blob = item.getAsFile();
        var reader = new FileReader();
        reader.onload = function(event){
          console.log(event.target.result)}; // data url!
        reader.readAsDataURL(blob);

        let newURL = URL.createObjectURL(item.getAsFile());
            document.getElementById("newspost-items").style = `--image: url("` + newURL + `")`;
      }
    }
  }
  