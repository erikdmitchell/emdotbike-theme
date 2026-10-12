/**
 * supporter functions for our theme
 */

/**
 * Menu toggle: opens and closes the header menu panel.
 */
document.addEventListener('DOMContentLoaded', function () {
	const toggle = document.querySelector('.toggle-nav');
	const menu = toggle
		? document.getElementById(toggle.getAttribute('aria-controls'))
		: null;

	if (!toggle || !menu) {
		return;
	}

	const icon = toggle.querySelector('.dashicons');

	function setOpen(open) {
		menu.classList.toggle('is-open', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		toggle.setAttribute(
			'aria-label',
			open ? toggle.dataset.labelClose : toggle.dataset.labelOpen
		);

		if (icon) {
			icon.classList.toggle('dashicons-menu-alt', !open);
			icon.classList.toggle('dashicons-no-alt', open);
		}
	}

	toggle.addEventListener('click', function () {
		setOpen(toggle.getAttribute('aria-expanded') !== 'true');
	});

	// Esc closes the menu and returns focus to the toggle.
	document.addEventListener('keydown', function (event) {
		if (
			'Escape' === event.key &&
			'true' === toggle.getAttribute('aria-expanded')
		) {
			setOpen(false);
			toggle.focus();
		}
	});
});

/**
 * back to top button function
 */
document.addEventListener('DOMContentLoaded', function () {
	// browser window scroll (in pixels) after which the "back to top" link is shown
	const offset = 300,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offsetOpacity = 1200,
		//grab the "back to top" link
		backToTop = document.querySelector('.emdotbike-back-to-top');

	if (!backToTop) {
		return;
	}

	//hide or show the "back to top" link
	window.addEventListener(
		'scroll',
		function () {
			const scrolled = window.scrollY;

			if (scrolled > offset) {
				backToTop.classList.add('btt-is-visible');
			} else {
				backToTop.classList.remove('btt-is-visible', 'btt-fade-out');
			}
			if (scrolled > offsetOpacity) {
				backToTop.classList.add('btt-fade-out');
			}
		},
		{ passive: true }
	);

	//smooth scroll to top
	backToTop.addEventListener('click', function (event) {
		event.preventDefault();
		window.scrollTo({ top: 0, behavior: 'smooth' });
	});
});
