(() => {
	const header = document.querySelector('.site-header');

	if (!header) {
		return;
	}

	const updateHeader = () => {
		header.classList.toggle('is-scrolled', window.scrollY > 0);
	};
	const updateHeaderHeight = () => {
		document.documentElement.style.setProperty('--site-header-height', `${header.offsetHeight}px`);
	};

	updateHeaderHeight();
	updateHeader();
	window.addEventListener('resize', updateHeaderHeight);
	window.addEventListener('scroll', updateHeader, { passive: true });
})();
