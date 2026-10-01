(function () {
    'use strict';

    var links = document.querySelectorAll('[data-classifieds-lightbox]');

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

    if (links.length) {
        document.body.appendChild(overlay);
    }

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

    if (links.length) {
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
    }

    var upload = document.querySelector('[data-classifieds-image-upload]');
    if (upload) {
        var input = upload.querySelector('.classifieds-image-upload__input');
        var preview = upload.querySelector('[data-classifieds-image-preview]');
        var maxFiles = parseInt(upload.getAttribute('data-max-files'), 10) || 0;

        if (input && preview) {
            input.addEventListener('change', function () {
                preview.innerHTML = '';

                var files = Array.prototype.slice.call(input.files || []);
                if (maxFiles > 0 && files.length > maxFiles) {
                    files = files.slice(0, maxFiles);

                    if (typeof DataTransfer !== 'undefined') {
                        var transfer = new DataTransfer();
                        files.forEach(function (file) {
                            transfer.items.add(file);
                        });
                        input.files = transfer.files;
                    }
                }

                files.forEach(function (file) {
                    if (!/^image\//.test(file.type)) {
                        return;
                    }

                    var card = document.createElement('div');
                    card.className = 'classifieds-image-upload__preview-item';

                    var image = document.createElement('img');
                    image.className = 'classifieds-image-upload__preview-image';
                    image.alt = '';
                    image.src = URL.createObjectURL(file);
                    image.addEventListener('load', function () {
                        URL.revokeObjectURL(image.src);
                    });

                    var name = document.createElement('span');
                    name.className = 'classifieds-image-upload__preview-name';
                    name.textContent = file.name;

                    card.appendChild(image);
                    card.appendChild(name);
                    preview.appendChild(card);
                });
            });
        }
    }
}());
