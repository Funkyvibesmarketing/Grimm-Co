/**
 * Mobile menu toggle and keyboard handling for the primary navigation.
 */
( function () {
	const toggle = document.querySelector( '.menu-toggle' );
	const nav = document.getElementById( 'site-navigation' );

	if ( ! toggle || ! nav ) {
		return;
	}

	const setOpen = ( open ) => {
		nav.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
	};

	toggle.addEventListener( 'click', () => {
		setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
			setOpen( false );
			toggle.focus();
		}
	} );

	document.addEventListener( 'click', ( event ) => {
		if ( nav.classList.contains( 'is-open' ) && ! nav.contains( event.target ) && ! toggle.contains( event.target ) ) {
			setOpen( false );
		}
	} );

	window.matchMedia( '(min-width: 961px)' ).addEventListener( 'change', ( event ) => {
		if ( event.matches ) {
			setOpen( false );
		}
	} );
} )();
