(function () {
    var content = document.getElementById('app-content');
    var defaultPage = document.body.getAttribute('data-default-page') || 'admin.php';
    var userRole = document.body.getAttribute('data-user-role') || 'guest';
    var currentPageKey = 'ppd-current-page-' + userRole;
    var loadablePages = [
        'admin.php',
        'adminviewdocs2.php',
        'ebarmmdocs.php',
        'environmentaldocs.php',
        'indexdocs_cside.php',
        'indexdocs_cside_funded.php',
        'indexdocs_cside_funded1.php',
        'indexdocs_cside_funded2.php',
        'indexdocs_cside_fundedgis.php',
        'indexdocs_cside_fundedprojects.php',
        'indexdocs_cside_planning.php',
        'indexdocs_cside_planning1.php',
        'indexdocs_cside_planningdocs.php',
        'outgoingdocs.php',
        'planningdocs.php',
        'programmingdocs.php',
        'unfunded_cside.php',
        'unfunded_cside1.php',
        'unfunded_cside_status.php',
        'viewdocs.php',
        'viewdocs2.php'
    ];

    function pageFromHref(href) {
        try {
            var url = new URL(href, window.location.href);
            if (url.origin !== window.location.origin) return '';
            return url.pathname.split('/').pop();
        } catch (error) {
            return '';
        }
    }

    function isLoadablePage(page) {
        return loadablePages.indexOf(page) !== -1;
    }

    function ensureStyles(doc) {
        document.querySelectorAll('[data-spa-page-style]').forEach(function (node) {
            node.parentNode.removeChild(node);
        });

        doc.querySelectorAll('link[rel="stylesheet"]').forEach(function (link) {
            var href = link.getAttribute('href');
            if (!href || document.querySelector('link[href="' + href.replace(/"/g, '\\"') + '"]')) return;

            var clone = document.createElement('link');
            clone.rel = 'stylesheet';
            clone.href = href;
            clone.setAttribute('data-spa-page-style', 'true');
            document.head.appendChild(clone);
        });

        doc.querySelectorAll('style').forEach(function (style) {
            var clone = document.createElement('style');
            clone.textContent = style.textContent;
            clone.setAttribute('data-spa-page-style', 'true');
            document.head.appendChild(clone);
        });
    }

    function cleanupCurrentPage() {
        if (window.jQuery && jQuery.fn && jQuery.fn.DataTable) {
            jQuery.fn.dataTable.tables().forEach(function (table) {
                if (jQuery.fn.DataTable.isDataTable(table)) {
                    jQuery(table).DataTable().clear().destroy();
                }
            });

            jQuery(document).off('click', '.edit-btn');
            jQuery(document).off('click', '.btn-delete');
        }

        document.querySelectorAll('.modal-backdrop').forEach(function (node) {
            node.parentNode.removeChild(node);
        });
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
    }

    function getInlineScriptCode(doc) {
        var code = [];
        doc.querySelectorAll('script:not([src])').forEach(function (script) {
            if (script.textContent.trim()) {
                code.push(script.textContent);
            }
        });
        return code;
    }

    function normalizeContent(doc) {
        doc.querySelectorAll('.topnav').forEach(function (nav) {
            nav.parentNode.removeChild(nav);
        });
        doc.querySelectorAll('script').forEach(function (script) {
            script.parentNode.removeChild(script);
        });
        return doc.body ? doc.body.innerHTML : doc.documentElement.innerHTML;
    }

    function runInlineScripts(code) {
        if (!code.length) return;

        var runner = document.createElement('script');
        runner.text = '(function(){\n' + code.join('\n;\n') + '\n})();';
        document.body.appendChild(runner);
        runner.parentNode.removeChild(runner);
    }

    function loadPage(page) {
        if (!isLoadablePage(page)) return Promise.resolve();

        sessionStorage.setItem(currentPageKey, page);
        document.body.classList.add('app-shell-loading');
        cleanupCurrentPage();
        content.innerHTML = '<div class="app-loading">Loading...</div>';

        return fetch(page, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(function (response) {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.text();
            })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var inlineScriptCode = getInlineScriptCode(doc);
                ensureStyles(doc);
                content.innerHTML = normalizeContent(doc);
                runInlineScripts(inlineScriptCode);
                document.body.classList.remove('app-shell-loading');
            })
            .catch(function () {
                content.innerHTML = '<div class="app-error">Hindi ma-load ang page. Pakisubukan ulit.</div>';
                document.body.classList.remove('app-shell-loading');
            });
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('a[href]');
        if (!link || link.target === '_blank' || event.defaultPrevented) return;

        var page = pageFromHref(link.getAttribute('href'));
        if (!isLoadablePage(page)) return;

        event.preventDefault();
        loadPage(page);
    });

    window.loadPpdPage = loadPage;
    var savedPage = sessionStorage.getItem(currentPageKey);
    loadPage(isLoadablePage(savedPage) ? savedPage : defaultPage);
})();
