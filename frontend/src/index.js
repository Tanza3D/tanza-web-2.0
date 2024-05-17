import {createLazyLoadInstance} from "./js/utils/lazyload";

window.loader = createLazyLoadInstance();

import './style.css'
export * from './js/ui/overlay.js';
export * from './js/ui/toasts.js';
export * from './js/ui/otabs.js';
export * from "./js/utils/array.js";

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'


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
    };
    callback();
    var observer = new MutationObserver(callback);
    observer.observe(targetNode, config);

    window.loader.update();
})

