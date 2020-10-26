document.addEventListener(`DOMContentLoaded`, () => {
  [].forEach.call(document.querySelectorAll(`img[data-src]`), (img) => {
    const isMobile = window.matchMedia(`only screen and (max-width: 760px)`).matches;
    if (isMobile) {
      if (!img.hasAttribute(`data-desktop`)) {
        img.setAttribute(`src`, img.getAttribute(`data-src`));
      }
    } else {
      img.setAttribute(`src`, img.getAttribute(`data-src`));
    }
    img.onload = function() {
      img.removeAttribute(`data-src`);
    };
  });
  window.addEventListener(`resize`, () => {
    const isMobile = window.matchMedia(`only screen and (max-width: 760px)`).matches;
    [].forEach.call(document.querySelectorAll(`img:not([src])`), (img) => {
      if (isMobile) {
        if (img.hasAttribute(`data-mobile`)) {
          img.setAttribute(`src`, img.getAttribute(`data-src`));
        }
      } else if (img.hasAttribute(`data-desktop`)) {
        img.setAttribute(`src`, img.getAttribute(`data-src`));
      }
    });
  });
});

