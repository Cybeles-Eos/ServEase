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

        function shouldShowForForm(form) {
            var method = (form.getAttribute('method') || 'get').toLowerCase();

            if (method !== 'post') {
                return false;
            }

            if (form.hasAttribute('data-page-loading-form')) {
                return true;
            }

            var url;

            try {
                url = new URL(form.getAttribute('action') || window.location.href, window.location.href);
            } catch (error) {
                return false;
            }

            if (url.origin !== window.location.origin) {
                return false;
            }

            return [
                '/login',
                '/register',
                '/provider-signup-c',
                '/provider/service/store',
                '/provider/setting/update',
                '/customer/setting/update',
                '/provider/resubmit'
            ].indexOf(url.pathname) !== -1
                || /^\/provider\/service\/update\/[^/]+$/.test(url.pathname);
        }

        window.ServeasePageLoader = {
            show: show,
            start: start,
            finish: finish,
            reset: reset
        };

        document.addEventListener('submit', function (event) {
            var form = event.target;

            if (!form || event.defaultPrevented || form.target && form.target !== '_self') {
                return;
            }

            if (!shouldShowForForm(form)) {
                return;
            }

            if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                reset();
                return;
            }

            start();
        });

        document.addEventListener('invalid', reset, true);

        window.addEventListener('beforeunload', function () {
            if (progress > 0 && progress < 95) {
                setProgress(95);
            }
        });

        window.addEventListener('pageshow', function () {
            reset();
        });

    })();
</script>
