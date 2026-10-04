import {D2} from "../utils/d2";
import {DoRequest} from "../utils/requests";
import "../../css/views/characters.css"
class Characters {
    currentPanel;
    outer;

    data;
    characters = []; // quick reference for assets
    preloaded = [];
    keys = []; // character order, for swiping and arrows
    counter;
    LoadPanel(key, direction = 1) {
        if(this.currentPanel && this.currentPanel.getAttribute("character") === key) return;

        let oldPanel = this.currentPanel;
        let imgs = [];
        let newPanel = D2.Div("character-panel character-" + key, () => {
            D2.Div("background", () => {
                D2.Image("t2-bg", `/public/chars/${key}/bg.png`);
                imgs["bg-overlay"] = D2.Image("t2-bg-overlay", `/public/chars/${key}/bg_overlay.png`);
                D2.Div("char", () => {
                    imgs["char-bg-lower"] = D2.Image("t2-char-bg-lower", `/public/chars/${key}/char_bg_lower.png`);
                    imgs["char-bg-higher"] = D2.Image("t2-char-bg-higher", `/public/chars/${key}/char_bg_higher.png`);
                    imgs["char-img-lower"] = D2.Image("t2-char-img-lower", `/public/chars/${key}/char_img_lower.png`);
                    imgs["char-img-higher"] = D2.Image("t2-char-img-higher", `/public/chars/${key}/char_img_higher.png`);
                })
            });
            D2.Div("char-content", () => {
                D2.Div("char-content-logo", () => {
                    imgs["logo"] = D2.Image("t2-char-logo", `/public/chars/${key}/logo.svg`);
                    imgs["pronouns"] = D2.Text("h4", this.characters[key].species + " · " + this.characters[key].pronouns);
                })
                imgs["content"] = D2.Div("char-content-inner", () => {
                    D2.Text("h1", "test");
                })
            })
        }); // PUT CONTENT HERE
        newPanel.setAttribute("character", key);
        this.currentPanel = newPanel;
        this.outer.appendChild(newPanel);

        newPanel.style.setProperty("--mobile-offset", this.characters[key].mobile_offset ? this.characters[key].mobile_offset : "0px");

        let settle = "cubic-bezier(0.16, 1, 0.3, 1)";

        imgs["bg-overlay"].animate({ opacity: [0, 1] }, { duration: 500, easing: "ease-out", fill: "both", delay: 500 });

// icons: big slow drift down from far away
        imgs["char-bg-lower"].animate({
            scale: [1.4, 1],
            opacity: [0, 1],
            filter: ["blur(12px)", "blur(0px)"]
        }, { duration: 1600, easing: settle, fill: "both", delay: 400 });

// cherry blossom: zooms in with a little sideways drift
        imgs["char-bg-higher"].animate({
            scale: [1.25, 1],
            translate: ["60px 0", "0 0"],
            opacity: [0, 1]
        }, { duration: 1400, easing: settle, fill: "both", delay: 600 });

// ink stroke: painted on left to right like a brush
        imgs["char-img-lower"].animate({
            maskPosition: ["100% 0", "0% 0"],
            scale: [1.1, 1]
        }, { duration: 1100, easing: "cubic-bezier(0.65, 0, 0.35, 1)", fill: "both", delay: 800 });

// character: last in, pops forward out of focus
        imgs["char-img-higher"].animate({
            scale: [1.12, 1],
            translate: ["80px 0", "0 0"],
            opacity: [0, 1],
            filter: ["blur(8px)", "blur(0px)"]
        }, { duration: 1200, easing: settle, fill: "both", delay: 1000 });

        imgs["logo"].animate({
            maskPosition: ["100% 0", "0% 0"],
            scale: [1.1, 1]
        }, { duration: 2400, easing: "cubic-bezier(0.65, 0, 0.35, 1)", fill: "both", delay: 700 });
        imgs["pronouns"].animate({
            transform: ["translateY(50px)", "translateY(0)"],
            opacity: [0, 1],
            filter: ["blur(12px)", "blur(0px)"]
        }, { duration: 2000, easing: settle, fill: "both", delay: 2000 });
        imgs["content"].animate({
            transform: ["translateY(50px)", "translateY(0)"],
            opacity: [0, 1],
            filter: ["blur(12px)", "blur(0px)"]
        }, { duration: 3000, easing: settle, fill: "both", delay: 2500 });

        // new character starts from the top, not wherever the last one was scrolled to
        //this.outer.scrollTop = 0;
        this.outer.scrollTo({ top: 0, behavior: "smooth" });
        this.ShowPanel(newPanel, direction);

        if(oldPanel) {
            this.HidePanel(oldPanel, direction);
        }

        if(this.counter) {
            this.counter.textContent = (this.keys.indexOf(key) + 1) + " / " + this.keys.length;
        }

        for(let el of document.querySelectorAll("[character]")) {
            if(el.getAttribute("character") === key) {
                el.classList.add("active");
            } else {
                el.classList.remove("active");
            }
        }
    }
    Step(amount) {
        let index = this.keys.indexOf(this.currentPanel.getAttribute("character"));
        let next = index + amount;
        // wrap around at either end
        if(next < 0) {
            next = this.keys.length - 1;
        }
        if(next >= this.keys.length) {
            next = 0;
        }
        this.LoadPanel(this.keys[next], amount);
    }
    BuildMobileControls() {
        let controls = D2.Div("mobile-controls", () => {
            D2.Div("mobile-pages", () => {
                let prev = D2.Text("button", "‹", "mobile-prev");
                prev.addEventListener("click", () => {
                    this.Step(-1);
                });

                this.counter = D2.Text("span", "", "mobile-counter");

                let next = D2.Text("button", "›", "mobile-next");
                next.addEventListener("click", () => {
                    this.Step(1);
                });
            });

            let grid = D2.Text("button", "", "mobile-grid");
            grid.innerHTML = `<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/><rect x="3" y="13" width="8" height="8" rx="2"/><rect x="13" y="13" width="8" height="8" rx="2"/></svg>`;
            grid.addEventListener("click", () => {
                this.selector.classList.toggle("open");
            });
        });
        this.selector.after(controls);

        // tapping the dark area around the grid closes it
        this.selector.addEventListener("click", (e) => {
            if(e.target === this.selector) {
                this.selector.classList.remove("open");
            }
        });

        // swipe on the panel area
        let startX = 0;
        let startY = 0;
        this.outer.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        }, { passive: true });
        this.outer.addEventListener("touchend", (e) => {
            let dx = e.changedTouches[0].clientX - startX;
            let dy = e.changedTouches[0].clientY - startY;
            // only count it if it's mostly sideways and far enough
            if(Math.abs(dx) < 50 || Math.abs(dx) < Math.abs(dy)) return;
            if(dx < 0) {
                this.Step(1);
            } else {
                this.Step(-1);
            }
        });
    }
    ShowPanel(panel, direction = 1) {
        panel.animate({ scale: [0.6, 1] }, { duration: 1000, easing: "cubic-bezier(0.42, 1, 0.36, 1)", fill: "both" });
        panel.animate({ transform: [`translateX(${600 * direction}px)`, "translateX(0)"] }, { duration: 1000, easing: "cubic-bezier(0.65, 0, 0.35, 1)", fill: "both" });
        panel.animate({ opacity: [0, 1] }, { duration: 400, easing: "ease-out", fill: "both" });
    }
    HidePanel(panel, direction = 1) {
        // freeze wherever it currently is, so nothing snaps
        for(let anim of panel.getAnimations()) {
            anim.commitStyles();
            anim.cancel();
        }

        // only end values, so each one starts from the frozen spot
        let scale = panel.animate({ scale: 0.8 }, { duration: 1100, easing: "cubic-bezier(0.22, 1, 0.36, 1)", fill: "forwards" });
        let slide = panel.animate({ transform: `translateX(${-900 * direction}px)` }, { duration: 1000, easing: "cubic-bezier(0.65, 0, 0.35, 1)", fill: "forwards" });
        let fade = panel.animate({ opacity: 0 }, { duration: 800, easing: "ease-in", fill: "forwards" });

        Promise.all([scale.finished, slide.finished, fade.finished]).then(() => {
            panel.remove();
        });
    }
    async PreloadImages() {
        let files = ["bg.png", "bg_overlay.png", "char_bg_lower.png", "char_bg_higher.png", "char_img_lower.png", "char_img_higher.png", "logo.svg"];
        let loads = [];

        for(let key in this.characters) {
            for(let file of files) {
                let img = new Image();
                // keep a reference so the browser holds onto the loaded copy
                this.preloaded.push(img);

                let load = new Promise((resolve) => {
                    img.onload = () => {
                        img.decode().then(resolve, resolve);
                    };
                    // missing files just get skipped
                    img.onerror = resolve;
                });
                img.src = `/public/chars/${key}/${file}`;
                loads.push(load);
            }
        }

        await Promise.all(loads);

        // TEMP: fake delay for testing the loading display, remove later
        await new Promise(resolve => setTimeout(resolve, 1));
    }
    async Init() {
        this.outer = document.getElementById("main");
        this.selector = document.getElementById("selector");
        this.data = await DoRequest("GET", "/public/chars/chara.json");
        console.log(this.data);
        let style = "";
        for(let universe of this.data) {
            console.log(universe);
            for(let character in universe.characters) {
                console.log(universe.characters[character]);
                this.characters[character] = universe.characters[character];
                this.keys.push(character);

                style += `.character-${character} {`
                for(let key in universe.characters[character].display) {
                    style += `.${key} {`
                    for(let styleKey in universe.characters[character].display[key]) {
                        style += `${styleKey}: ${universe.characters[character].display[key][styleKey]} !important;`
                    }
                    style += `}`;
                }
                style += `}`;
            }

            this.selector.appendChild(D2.Div("universe", () => {
                for(let character in universe.characters) {
                    let button = D2.Div("character", () => {
                        D2.Image("char-bg", `/public/chars/${character}/bg.png`);
                        D2.Image("char-img", `/public/chars/${character}/char_img_higher.png`);
                    })
                    button.setAttribute("tooltip", universe.characters[character].name);
                    button.addEventListener("click", () => {
                        this.LoadPanel(character);
                        this.selector.classList.remove("open");
                    })
                    button.setAttribute("character", character);
                }
            }));

        }
        let styleEl = document.createElement("style");
        styleEl.textContent = style;
        document.head.appendChild(styleEl);
        this.BuildMobileControls();
        await this.PreloadImages();
        document.getElementById("character-page").classList.add("loaded");
        this.LoadPanel("tanza");

        let targetX = 0;
        let targetY = 0;
        let parallaxX = 0;
        let parallaxY = 0;

        document.addEventListener("mousemove", (e) => {
            targetX = (e.clientX / window.innerWidth) * 2 - 1;
            targetY = (e.clientY / window.innerHeight) * 2 - 1;
        });

        function UpdateParallax() {
            // move 8% of the remaining distance each frame, so it eases in
            parallaxX += (targetX - parallaxX) * 0.08;
            parallaxY += (targetY - parallaxY) * 0.08;

            document.documentElement.style.setProperty("--parallax-x", parallaxX);
            document.documentElement.style.setProperty("--parallax-y", parallaxY);

            requestAnimationFrame(UpdateParallax);
        }
        UpdateParallax();
    }
}

let characters = new Characters();
characters.Init();