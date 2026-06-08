// var PortfolioItems;


import {Div, Image, Text} from "../utils/dom";


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
            if (aspect !== maxAspect && aspectWay === "exact") continue;
        }

        grabbed.push(item);
        return item;
    }

    if (rec) return GetNextItem("", "", maxAspect, aspectWay, true)
    return GetNextItem("", "cover", maxAspect, aspectWay, true);
}

var animation_delay = 0.3;


function CreateImage(item, simple = false) {
    var container = Div("a", "image-container");
    var url = item["Images"][0];
    if (!url.startsWith("http")) {
        url = `/img/portfolio/${item.ID}/medium.png`;
    }
    var img = Image(url);
    img.setAttribute("data-src", url);


    const [w, h] = item.Ratio.split(":");
    img.setAttribute("src", `data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 ${w} ${h}'%3E%3C/svg%3E`);

    img.classList.add("lazy");
    img.style.setProperty("--ratio", item.Ratio.replace(":", " / "));
    container.appendChild(img);
    container.style.animationDelay = animation_delay + "s";
    container.style.setProperty("--ratio", item.Ratio.replace(":", " / "));

    var overlay = Div("div", "imgoverlay");
    overlay.appendChild(Text("h1", item['Type']));
    overlay.appendChild(Text("p", item['Name']));
    container.appendChild(overlay);

    if (animation_delay < 0.7) {
        animation_delay += 0.05;
    }

    container.setAttribute("href", `/portfolio/${item.ID}`);

    return container;
}


var layouts = {
    "BigCover": () => {
        var container = Div("layout-bigcover");
        container.appendChild(CreateImage(GetNextItem("", "cover", 2.9, "min")));
        return container;
    },
    "BigCoverAny": () => {
        var container = Div("layout-bigcoverany");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 1.6, "min")));
        return container;
    },
    "SideBySide": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        return container;
    },
    "SideBySideBanner": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2, "min"))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2, "min"))); // really want branding!
        return container;
    },
    "SideBySideWebsite": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("website", "", 3, "max"))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("website", "", 3, "max"))); // really want branding!
        return container;
    },
    "SideBySideThree": () => {
        var container = Div("layout-sidebyside");
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        container.appendChild(CreateImage(GetNextItem("", "cover,website", 2))); // really want branding!
        return container;
    },
    "AlbumRow": () => {
        var container = Div("layout-albumrow");
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("branding", "", 1, "exact")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        container.appendChild(CreateImage(GetNextItem("cover")));
        return container;
    },
    "BrandingArea": () => {
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

var layoutOrder = [
    "BigCoverAny",
    "SideBySideThree",
    "BrandingArea",
    "SideBySideBanner",
    "SideBySideWebsite",
    "SideBySideThree",
    "SideBySideBanner",
    "AlbumRow",
    "SideBySideBanner",
    "BigCover",
    "SideBySideThree",
    "SideBySide",
    "SideBySideThree",
    "BigCover",
    "SideBySideBanner",
    "AlbumRow",
    "SideBySideWebsite",
    "BrandingArea",
    "SideBySideBanner",
    "BigCover",
    "SideBySideBanner",
    "SideBySideWebsite",
    "BrandingArea",
    "AlbumRow",
    "SideBySideThree",
    "BigCover",
    "BrandingArea",
    "BigCover",
    "AlbumRow",
    "SideBySide",
    "SideBySideBanner",
    "BigCover",
    "BrandingArea",
    "AlbumRow",
    "BigCover"
];

var grid = document.getElementById("portfolio-grid");

var layout = "";
window.addEventListener("resize", () => {
    load();
})

var layout = "grid"; // Initialize layout

function selectLayout(l, cui = false) {
    layout = l;
    console.log("Layout selected:", layout);
}

let manualLayout = false;
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
    }, 1)

    lastLayout = layout;
}

load();
