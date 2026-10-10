/**
 * Pratinjau gambar strip destinasi di arsip Panduan Wisata.
 *
 * Tile gambar tidak langsung membuka artikel: klik membuka modal bergaya
 * photocard — gambar besar di atas, teks di bawah, plus tombol sebelumnya /
 * berikutnya untuk berpindah gambar sekaligus artikelnya.
 *
 * Memakai <dialog> native supaya Escape, focus trap, dan backdrop gratis.
 * Kalau JS mati atau <dialog> tidak didukung, tautan tetap membuka artikel.
 */
( function () {
	'use strict';

	var modal = document.getElementById( 'xp-modal' );

	if ( ! modal || typeof modal.showModal !== 'function' ) {
		return;
	}

	var image   = modal.querySelector( '.xp-modal__img' );
	var eyebrow = modal.querySelector( '.xp-modal__eyebrow' );
	var caption = modal.querySelector( '.xp-modal__caption' );
	var link    = modal.querySelector( '.xp-modal__link' );
	var counter = modal.querySelector( '.xp-modal__counter' );
	var prevBtn = modal.querySelector( '[data-xp-prev]' );
	var nextBtn = modal.querySelector( '[data-xp-next]' );
	var closeBtn = modal.querySelector( '[data-xp-close]' );
	var tiles   = Array.prototype.slice.call( document.querySelectorAll( '[data-xp-tile]' ) );

	if ( ! image || ! link || ! tiles.length ) {
		return;
	}

	var items = tiles.map( function ( tile ) {
		return {
			image: tile.dataset.xpImage || '',
			caption: tile.dataset.xpCaption || '',
			label: tile.dataset.xpLabel || '',
			article: tile.dataset.xpArticle || '',
			url: tile.dataset.xpUrl || ''
		};
	} );

	var current = 0;
	var opener  = null;

	function render( index ) {
		if ( ! items.length ) {
			return;
		}

		current = ( ( index % items.length ) + items.length ) % items.length;

		var item = items[ current ];

		image.src = item.image;
		image.alt = item.caption;
		eyebrow.textContent = item.label;
		caption.textContent = item.caption;
		link.href = item.url;
		link.textContent = item.article;

		if ( counter ) {
			counter.textContent = ( current + 1 ) + ' / ' + items.length;
		}
	}

	function open( tile, index ) {
		opener = tile;
		render( index );

		document.body.classList.add( 'xp-modal-open' );
		modal.showModal();

		if ( closeBtn ) {
			closeBtn.focus();
		}
	}

	tiles.forEach( function ( tile, index ) {
		tile.addEventListener( 'click', function ( event ) {
			// Biarkan klik dengan modifier (buka tab/jendela baru) berjalan normal.
			if ( event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ) {
				return;
			}

			event.preventDefault();
			open( tile, index );
		} );
	} );

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', function () {
			render( current - 1 );
		} );
	}

	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', function () {
			render( current + 1 );
		} );
	}

	// Panah kiri/kanan di keyboard ikut berpindah gambar.
	modal.addEventListener( 'keydown', function ( event ) {
		if ( 'ArrowLeft' === event.key ) {
			event.preventDefault();
			render( current - 1 );
		}

		if ( 'ArrowRight' === event.key ) {
			event.preventDefault();
			render( current + 1 );
		}
	} );

	modal.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( '[data-xp-close]' ) || event.target === modal ) {
			modal.close();
		}
	} );

	modal.addEventListener( 'close', function () {
		document.body.classList.remove( 'xp-modal-open' );
		image.removeAttribute( 'src' );
		image.alt = '';

		var target = opener;
		opener = null;

		if ( target && typeof target.focus === 'function' ) {
			target.focus();
		}
	} );
}() );
