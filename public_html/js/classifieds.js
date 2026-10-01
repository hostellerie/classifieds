(function () {
    'use strict';

    var links = document.querySelectorAll('[data-classifieds-lightbox]');
    if (!links.length) {
        return;
    }

    var overlay = document.createElement('div');
    overlay.className = 'classifieds-lightbox-overlay';
    overlay.hidden = true;
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.innerHTML =
        '<figure class="classifieds-lightbox-overlay__figure">' +
        '<img class="classifieds-lightbox-overlay__image" alt="">' +
        '<button class="classifieds-lightbox-overlay__close" type="button" aria-label="Close">×</button>' +
        '</figure>';

    document.body.appendChild(overlay);

    var image = overlay.querySelector('.classifieds-lightbox-overlay__image');
    var closeButton = overlay.querySelector('.classifieds-lightbox-overlay__close');
    var previousFocus = null;

    function closeViewer() {
        overlay.hidden = true;
        document.body.classList.remove('classifieds-lightbox-open');
        image.removeAttribute('src');
        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    function openViewer(link) {
        var thumb = link.querySelector('img');
        previousFocus = document.activeElement;
        image.src = link.href;
        image.alt = thumb ? thumb.alt : '';
        overlay.hidden = false;
        document.body.classList.add('classifieds-lightbox-open');
        closeButton.focus();
    }

    Array.prototype.forEach.call(links, function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            openViewer(link);
        });
    });

    closeButton.addEventListener('click', closeViewer);

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            closeViewer();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!overlay.hidden && event.key === 'Escape') {
            closeViewer();
        }
    });
}());
