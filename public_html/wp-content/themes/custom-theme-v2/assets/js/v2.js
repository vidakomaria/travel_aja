( function () {
	'use strict';

	const header = document.querySelector( '[data-v2-header]' );
	const toggle = document.querySelector( '.v2-menu-toggle' );
	const navigation = document.querySelector( '[data-v2-navigation]' );

	if ( header ) {
		const updateHeader = () => header.classList.toggle( 'is-scrolled', window.scrollY > 16 );
		updateHeader();
		window.addEventListener( 'scroll', updateHeader, { passive: true } );
	}

	if ( ! toggle || ! navigation ) {
		return;
	}

	const closeMenu = () => {
		toggle.setAttribute( 'aria-expanded', 'false' );
		navigation.classList.remove( 'is-open' );
		document.body.classList.remove( 'v2-menu-open' );
	};

	toggle.addEventListener( 'click', () => {
		const open = toggle.getAttribute( 'aria-expanded' ) !== 'true';
		toggle.setAttribute( 'aria-expanded', String( open ) );
		navigation.classList.toggle( 'is-open', open );
		document.body.classList.toggle( 'v2-menu-open', open );
	} );

	navigation.addEventListener( 'click', ( event ) => {
		if ( event.target.closest( 'a' ) ) {
			closeMenu();
		}
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closeMenu();
		}
	} );
}() );

