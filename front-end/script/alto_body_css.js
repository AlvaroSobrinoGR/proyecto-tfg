window.addEventListener('DOMContentLoaded', setMinHeight);
window.addEventListener('resize', setMinHeight);

function setMinHeight() {
  const windowHeight = window.innerHeight;
  document.body.style.minHeight = windowHeight + 'px';
}