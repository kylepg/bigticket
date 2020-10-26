//
// ─── IMPORTS ────────────────────────────────────────────────────────────────────
//

import 'babel-polyfill';
import Flickity from 'flickity';
import dayjs from 'dayjs';
import mdtable2json from 'mdtable2json';

//
// ─── VARIABLES ──────────────────────────────────────────────────────────────────
//

/* global _nba */
const attendeesList = [];
let pics = null;

const flktyOptions = {
  cellAlign: `left`,
  contain: true,
  // groupCells: 2,
  draggable: true,
};

const url = window.location.href;
let apiRoot = `https://content.celticsdigital.com`;
// For local development....
if (
  url.includes(`localhost`)
    || url.includes(`.loc`)
    || url.includes(`127.0.0.1`)
) {
  apiRoot = `http://content.celticsdigital.loc`;
}

//
// ─── HTML ───────────────────────────────────────────────────────────────────────
//

const activitesHTML = (activities) => activities.reduce(
  (acc, a) => `
  ${acc}<p class="entry">
      <span>${a.Title.toUpperCase()}</span> ${a[`Line 1`]} <span>${
  a[`Line 2`]
}</span>
  </p>`,
  ``,
);

const dayHTML = (activities) => `
  <div class="day">
    <p class="date">${dayjs(activities[0].Date).format(`ddd M/D`)}</p>
      ${activitesHTML(activities)}
  </div>
`;

//
// ─── HELPERS ────────────────────────────────────────────────────────────────────
//

function deleteCookie(name) {
  document.cookie = `${name}=; path=/;domain=.nba.com; expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
}

function getCookie(name) {
  const dc = document.cookie;
  const prefix = `${name}=`;
  let begin = dc.indexOf(`; ${prefix}`);
  let end = ``;
  if (begin === -1) {
    begin = dc.indexOf(prefix);
    if (begin !== 0) return null;
  } else {
    begin += 2;
    end = document.cookie.indexOf(`;`, begin);
    if (end === -1) {
      end = dc.length;
    }
  }
  const result = decodeURI(dc.substring(begin + prefix.length, end));
  return result === `undefined` ? null : result;
}

function htmlEntities(str) {
  return String(str)
    .replace(/##/g, ``)
    .replace(/ ~~/g, ` <strike>`)
    .replace(/~~ /g, ` </strike>`)
    .replace(/ \*\*/g, ` <strong>`)
    .replace(/\*\* /g, `</> `)
    .replace(/ \*/g, ` <em>`)
    .replace(/\* /g, `</em> `)
    .replace(/&/g, `&amp;`)
    .replace(/</g, `&lt;`)
    .replace(/>/g, `&gt;`)
    .replace(/"/g, `&quot;`);
}

/* eslint-disable */
function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
/* eslint-enable */

//
// ─── FUNCTIONS ──────────────────────────────────────────────────────────────────
//

function changeVideo(videoId) {
  const videoHTML = `<div id="video-player" data-team="celtics" data-videoId="/video/${videoId}" data-cvp data-cvp-autostart="TRUE"></div>`;
  jQuery(`#video-overlay .video-wrap`).html(videoHTML);
  if (_nba && _nba.scout) {
    _nba.scout.call(document.getElementById(`video-player`));
    // const v = document.querySelector(`video`);
    // v.textTracks[0].mode = `hidden`;
  }
}

function disableCaptions() {
  const observerConfig = {
    childList: true,
    subtree: true,
  };
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        const nbaCvpPlayer = node.querySelector(`.nbaCvpPlayer`);
        if (nbaCvpPlayer !== null) {
          const childObserver = new MutationObserver(
            (childMutations) => {
              childMutations.forEach((childMutation) => {
                childMutation.addedNodes.forEach((childNode) => {
                  if (childNode.tagName === `VIDEO`) {
                    childNode.textTracks.addEventListener(
                      `addtrack`,
                      () => {
                        childNode.textTracks[0].mode = `hidden`;
                      },
                    );
                  }
                });
              });
            },
          );
          childObserver.observe(node, observerConfig);
        }
      });
    });
  });
  const targetNode = document.querySelector(`.video-wrap`);
  observer.observe(targetNode, observerConfig);
}

function checkRegistration(email) {
  // Check for new registrations...
  const match = attendeesList.filter(
    (a) => a[`Email Address`].toLowerCase() == email.toLowerCase(),
  );
  if (match.length > 0) {
    // ! RELOAD CONTENT, UNGATED ! //
    document.cookie = `celtics-career-center-registered=${match[0][`First Name`]};path=/;domain=.nba.com;`;
    document.cookie = `celtics-career-center-registered=${match[0][`First Name`]};path=/;domain=127.0.0.1:3434;`;
    location.reload();
    $(`#login-overlay .success`).show();
    $(`#login-overlay .submit-button`).hide();
  } else {
    $(`.error-message`).show();
  }
}

