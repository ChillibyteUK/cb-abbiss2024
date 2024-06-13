document.addEventListener('DOMContentLoaded', function() {
    var topNav = document.querySelector('.prenav');
    var mainNav = document.querySelector('.navbar');
    var lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        var scrollTop = window.scrollY || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            // Scrolling down
            topNav.classList.add('hidden');
            mainNav.classList.add('hidden');
        } else {
            // Scrolling up
            mainNav.classList.remove('hidden');
            if (scrollTop === 0) {
                topNav.classList.remove('hidden');
            }
        }

        lastScrollTop = scrollTop;
    });
});
