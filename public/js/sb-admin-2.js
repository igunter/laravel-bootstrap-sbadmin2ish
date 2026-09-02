document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.querySelector('.sb-sidebar');
    var toggleButtons = document.querySelectorAll('[data-sb-toggle="sidebar"]');

    toggleButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            sidebar.classList.toggle('toggled');
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
