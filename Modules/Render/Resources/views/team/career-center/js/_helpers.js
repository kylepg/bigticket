export async function multiFetch(endpoints) {
  const promises = [];
  endpoints.forEach((endpoint) => {
    let url = endpoint.live;
    if (window.location.href.includes(`localhost`) || url.includes(`.loc`) || url.includes(`10.10.226`)) {
      url = endpoint.local;
    }
    promises.push(fetch(url).then(res => res.json()).catch(() => {
      if (endpoint.fallback !== undefined) {
        return fetch(endpoint.fallback).then(res => res.json());
      }
      console.error(`No fallback defined for ${url}. Returning blank JSON.`);
      return {};
    }));
  });
  const returnObj = {};
  await Promise.all(promises).then((data) => {
    data.forEach((d, i) => {
      returnObj[endpoints[i].name] = d;
    });
  });
  return returnObj;
}

export function updateQueryString(key, value, url) {
  if (!url) url = window.location.href;
  const re = new RegExp(`([?&])${key}=.*?(&|#|$)(.*)`, `gi`);
  let hash;

  if (re.test(url)) {
    if (typeof value !== `undefined` && value !== null) {
      return url.replace(re, `$1${key}=${value}$2$3`);
    }
    hash = url.split(`#`);
    url = hash[0].replace(re, `$1$3`).replace(/(&|\?)$/, ``);
    if (typeof hash[1] !== `undefined` && hash[1] !== null) {
      url += `#${hash[1]}`;
    }
    return url;
  }
  if (typeof value !== `undefined` && value !== null) {
    const separator = url.indexOf(`?`) !== -1 ? `&` : `?`;
    hash = url.split(`#`);
    url = `${hash[0] + separator + key}=${value}`;
    if (typeof hash[1] !== `undefined` && hash[1] !== null) {
      url += `#${hash[1]}`;
    }
    return url;
  }
  return url;
}


export default () => {};

