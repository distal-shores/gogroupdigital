
const ready = function (callback) {
document.readyState === "loading"
  ? document.addEventListener("DOMContentLoaded", function(e) { callback(); })
  : callback();
};

ready(function() {
  const key = 'accepted-cookies';
  const acceptedCookies = localStorage.getItem(key);
  if (!acceptedCookies) {
    const cookieBanner = document.getElementById('cookie-policy');
    cookieBanner.style.display = 'block';

    const acceptCookiesButton = document.getElementById('accept-cookies-button');
    acceptCookiesButton.onclick = function(e) {
      localStorage.setItem(key, '1');
      delete acceptCookiesButton.onclick;
      cookieBanner.style.display = 'none';
    };
  }
});
