(function () {
  function initPopup(wrapper) {
    var openButton = wrapper.querySelector('[data-dt-ss-popup-open]');
    var overlay = wrapper.querySelector('[data-dt-ss-popup-overlay]');
    var closeButton = wrapper.querySelector('[data-dt-ss-popup-close]');
    var modal = wrapper.querySelector('.dt-ss-popup-modal');

    if (!openButton || !overlay || !closeButton || !modal) {
      return;
    }

    function openPopup() {
      overlay.hidden = false;
      document.body.style.overflow = 'hidden';
    }

    function closePopup() {
      overlay.hidden = true;
      document.body.style.overflow = '';
    }

    openButton.addEventListener('click', openPopup);
    closeButton.addEventListener('click', closePopup);

    overlay.addEventListener('click', function (event) {
      if (event.target === overlay) {
        closePopup();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !overlay.hidden) {
        closePopup();
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var wrappers = document.querySelectorAll('.dt-ss-popup-wrap');
    wrappers.forEach(initPopup);
  });
})();
