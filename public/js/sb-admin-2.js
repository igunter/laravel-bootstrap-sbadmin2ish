document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.querySelector('.sb-sidebar');
    var toggleButtons = document.querySelectorAll('[data-sb-toggle="sidebar"]');
    var flyoutMql = window.matchMedia('(min-width: 769px)');
    var flyoutCloseTimer = null;
    var sidebarStateKey = 'sb-sidebar-toggled';

    if (localStorage.getItem(sidebarStateKey) === '1') {
        sidebar.classList.add('toggled');
    }

    function closeAllFlyouts() {
        document.querySelectorAll('.sb-sidebar .collapse.flyout-open').forEach(function (el) {
            el.classList.remove('flyout-open');
        });
    }

    function openFlyout(item, collapseEl) {
        clearTimeout(flyoutCloseTimer);
        closeAllFlyouts();
        var rect = item.getBoundingClientRect();
        collapseEl.style.top = rect.top + 'px';
        collapseEl.style.left = rect.right + 'px';
        collapseEl.classList.add('flyout-open');
    }

    function scheduleFlyoutClose(collapseEl) {
        clearTimeout(flyoutCloseTimer);
        flyoutCloseTimer = setTimeout(function () {
            collapseEl.classList.remove('flyout-open');
        }, 150);
    }

    document.querySelectorAll('.sb-sidebar .sb-nav-item').forEach(function (item) {
        var collapseEl = item.querySelector(':scope > .collapse');
        if (!collapseEl) return;

        item.addEventListener('mouseenter', function () {
            if (!sidebar.classList.contains('toggled') || !flyoutMql.matches) return;
            openFlyout(item, collapseEl);
        });
        item.addEventListener('mouseleave', function () {
            scheduleFlyoutClose(collapseEl);
        });
        collapseEl.addEventListener('mouseenter', function () {
            clearTimeout(flyoutCloseTimer);
        });
        collapseEl.addEventListener('mouseleave', function () {
            scheduleFlyoutClose(collapseEl);
        });
    });

    window.addEventListener('resize', function () {
        if (!sidebar.classList.contains('toggled') || !flyoutMql.matches) {
            closeAllFlyouts();
        }
    });

    toggleButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            sidebar.classList.toggle('toggled');
            localStorage.setItem(sidebarStateKey, sidebar.classList.contains('toggled') ? '1' : '0');
            closeAllFlyouts();
        });
    });

    var scrollBtn = document.querySelector('.scroll-to-top');

    if (scrollBtn) {
        window.addEventListener('scroll', function () {
            scrollBtn.classList.toggle('show', window.scrollY > 100);
        });

        scrollBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
