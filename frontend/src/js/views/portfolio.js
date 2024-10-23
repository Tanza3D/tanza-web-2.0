// var PortfolioItems;


import {Div, Image, Text} from "../utils/dom";
import {marked} from "marked";
import {getParam, insertParam} from "../utils/urlQuery";


function OpenItemInOverlay(item) {

    var url = item["Images"][0];
    if (!url.startsWith("http")) {
        url = `/img/portfolio/${item.ID}/medium.png`;
    }

    var content = item.Content;

    for (var x = 0; x < item.Images.length; x++) {
        var thisurl = item.Images[x];
        if (!thisurl.startsWith("http")) {
            thisurl = `/img/portfolio/${item.ID}/${thisurl}`;
        }
        console.log(thisurl)
        content = content.replace(`{IMAGE_${x}}`, thisurl);
    }

    document.getElementById("overlay-title").innerHTML = item.Name;
    document.getElementById("overlay-image").src = url;
    document.getElementById("overlay-content").innerHTML = marked.parse(content);
    if (item.Link == null || item.Link == "") {
        document.getElementById("overlay-visit").classList.add("hidden");
    } else {
        document.getElementById("overlay-visit").classList.remove("hidden");
        document.getElementById("overlay-visit").href = item.Link;
    }
    overlay.classList.add("portfolio-overlay-open");

    insertParam("item", item.ID, true);
}


var overlay = document.getElementById("overlay");
function GetItemFromId(id) {
    for(var item of PortfolioItems) {
        if(item.ID == id) return item;
    }
}
function CheckUrl() {
    if(getParam("item", null) == null) {
        overlay.classList.remove("portfolio-overlay-open");
    } else {
        var item = GetItemFromId(getParam("item"));
        overlay.classList.add("portfolio-overlay-open");
    }
}

CheckUrl();
window.addEventListener('popstate', function(event) {
    CheckUrl();
});

var grabbed = [];

function GetNextItem(type = "", notType = "", maxAspect = null, aspectWay = "max", rec = false) {

    var not = notType.split(",");
    console.log("fetching for " + type)
    for (var item of PortfolioItems) {
        if (item.Type != type && type !== "") continue;
        if (not.includes(item.Type)) continue;
        if (grabbed.includes(item)) continue;

        if (maxAspect != null) {
            var aspect_ = item.Ratio.split(":");
            var aspect = aspect_[0] / aspect_[1];
            if (aspect > maxAspect && aspectWay === "max") continue;
            if (aspect < maxAspect && aspectWay === "min") continue;
        }

        grabbed.push(item);
        return item;
    }

    if (rec) return GetNextItem("", "", maxAspect, aspectWay, true)
    return GetNextItem("", "cover", maxAspect, aspectWay, true);
}

var animation_delay = 0.3;


overlay.addEventListener("click", (e) => {
    if (e.target === overlay)
        window.history.go(-1);
})

function CreateImage(item, simple = false) {
    console.log(item);
    var container = Div("div", "image-container");
    console.log(item);
    var url = item["Images"][0];
    if (!url.startsWith("http")) {
        url = `/img/portfolio/${item.ID}/medium.png`;
    }
    var img = Image(url);

    img.setAttribute("data-src", url);
    img.setAttribute("src", "");
    img.classList.add("lazy");

    img.style.setProperty("--ratio", item.Ratio.replace(":", " / "));
    container.appendChild(img);

    container.style.animationDelay = animation_delay + "s";
    container.style.setProperty("--ratio", item.Ratio.replace(":", " / "));



    var bar = Div("div", "bar");
    container.appendChild(bar);

    var barInner = Div("div", "bar-inner");


    barInner.classList.add("slant");

    var barHighlight = Div("div", "bar-highlight");

    var txt1 = Text("h3", item['Type'])
    var txt2 = Text("h4", item['Name'])

    txt1.classList.add("slant-inner");
    txt2.classList.add("slant-inner");

    barHighlight.appendChild(txt1)

    barInner.appendChild(barHighlight);
    barInner.appendChild(txt2)
    bar.appendChild(barInner);

    if (animation_delay < 0.7) {
        animation_delay += 0.05;
    }

    container.addEventListener("click", () => {
        OpenItemInOverlay(item)
    })

    return container;
}

var ott_inv = false;