//
// ─── DOCUMENT READY ─────────────────────────────────────────────────────────────
//

$(async () => {
  const fn = getCookie(`celtics-career-center-registered`);
  $(`.registrant-name .name`).html(fn);
  if (
    getCookie(`celtics-career-center-registered`) !== null
        || window.location.href.includes(`unlock`)
  ) {
    console.log(`User logged in.`);
    console.log(getCookie(`celtics-career-center-registered`));
    $(`#career-center`).attr(`data-logged-in`, true);
  } else {
    console.log(`User not logged in.`);
    $(`#career-center`).attr(`data-logged-in`, false);
  }
  const carousel = document.querySelectorAll(`.carousel`);
  carousel.forEach((el) => {
    pics = new Flickity(el, flktyOptions);
  });

  const md = await fetch(
    `${apiRoot}/api/dropbox/paper/markdown/0znfVeEleZInv1UFL7ZCn`,
  )
    .then((res) => res.json())
    .then((res) => {
      if (res.status === `success`) {
        return res.content;
      }
      return res.status;
    });
  const table = `|${htmlEntities(md.substring(md.indexOf(`|`) + 1))}`;
  const mdJSON = mdtable2json.getTables(table);
  mdJSON[0].json.forEach((a) => {
    if (a[`Email Address`] !== ``) {
      attendeesList.push(a);
    }
  });
  disableCaptions();
  // Init flickity on first profile...
});

//
// ─── INTERACTIONS ───────────────────────────────────────────────────────────────
//

$(document).on(`click`, `#login-overlay .submit-button`, () => {
  $(`.error-message, .valid-message`).hide();
  const email = $(`#login-overlay input`).val();
  if (validateEmail(email)) {
    checkRegistration(email);
  } else {
    $(`.valid-message`).show();
  }
});

/* ---------------------------------- LOGIN --------------------------------- */

$(document).on(`click`, `.login-button`, () => {
  jQuery(`.overlay`).removeClass(`fade-in active`);
  $(`#login-overlay`).addClass(`active`);
  setTimeout(() => {
    $(`#login-overlay`).addClass(`fade-in`);
  }, 10);
});

$(document).on(`click`, `.logout-button`, () => {
  deleteCookie(`celtics-career-center-registered`);
  location.reload();
});

/* ------------------------------ KEY TAKEAWAYS ----------------------------- */

$(document).on(`click`, `.key-takeaways`, function() {
  jQuery(`.overlay`).removeClass(`fade-in active`);
  $(`#key-takeaway-overlay img`).addClass(`hidden`);
  $(`#key-takeaway-overlay`).addClass(`active`);
  const name = $(this).closest(`.card`).attr(`data-name`);
  console.log(name);
  $(`#key-takeaway-overlay img[data-name="${name}"]`).removeClass(`hidden`);
  $(`#key-takeaway-overlay a`).attr(`href`, `https://www.nba.com/resources/static/team/v2/celtics/cdn/team/career-center/images/key-takeaways_${name}.jpg`);
  setTimeout(() => {
    $(`#key-takeaway-overlay`).addClass(`fade-in`);
  }, 10);
});

/* ------------------------------ CLOSE OVERLAY ----------------------------- */

$(document).on(
  `click`,
  `.overlay .shade, .overlay .close-button`,
  () => {
    jQuery(`.overlay`).removeClass(`fade-in active`);
    jQuery(`#video-overlay .video-wrap`).html(``);
    $(`.overlay`).removeClass(`fade-in`);
    setTimeout(() => {
      $(`.overlay`).removeClass(`active`);
    }, 310);
  },
);

/* ---------------------------------- VIDEO --------------------------------- */

$(document).on(`click`, `[data-carousel="webinars"] .card-inner, [data-carousel="live-speaker-panels"] .card-inner`, function(e) {
  if (!$(e.target).hasClass(`key-takeaways`) && $(this).closest(`.card`).attr(`data-videoId`) != `null`) {
    $(`#video-overlay`).addClass(`active`);
    setTimeout(() => {
      $(`#video-overlay`).addClass(`fade-in`);
    }, 10);
    const videoId = $(this).closest(`.card`).attr(`data-videoId`);
    const title = $(this).closest(`.card`).attr(`data-title`);
    $(`#video-overlay .title`).html(`Webinar: ${title}`);
    changeVideo(videoId);
    if (!window.matchMedia(`only screen and (max-width: 760px)`).matches) {
      console.log();
    } else {
      $(`.green-shading`, this).addClass(`loading`);
      setTimeout(() => {
        $(`.green-shading`, this).removeClass(`loading`);
      }, 3000);
    }
  }
});
