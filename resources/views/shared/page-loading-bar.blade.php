<div class="page-loading-bar" data-page-loading-bar aria-hidden="true">
    <div class="page-loading-bar__progress" data-page-loading-progress></div>
</div>

<style>
    .page-loading-bar {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 2147483647;
        width: 100%;
        height: 3px;
        pointer-events: none;
        opacity: 0;
        transition: opacity 160ms ease;
    }

    .page-loading-bar.is-active {
        opacity: 1;
    }

    .page-loading-bar__progress {
        width: 100%;
        height: 100%;
        background: var(--servease-primary-color, #FFBE42);
        box-shadow: 0 0 8px rgba(255, 190, 66, 0.38);
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform 220ms ease;
    }
</style>

<script>
    (function () {
        if (window.ServeasePageLoader) {
            return;
        }

        var root = document.querySelector('[data-page-loading-bar]');
        var progressElement = document.querySelector('[data-page-loading-progress]');
        var activeRequests = 0;
        var progress = 0;
        var progressTimer = null;
        var hideTimer = null;

        if (!root || !progressElement) {
            return;
        }

        function setProgress(value) {
            progress = Math.min(value, 100);
            progressElement.style.transform = 'scaleX(' + (progress / 100) + ')';
        }

        function reset() {
            activeRequests = 0;
            progress = 0;
            root.classList.remove('is-active');
            progressElement.style.transform = 'scaleX(0)';
            clearInterval(progressTimer);
            clearTimeout(hideTimer);
        }

        function show() {
            clearTimeout(hideTimer);
            root.classList.add('is-active');

            if (progress <= 0 || progress >= 100) {
                setProgress(12);
            }
        }

        function start() {
            clearTimeout(hideTimer);
            activeRequests += 1;
            show();

            clearInterval(progressTimer);
            progressTimer = setInterval(function () {
                if (progress < 88) {
                    setProgress(progress + Math.max(1, (90 - progress) * 0.08));
                }
            }, 160);
        }

        function finish() {
            activeRequests = Math.max(0, activeRequests - 1);

            if (activeRequests > 0) {
                return;
            }

            clearInterval(progressTimer);
            setProgress(100);

            hideTimer = setTimeout(function () {
                reset();
            }, 260);
        }

        function shouldIgnoreLink(link, event) {
            var rawHref = link.getAttribute('href');

            if (!rawHref || rawHref.charAt(0) === '#' || rawHref.indexOf('javascript:') === 0) {
                return true;
            }

            if (link.hasAttribute('download') || link.target && link.target !== '_self') {
                return true;
            }

            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0) {
                return true;
            }

            var url;

            try {
                url = new URL(link.href, window.location.href);
            } catch (error) {
                return true;
            }

            if (url.origin !== window.location.origin) {
                return true;
            }

            return url.pathname === window.location.pathname
                && url.search === window.location.search
                && (url.hash !== '' || url.href === window.location.href);
        }

        window.ServeasePageLoader = {
            show: show,
            start: start,
            finish: finish,
            reset: reset
        };

        document.addEventListener('click', function (event) {
            var link = event.target.closest ? event.target.closest('a[href]') : null;
            var submitter = event.target.closest ? event.target.closest('button[type="submit"], input[type="submit"], button:not([type])') : null;

            if (!link || event.defaultPrevented || shouldIgnoreLink(link, event)) {
                if (!submitter || event.defaultPrevented) {
                    return;
                }

                show();

                window.setTimeout(function () {
                    if (activeRequests === 0 && document.visibilityState === 'visible') {
                        finish();
                    }
                }, 900);

                return;
            }

            show();
        });

        document.addEventListener('submit', function (event) {
            var form = event.target;

            if (!form || event.defaultPrevented || form.target && form.target !== '_self') {
                return;
            }

            if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                reset();
                return;
            }

            start();
        });

        document.addEventListener('invalid', reset, true);

        if (window.fetch) {
            var originalFetch = window.fetch;

            window.fetch = function () {
                start();

                return originalFetch.apply(this, arguments).finally(function () {
                    finish();
                });
            };
        }

        if (window.XMLHttpRequest) {
            var originalSend = window.XMLHttpRequest.prototype.send;

            window.XMLHttpRequest.prototype.send = function () {
                start();
                this.addEventListener('loadend', finish, { once: true });
                return originalSend.apply(this, arguments);
            };
        }

        window.addEventListener('beforeunload', function () {
            if (progress > 0 && progress < 95) {
                setProgress(95);
            }
        });

        window.addEventListener('pageshow', function () {
            reset();
        });

        document.addEventListener('livewire:load', function () {
            if (!window.Livewire || !window.Livewire.hook) {
                return;
            }

            try {
                window.Livewire.hook('message.sent', start);
                window.Livewire.hook('message.processed', finish);
                window.Livewire.hook('message.failed', finish);
            } catch (error) {
                reset();
            }
        });

        document.addEventListener('livewire:init', function () {
            if (!window.Livewire || !window.Livewire.hook) {
                return;
            }

            try {
                window.Livewire.hook('request', function (payload) {
                    start();

                    if (payload && typeof payload.respond === 'function') {
                        payload.respond(finish);
                    } else if (payload && typeof payload.succeed === 'function') {
                        payload.succeed(finish);
                    }
                });
            } catch (error) {
                reset();
            }
        });
    })();
</script>
