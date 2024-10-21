// var PortfolioItems;


import {Div, Image, Text} from "../utils/dom";
import { marked } from "marked";

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

var overlay = document.getElementById("overlay");

overlay.addEventListener("click", (e) => {
    if(e.target === overlay)
    overlay.classList.remove("portfolio-overlay-open");
})
function CreateImage(item) {
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

    var content = item.Content;

    for(var x = 0; x < item.Images.length; x++) {
        var thisurl = item.Images[x];
        if (!thisurl.startsWith("http")) {
            thisurl = `/img/portfolio/${item.ID}/${thisurl}`;
        }
        console.log(thisurl)
        content = content.replace(`{IMAGE_${x}}`, thisurl);
    }
    container.addEventListener("click", () => {
        document.getElementById("overlay-title").innerHTML = item.Name;
        document.getElementById("overlay-image").src = url;
        document.getElementById("overlay-content").innerHTML = marked.parse(content);
        if(item.Link == null || item.Link == "") {
            document.getElementById("overlay-visit").classList.add("hidden");
        } else {
            document.getElementById("overlay-visit").classList.remove("hidden");
            document.getElementById("overlay-visit").href = item.Link;
        }
        overlay.classList.add("portfolio-overlay-open");
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
    }
}

var layoutOrder = ["BigCoverAny", "OneTwoThree", "BrandingArea", "SideBySideBanner", "SideBySideWebsite", "OneTwoThree", "SideBySideBanner", "AlbumRow", "SideBySideBanner", "BigCover", "OneTwoThree", "SideBySide", "SideBySideThree", "BigCover", "SideBySideBanner", "OneTwoThree", "AlbumRow", "SideBySideWebsite", "OneTwoThree", "BrandingArea", "SideBySideBanner", "BigCover", "SideBySideBanner", "SideBySideWebsite", "OneTwoThree", "BrandingArea", "AlbumRow", "SideBySideThree", "BigCover", "OneTwoThree", "BrandingArea", "BigCover", "AlbumRow", "SideBySide", "SideBySideBanner", "OneTwoThree", "BigCover", "BrandingArea", "AlbumRow", "OneTwoThree", "BigCover"];

var grid = document.getElementById("portfolio-grid");

for (var item of layoutOrder) {
    layoutOrder.push(item); // never runs out :)
    grid.appendChild(layouts[item]());
}


console.log("Next Cover", GetNextItem("cover"));
console.log("Next Cover", GetNextItem("cover"));
console.log("Next Branding", GetNextItem("branding"));