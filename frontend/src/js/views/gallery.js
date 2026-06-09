import '../../css/views/gallery.css'
import {D2} from "../utils/d2";
import LazyLoad from "vanilla-lazyload";

const items = posts.items.filter(item => item.Images && item.Images.length > 0 && item.Authors.length <= 1);


// -- sidebar state --
var imageCounts = {};

// -- dom refs --
var grid = document.getElementById("gallery-grid");
var sidebar = document.getElementById("gallery-sidebar");

// month name lookup
var monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

// -- aspect helpers --
function getItemRatio(item) {
    return item.Images[0].Width / item.Images[0].Height;
}

// -- row building --
// replicates the old php batching logic exactly
function buildRows(items) {
    var rows = [];
    var batch = [];
    var counter = 0;
    var limit = 2.9;
    var flushedFirst = false;
    var currentYear = null;

    for (var item of items) {
        var year = new Date(item.Date).getFullYear();
        var ratio = getItemRatio(item);
        var wide = ratio >= 2.4;

        if (currentYear !== null && year !== currentYear && batch.length > 0) {
            rows.push({ items: batch, wide: false });
            batch = [];
            counter = 0;
        }

        currentYear = year;
        batch.push(item);
        counter += ratio;

        if (counter >= limit || (!flushedFirst && wide)) {
            rows.push({ items: batch, wide: wide && batch.length === 1 });
            batch = [];
            counter = 0;
            flushedFirst = true;
        }
    }

    if (batch.length > 0) rows.push({ items: batch, wide: false });

    return rows;
}

// -- date tracking for sidebar --
function trackDate(item) {
    var date = new Date(item.Date);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;

    var ykey = "y" + year;
    var mkey = "m" + month;

    if (!imageCounts[ykey]) {
        imageCounts[ykey] = { count: 0, name: year };
    }
    if (!imageCounts[ykey][mkey]) {
        imageCounts[ykey][mkey] = { count: 0, name: month };
    }

    imageCounts[ykey].count++;
    imageCounts[ykey][mkey].count++;

    return { year, month, ykey, mkey };
}

// -- create a single gallery card --
function createCard(item) {
    var { ykey, mkey } = trackDate(item);
    var date = new Date(item.Date);

    var img0 = item.Images[0];
    var links = img0.Links;
    var blur = img0.ImageBlur;
    var w = img0.Width;
    var h = img0.Height;

    var card = D2.DivLink(`https://anthera.art/post/${item.ID}`, "gallery-card");
    card.setAttribute("data-year", ykey);
    card.setAttribute("data-month", mkey);
    card.style.setProperty("--ratio", `${w}/${h}`);

    var imgWrap = D2.Div("gallery-card-img", () => {
        D2.LazyImage(
            "gallery-img lazy",
            links.thumbnail,
            `data:image/jpeg;base64,${blur}`
        );
    });
    card.appendChild(imgWrap);

    var overlay = D2.Div("gallery-card-overlay", () => {
        D2.Text("h2", item.Name, "gallery-card-name");
        D2.Text("p", date.toLocaleString("en", {
            month: "long",
            day: "numeric",
            year: "numeric",
        }), "gallery-card-date");
    });
    card.appendChild(overlay);

    return card;
}

// -- render all rows --
function renderGrid() {
    var rows = buildRows(items);
    var lastYear = null;

    for (var row of rows) {
        var year = new Date(row.items[0].Date).getFullYear();

        if (year !== lastYear) {
            var yearHeader = D2.Text("h2", year, "gallery-year-header");
            grid.appendChild(yearHeader);
            lastYear = year;
        }

        var cls = "gallery-row";
        if (row.items.length === 1) {
            cls += row.wide ? " gallery-row-single" : " gallery-row-single gallery-row-single-portrait";
        } else {
            cls += " gallery-row-double";
        }

        var rowEl = D2.Div(cls);
        for (var item of row.items) {
            rowEl.appendChild(createCard(item));
        }
        grid.appendChild(rowEl);
    }
}

// -- sidebar --
function doScrollTo(element) {
    var y = element.getBoundingClientRect().top + window.pageYOffset - 40;
    window.scrollTo({ top: y, behavior: "smooth" });
}

function generateSidebar() {
    for (var [ykey, yvalue] of Object.entries(imageCounts)) {
        var yearEl = D2.Div("gsb-year");
        yearEl.setAttribute("data-sidebar-year", ykey);

        var yearHead = D2.Text("h1", yvalue.name, "gsb-year-heading");
        yearEl.appendChild(yearHead);

        var monthsEl = D2.Div("gsb-months");

        for (var [mkey, mvalue] of Object.entries(yvalue)) {
            if (mvalue.name === undefined) continue;

            var monthEl = D2.Div("gsb-month");
            monthEl.setAttribute("data-sidebar-month", mkey);

            var monthName = D2.Text("p", monthNames[parseInt(mvalue.name) - 1], "gsb-month-name");
            var monthCount = D2.Text("span", mvalue.count, "gsb-month-count");
            monthEl.appendChild(monthName);
            monthEl.appendChild(monthCount);
            monthsEl.appendChild(monthEl);

            ;(function(capturedMkey, capturedYkey) {
                monthEl.onclick = function() {
                    var target = document.querySelector(
                        `[data-year="${capturedYkey}"][data-month="${capturedMkey}"]`
                    );
                    if (target) doScrollTo(target);
                };
            })(mkey, ykey);
        }

        ;(function(capturedYkey) {
            yearHead.onclick = function() {
                var target = document.querySelector(`[data-year="${capturedYkey}"]`);
                if (target) doScrollTo(target);
            };
        })(ykey);

        yearEl.appendChild(monthsEl);
        sidebar.appendChild(yearEl);
    }
}

// -- scroll tracking --
function getMostVisible(els) {
    var viewportHeight = window.innerHeight;
    var best = null;
    var bestTop = Infinity;

    for (var el of Array.from(els)) {
        var rect = el.getBoundingClientRect();
        var top = rect.top - 60;
        var threshold = 0 - (el.offsetHeight - viewportHeight / 3);
        if (top < bestTop && top > threshold) {
            best = el;
            bestTop = top;
        }
    }
    return best;
}

function calcVisible() {
    var visible = getMostVisible(document.querySelectorAll(".gallery-card"));
    if (!visible) return;

    var visYear = visible.getAttribute("data-year");
    var visMonth = visible.getAttribute("data-month");

    var activeYear = document.querySelector(".gsb-year-active");
    var activeMonth = document.querySelector(".gsb-month-active");

    if (activeYear && activeYear.getAttribute("data-sidebar-year") !== visYear) {
        activeYear.classList.remove("gsb-year-active");
    }
    if (activeMonth && activeMonth.getAttribute("data-sidebar-month") !== visMonth) {
        activeMonth.classList.remove("gsb-month-active");
    }

    var yearEl = document.querySelector(`[data-sidebar-year="${visYear}"]`);
    if (yearEl) yearEl.classList.add("gsb-year-active");

    var monthEl = yearEl
        ? yearEl.querySelector(`[data-sidebar-month="${visMonth}"]`)
        : null;
    if (monthEl) {
        monthEl.classList.add("gsb-month-active");
        sidebar.scrollTo({ top: monthEl.offsetTop - sidebar.clientHeight / 2, behavior: "smooth" });
    }
}

document.addEventListener("scroll", calcVisible);

// -- init --
renderGrid();
generateSidebar();

new LazyLoad();