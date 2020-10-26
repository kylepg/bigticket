//
// ─── IMPORTS ────────────────────────────────────────────────────────────────────
//

import 'babel-polyfill';
import mdtable2json from 'mdtable2json';

//
// ─── VARIABLES ──────────────────────────────────────────────────────────────────
//

/* global _nba */
const attendeesList = [];

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
// ─── HELPERS ────────────────────────────────────────────────────────────────────
//

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
    $(`#login .success`).show();
    $(`#login .submit-button`).hide();
  } else {
    $(`.error-message`).show();
  }
}

//
// ─── DOCUMENT READY ─────────────────────────────────────────────────────────────
//

$(async () => {
  const fn = getCookie(`celtics-career-center-registered`);
  if (
    getCookie(`celtics-career-center-registered`) !== null
        || window.location.href.includes(`unlock`)
  ) {
    console.log(`User logged in.`);
    console.log(getCookie(`celtics-career-center-registered`));
    $(`#blog-wrap`).attr(`data-logged-in`, true);
  } else {
    $(`#blog-wrap`).attr(`data-logged-in`, false);
    console.log(`User not logged in.`);
  }
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
  // Init flickity on first profile...
});

//
// ─── INTERACTIONS ───────────────────────────────────────────────────────────────
//

$(document).on(`click`, `#login .submit-button`, () => {
  $(`.error-message, .valid-message`).hide();
  const email = $(`#login input`).val();
  if (validateEmail(email)) {
    checkRegistration(email);
  } else {
    $(`.valid-message`).show();
  }
});
