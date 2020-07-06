document.addEventListener('DOMContentLoaded', () => {

    const metaBoxHead = document.querySelector("#heading_shift_meta");
    const styleValues = ["single_template_3","single_template_7","single_template_8"];

    const inputHidden = document.querySelector('input[name="td_post_theme_settings[td_post_template]"]');
    const metaHeadInit = () => {
        metaBoxHead.classList.remove("hide-if-js");
        (styleValues.includes(inputHidden.value)) ? metaBoxHead.style.display = "block" : metaBoxHead.style.display = "none";
    }
    metaHeadInit();

    const metaHeadLoop = (item) => {
        item.addEventListener("click", () => {
            let x = item.getAttribute('data-option-value');
            (styleValues.includes(x)) ? metaBoxHead.style.display = "block" : metaBoxHead.style.display = "none";
        });
    }

    let elem = document.querySelectorAll('.td-visual-selector-o > a > img');
    elem.forEach(metaHeadLoop);

})
