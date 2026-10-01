(function () {
    'use strict';

    var links = Array.prototype.slice.call(
        document.querySelectorAll('[data-classifieds-lightbox]')
    );
    var launcher = document.querySelector('[data-classifieds-lightbox-open]');
    var items = [];
    var seen = {};

    links.forEach(function (link) {
        var href = link.href;
        if (!href || seen[href]) {
            return;
        }

        seen[href] = true;
        items.push({
            href: href,
            alt: (link.querySelector('img') || {}).alt || ''
        });
    });

    var overlay = document.createElement('div');
    overlay.className = 'classifieds-lightbox-overlay';
    overlay.hidden = true;
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.innerHTML =
        '<figure class="classifieds-lightbox-overlay__figure">' +
        '<img class="classifieds-lightbox-overlay__image" alt="">' +
        '<button class="classifieds-lightbox-overlay__previous" type="button">‹</button>' +
        '<button class="classifieds-lightbox-overlay__next" type="button">›</button>' +
        '<span class="classifieds-lightbox-overlay__counter" aria-live="polite"></span>' +
        '<button class="classifieds-lightbox-overlay__close" type="button">×</button>' +
        '</figure>';

    if (items.length) {
        document.body.appendChild(overlay);
    }

    var image = overlay.querySelector('.classifieds-lightbox-overlay__image');
    var closeButton = overlay.querySelector('.classifieds-lightbox-overlay__close');
    var previousButton = overlay.querySelector('.classifieds-lightbox-overlay__previous');
    var nextButton = overlay.querySelector('.classifieds-lightbox-overlay__next');
    var counter = overlay.querySelector('.classifieds-lightbox-overlay__counter');
    var previousFocus = null;
    var currentIndex = 0;
    var touchStartX = null;

    function setControlLabels() {
        var source = launcher || links[0];
        var closeLabel = source && source.getAttribute('data-lightbox-close-label');
        var previousLabel = source && source.getAttribute('data-lightbox-previous-label');
        var nextLabel = source && source.getAttribute('data-lightbox-next-label');

        closeButton.setAttribute('aria-label', closeLabel || 'Close');
        previousButton.setAttribute('aria-label', previousLabel || 'Previous image');
        nextButton.setAttribute('aria-label', nextLabel || 'Next image');
    }

    function showImage(index) {
        if (!items.length) {
            return;
        }

        currentIndex = (index + items.length) % items.length;
        image.src = items[currentIndex].href;
        image.alt = items[currentIndex].alt;
        counter.textContent = (currentIndex + 1) + ' / ' + items.length;

        var multiple = items.length > 1;
        previousButton.hidden = !multiple;
        nextButton.hidden = !multiple;
        counter.hidden = !multiple;
    }

    function closeViewer() {
        overlay.hidden = true;
        document.body.classList.remove('classifieds-lightbox-open');
        image.removeAttribute('src');
        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    function openViewer(index) {
        previousFocus = document.activeElement;
        setControlLabels();
        showImage(index);
        overlay.hidden = false;
        document.body.classList.add('classifieds-lightbox-open');
        closeButton.focus();
    }

    if (items.length) {
        links.forEach(function (link) {
            link.addEventListener('click', function (event) {
                var index = 0;
                var href = link.href;

                items.some(function (item, itemIndex) {
                    if (item.href === href) {
                        index = itemIndex;
                        return true;
                    }
                    return false;
                });

                event.preventDefault();
                openViewer(index);
            });
        });

        if (launcher) {
            launcher.addEventListener('click', function () {
                openViewer(0);
            });
        }

        closeButton.addEventListener('click', closeViewer);
        previousButton.addEventListener('click', function () {
            showImage(currentIndex - 1);
        });
        nextButton.addEventListener('click', function () {
            showImage(currentIndex + 1);
        });

        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeViewer();
            }
        });

        overlay.addEventListener('touchstart', function (event) {
            if (event.touches.length === 1) {
                touchStartX = event.touches[0].clientX;
            }
        }, {passive: true});

        overlay.addEventListener('touchend', function (event) {
            if (touchStartX === null || !event.changedTouches.length) {
                return;
            }

            var delta = event.changedTouches[0].clientX - touchStartX;
            touchStartX = null;

            if (Math.abs(delta) < 50 || items.length < 2) {
                return;
            }

            showImage(currentIndex + (delta < 0 ? 1 : -1));
        }, {passive: true});

        document.addEventListener('keydown', function (event) {
            if (overlay.hidden) {
                return;
            }

            if (event.key === 'Escape') {
                closeViewer();
            } else if (event.key === 'ArrowLeft' && items.length > 1) {
                showImage(currentIndex - 1);
            } else if (event.key === 'ArrowRight' && items.length > 1) {
                showImage(currentIndex + 1);
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