var layouts = {
    "OneTwoThree": () => {
        var website = GetNextItem("website", "", 2, "max");
        var branding = [GetNextItem("branding", "", 2, "max"), GetNextItem("branding", "", 2, "max")]
        var cover = [GetNextItem("cover"), GetNextItem("cover"), GetNextItem("cover")]

        var container = Div("layout-onetwothree");

        var left = Div("div", "left");
        var right = Div("div", "right");
        var rightTop = Div("div", "top");
        var rightBottom = Div("div", "bottom");

        container.appendChild(left);
        container.appendChild(right);

        right.appendChild(rightTop);
        right.appendChild(rightBottom);

        left.appendChild(CreateImage(website))
        rightTop.appendChild(CreateImage(branding[0]))
        rightTop.appendChild(CreateImage(branding[1]))
        rightBottom.appendChild(CreateImage(cover[0]))
        rightBottom.appendChild(CreateImage(cover[1]))
        rightBottom.appendChild(CreateImage(cover[2]))

        if (ott_inv) container.classList.add("inverse");
        ott_inv = !ott_inv

        return container;
    }, "BigCover": () => {
        var container = Div("layout-bigcover");
        container.appendChild(CreateImage(GetNextItem("", "cover", 2.9, "min")));
        return container;
    }, "BigCoverAny": () => {
        var container = Div("layout-bigcoverany");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 1.6, "min")));
        return container;
    }, "SideBySide": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        return container;
    }, "SideBySideBanner": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2, "min"))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2, "min"))); // really want branding!
        return container;
    }, "SideBySideWebsite": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("website", "", 3, "max"))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("website", "", 3, "max"))); // really want branding!
        return container;
    }, "SideBySideThree": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        return container;
    }, "AlbumRow": () => {
        var container = Div("layout-albumrow");
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        return container;
    }, "BrandingArea": () => {
        var container = Div("layout-brandingarea");
        var top = Div("div", "top");
        var bottom = Div("div", "bottom");
        container.appendChild(top);
        container.appendChild(bottom);


        top.appendChild(CreateImage(GetNextItem("branding", "", 2, "max")));
        top.appendChild(CreateImage(GetNextItem("branding", "", 2, "max")));
        bottom.appendChild(CreateImage(GetNextItem("branding", "", 2, "max")));
        bottom.appendChild(CreateImage(GetNextItem("branding", "", 2, "max")));
        bottom.appendChild(CreateImage(GetNextItem("branding", "", 2, "max")));
        return container;
    },
    "SingleAny": () => {
        var container = Div("layout-singleany");
        container.appendChild(CreateImage(GetNextItem("", "cover")));
        container.appendChild(CreateImage(GetNextItem("", "cover")));

        var covers = Div("div", "covers");
        covers.appendChild(CreateImage(GetNextItem("cover")));
        covers.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(covers);

        return container;
    },

    "SingleAdvanced": () => {
        var container = Div("layout-advanced");
        container.appendChild(CreateImage(GetNextItem(), true));
        var info = Div("div");

        info.appendChild()

        return container;
    }
}

var layoutOrder = ["BigCoverAny", "OneTwoThree", "BrandingArea", "SideBySideBanner", "SideBySideWebsite", "OneTwoThree", "SideBySideBanner", "AlbumRow", "SideBySideBanner", "BigCover", "OneTwoThree", "SideBySide", "SideBySideThree", "BigCover", "SideBySideBanner", "OneTwoThree", "AlbumRow", "SideBySideWebsite", "OneTwoThree", "BrandingArea", "SideBySideBanner", "BigCover", "SideBySideBanner", "SideBySideWebsite", "OneTwoThree", "BrandingArea", "AlbumRow", "SideBySideThree", "BigCover", "OneTwoThree", "BrandingArea", "BigCover", "AlbumRow", "SideBySide", "SideBySideBanner", "OneTwoThree", "BigCover", "BrandingArea", "AlbumRow", "OneTwoThree", "BigCover"];

var grid = document.getElementById("portfolio-grid");

var layout = "";
window.addEventListener("resize", () => {
    load();
})

var selector = document.getElementById("fieldset");
var manualLayout = false;
var layout = "grid"; // Initialize layout

function selectLayout(l, cui = false) {
    layout = l;
    console.log("Layout selected:", layout);

    if (cui) {
        for (var child of selector.querySelectorAll("input")) {
            if (child.id === layout) {
                child.checked = true;
            } else {
                child.checked = false;
            }
        }
    }
}

// Add event listener to detect changes in the fieldset
selector.addEventListener("change", (event) => {
    // Get the selected value from the changed radio button
    var selectedValue = document.querySelector('input[name="view"]:checked').value;
    selectLayout(selectedValue);
    manualLayout = true; // Set to true when the user manually selects a layout
    load();
});
var lastLayout = "";

// Function to auto-select layout based on screen size
function load() {
    if (!manualLayout) {
        if (window.innerWidth < 900) {
            selectLayout("list-simple", true);
        } else {
            selectLayout("grid", true);
        }
    }

    if (layout === lastLayout) {
        console.log(layout, "is", lastLayout);
        return;
    }
    console.log("Layout changed to:", layout);

    grid.classList.add("hide");
    setTimeout(() => {
        grid.innerHTML = "";
        grabbed = [];
        try {
            switch (layout) {
                case "grid":
                    for (var item of layoutOrder) {
                        layoutOrder.push(item); // never runs out :)
                        grid.appendChild(layouts[item]());
                    }
                    break;
                case "list-simple":
                    for (var x = 0; x < PortfolioItems.length; x++) {
                        grid.appendChild(layouts["SingleAny"]());
                    }
                    break;
                case "list-advanced":
                    for (var x = 0; x < PortfolioItems.length; x++) {
                        grid.appendChild(layouts["SingleAdvanced"]());
                    }
                    break;
            }
        } catch (e) {
            grid.classList.remove("hide");
            console.log(e);
        }
        window.loader.update();
        grid.classList.remove("hide");
    }, 500)

    lastLayout = layout;
}

load();