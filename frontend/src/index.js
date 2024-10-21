import {createLazyLoadInstance} from "./js/utils/lazyload";

window.loader = createLazyLoadInstance();

import './style.css'
export * from './js/ui/overlay.js';
export * from './js/ui/toasts.js';
export * from './js/ui/otabs.js';
export * from "./js/utils/array.js";

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'


// TODO: sort through music services. we don't need them
import {
    siDiscord,
    siBeatport,
    siBandcamp,
    siLastdotfm,
    siYoutube,
    siBluesky,
    siInstagram,
    siPatreon,
    siTwitch,
    siGithub,
    siOsu,
    siLinkedin
} from 'simple-icons';

const icons = {
    siDiscord,
    siBeatport,
    siBandcamp,
    siLastdotfm,
    siYoutube,
    siBluesky,
    siInstagram,
    siPatreon,
    siTwitch,
    siGithub,
    siOsu,
    siLinkedin
};

document.addEventListener("DOMContentLoaded", () => {
    var targetNode = document.body;
    var config = {
        childList: true, subtree: true
    };
    var callback = function (mutationsList) {
        for (var element of document.querySelectorAll("[tooltip]")) {
            var text = element.getAttribute("tooltip");
            tippy(element, {
                content: text
            });
            element.removeAttribute("tooltip");
        }


        const elements = document.querySelectorAll("[icon]");

        elements.forEach(element => {
            const iconName = element.getAttribute("icon");

            var icon = Object.keys(icons).find(key => key.toLowerCase() === ("si" + iconName).toLowerCase());
            var custom = false;

            if (icon) {
                const svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                console.log(icons[icon]);
                svgElement.innerHTML = icons[icon].svg;
                element.replaceWith(svgElement);
            } else {
                console.log(`Icon '${iconName}' not found`);
            }
        });
    };
    callback();
    var observer = new MutationObserver(callback);
    observer.observe(targetNode, config);

    window.loader.update();
})

