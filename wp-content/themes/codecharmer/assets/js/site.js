/**
 * Code Charmer site runtime.
 *
 * Header behavior, reveal-on-scroll, the instrumented-rail scroll driver, and
 * the contact form. Every feature is progressive enhancement over a complete
 * server-rendered default: with this file absent, all content renders and the
 * form still works via its mailto fallback.
 */
( function () {
	'use strict';

	var REDUCED = window.matchMedia( '(prefers-reduced-motion: reduce)' );

	/* ------------------------------------------------------------ header -- */
	function initHeader() {
		var header = document.querySelector( '[data-header]' );
		if ( ! header ) {
			return;
		}

		var onScroll = function () {
			header.toggleAttribute( 'data-scrolled', window.scrollY > 8 );
		};
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );

		// Mega-menu (pointer + keyboard).
		var canHover = window.matchMedia( '(hover: hover)' );
		header.querySelectorAll( '[data-menu-root]' ).forEach( function ( root ) {
			var trigger = root.querySelector( '[data-menu-trigger]' );
			var panel = root.querySelector( '[data-menu-panel]' );
			if ( ! trigger || ! panel ) {
				return;
			}
			var closeTimer;

			var open = function () {
				window.clearTimeout( closeTimer );
				root.setAttribute( 'data-open', '' );
				trigger.setAttribute( 'aria-expanded', 'true' );
				panel.hidden = false;
			};
			var close = function () {
				root.removeAttribute( 'data-open' );
				trigger.setAttribute( 'aria-expanded', 'false' );
				panel.hidden = true;
			};

			trigger.addEventListener( 'click', function () {
				if ( root.hasAttribute( 'data-open' ) ) {
					close();
				} else {
					open();
				}
			} );
			root.addEventListener( 'mouseenter', function () {
				if ( canHover.matches ) {
					open();
				}
			} );
			root.addEventListener( 'mouseleave', function () {
				if ( canHover.matches ) {
					closeTimer = window.setTimeout( close, 120 );
				}
			} );
			root.addEventListener( 'focusout', function ( e ) {
				if ( ! root.contains( e.relatedTarget ) ) {
					close();
				}
			} );
			root.addEventListener( 'keydown', function ( e ) {
				if ( 'Escape' === e.key ) {
					close();
					trigger.focus();
				}
			} );
		} );

		// Mobile overlay.
		var toggle = header.querySelector( '[data-nav-toggle]' );
		var overlay = document.querySelector( '[data-mobile-nav]' );
		if ( toggle && overlay ) {
			var setOpen = function ( openState ) {
				header.toggleAttribute( 'data-nav-open', openState );
				toggle.setAttribute( 'aria-expanded', String( openState ) );
				toggle.setAttribute( 'aria-label', openState ? 'Close menu' : 'Open menu' );
				overlay.hidden = ! openState;
				document.documentElement.style.overflow = openState ? 'hidden' : '';
			};
			toggle.addEventListener( 'click', function () {
				setOpen( overlay.hidden );
			} );
			overlay.querySelectorAll( 'a' ).forEach( function ( a ) {
				a.addEventListener( 'click', function () {
					setOpen( false );
				} );
			} );
			document.addEventListener( 'keydown', function ( e ) {
				if ( 'Escape' === e.key && ! overlay.hidden ) {
					setOpen( false );
					toggle.focus();
				}
			} );
		}
	}

	/* ----------------------------------------------------------- reveals -- */
	// Nothing here may leave content hidden: every path ends in `is-in`.
	function initReveals() {
		var revealables = document.querySelectorAll( '.reveal' );
		var revealAll = function () {
			revealables.forEach( function ( el ) {
				el.classList.add( 'is-in' );
			} );
		};

		if (
			! revealables.length ||
			! document.documentElement.classList.contains( 'reveals-ready' )
		) {
			revealAll();
			return;
		}

		var io = new IntersectionObserver(
			function ( entries, obs ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-in' );
						obs.unobserve( entry.target );
					}
				} );
			},
			{ rootMargin: '0px 0px -10% 0px', threshold: 0.12 }
		);
		revealables.forEach( function ( el ) {
			io.observe( el );
		} );

		// Failsafe: whatever the observer has not reached becomes visible anyway.
		var failsafe = window.setTimeout( revealAll, 1600 );
		document.addEventListener( 'visibilitychange', function () {
			if ( 'hidden' === document.visibilityState ) {
				window.clearTimeout( failsafe );
				revealAll();
			}
		} );
		window.addEventListener( 'pageshow', revealAll );
	}

	/* ------------------------------------------------------- rail driver -- */
	// Scroll position IS process position. This only ever *rewinds* a rail
	// that CSS has already rendered complete — no JS leaves a finished rail.
	function initRails() {
		if ( REDUCED.matches ) {
			return;
		}

		var rails = Array.prototype.slice.call(
			document.querySelectorAll( '.rail[data-scrub]' )
		);
		if ( ! rails.length ) {
			return;
		}

		var frame = 0;
		var timers = new WeakMap();

		var fullTextOf = function ( el ) {
			if ( ! el.dataset.full ) {
				el.dataset.full = el.textContent || '';
			}
			return el.dataset.full;
		};

		var settle = function ( el ) {
			var t = timers.get( el );
			if ( t ) {
				window.clearInterval( t );
				timers.delete( el );
			}
			el.textContent = fullTextOf( el );
		};

		var typeOut = function ( el ) {
			var full = fullTextOf( el );
			var prev = timers.get( el );
			if ( prev ) {
				window.clearInterval( prev );
			}
			var i = 0;
			el.textContent = '';
			var t = window.setInterval( function () {
				i += 2;
				el.textContent = full.slice( 0, i );
				if ( i >= full.length ) {
					window.clearInterval( t );
					timers.delete( el );
				}
			}, 22 );
			timers.set( el, t );
		};

		var apply = function ( rail, force ) {
			var rect = rail.getBoundingClientRect();
			var vh = window.innerHeight || document.documentElement.clientHeight;

			// Well outside the viewport: nothing to recompute this frame. The
			// init pass is exempt — a live rail must never sit stateless.
			if ( ! force && ( rect.bottom < -vh || rect.top > vh * 2 ) ) {
				return;
			}

			var p =
				'through' === rail.dataset.scrub
					? ( vh * 0.52 - rect.top ) / ( rect.height || 1 )
					: ( vh * 0.86 - rect.top ) / ( vh * 0.52 );
			var clamped = Math.min( 1, Math.max( 0, p ) );

			rail.style.setProperty( '--rail-progress', clamped.toFixed( 4 ) );
			rail.toggleAttribute( 'data-at-edge', clamped <= 0.001 || clamped >= 0.999 );

			var setState = function ( marker, from, to ) {
				var state = clamped < from ? 'queued' : clamped < to ? 'active' : 'committed';
				if ( marker.dataset.state === state ) {
					return;
				}
				marker.dataset.state = state;
				var typed = marker.querySelector( '[data-type]' );
				if ( typed ) {
					if ( 'active' === state ) {
						typeOut( typed );
					} else {
						settle( typed );
					}
				}
			};

			// Authored spans: the block knew the weights at render time.
			rail.querySelectorAll( '[data-from]' ).forEach( function ( marker ) {
				setState( marker, Number( marker.dataset.from ), Number( marker.dataset.to ) );
			} );

			// Measured spans: stage extent follows its copy on tall timelines.
			var autos = rail.querySelectorAll( '[data-auto]' );
			if ( autos.length ) {
				var height = rect.height || 1;
				var starts = Array.prototype.map.call( autos, function ( el ) {
					return ( el.getBoundingClientRect().top - rect.top ) / height;
				} );
				autos.forEach( function ( marker, i ) {
					setState(
						marker,
						starts[ i ],
						undefined !== starts[ i + 1 ] ? starts[ i + 1 ] : 1
					);
				} );
			}
		};

		var paint = function () {
			frame = 0;
			rails.forEach( function ( rail ) {
				apply( rail, false );
			} );
		};

		var schedule = function () {
			if ( ! frame ) {
				frame = window.requestAnimationFrame( paint );
			}
		};

		rails.forEach( function ( rail ) {
			apply( rail, true );
			rail.setAttribute( 'data-rail-live', '' );
		} );

		window.addEventListener( 'scroll', schedule, { passive: true } );
		window.addEventListener( 'resize', schedule, { passive: true } );
		window.addEventListener( 'pageshow', schedule );
	}

	/* ------------------------------------------------------ contact form -- */
	function initContactForm() {
		var form = document.querySelector( '[data-contact-form]' );
		if ( ! form ) {
			return;
		}

		var endpoint = form.getAttribute( 'data-endpoint' ) || '';
		var nonce = form.getAttribute( 'data-nonce' ) || '';
		var toEmail = form.getAttribute( 'data-email' ) || '';
		var statusEl = form.querySelector( '[data-status]' );
		var submitBtn = form.querySelector( '[data-submit]' );
		var submitLabel = form.querySelector( '[data-submit-label]' );
		var donePanel = document.querySelector( '[data-done]' );
		var doneBody = document.querySelector( '[data-done-body]' );

		var setError = function ( name, msg ) {
			var input = form.querySelector( '#cf-' + name );
			var field = input ? input.closest( '.field' ) : null;
			var errEl = form.querySelector( '#err-' + name );
			if ( ! field || ! errEl ) {
				return;
			}
			if ( msg ) {
				field.setAttribute( 'data-invalid', '' );
				input.setAttribute( 'aria-invalid', 'true' );
				errEl.textContent = msg;
			} else {
				field.removeAttribute( 'data-invalid' );
				input.removeAttribute( 'aria-invalid' );
				errEl.textContent = '';
			}
		};

		var validate = function ( data ) {
			var errors = {};
			if ( ! data.name || ! data.name.trim() ) {
				errors.name = 'Please add your name.';
			}
			if ( ! data.email || ! data.email.trim() ) {
				errors.email = 'We need an email to reply to.';
			} else if ( ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( data.email ) ) {
				errors.email = 'That email doesn’t look right.';
			}
			if ( ! data.projectType ) {
				errors.type = 'Pick the closest match.';
			}
			if ( ! data.message || data.message.trim().length < 10 ) {
				errors.message = 'A sentence or two helps us reply well.';
			}
			return errors;
		};

		var buildMailto = function ( data ) {
			var subject = 'Project inquiry: ' + data.name;
			var lines = [
				'Name: ' + data.name,
				'Company: ' + ( data.company || '-' ),
				'Email: ' + data.email,
				'Project type: ' + data.projectType,
				'Budget: ' + ( data.budget || '-' ),
				'Timeline: ' + ( data.timeline || '-' ),
				'',
				data.message,
			];
			return (
				'mailto:' + toEmail +
				'?subject=' + encodeURIComponent( subject ) +
				'&body=' + encodeURIComponent( lines.join( '\n' ) )
			);
		};

		var finish = function ( viaEmailClient ) {
			form.hidden = true;
			if ( viaEmailClient && doneBody ) {
				doneBody.textContent =
					'We’ve opened your email client with the details filled in. Hit send and we’ll take it from there.';
			}
			if ( donePanel ) {
				donePanel.hidden = false;
				donePanel.focus();
			}
		};

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var fd = new FormData( form );
			// Honeypot.
			if ( fd.get( 'website' ) ) {
				finish( false );
				return;
			}

			var data = {};
			fd.forEach( function ( value, key ) {
				data[ key ] = value;
			} );

			[ 'name', 'email', 'type', 'message' ].forEach( function ( n ) {
				setError( n, '' );
			} );
			var errors = validate( data );
			var keys = Object.keys( errors );
			if ( keys.length ) {
				keys.forEach( function ( k ) {
					setError( k, errors[ k ] );
				} );
				var firstId = 'type' === keys[ 0 ] ? 'cf-type' : 'cf-' + keys[ 0 ];
				var firstEl = form.querySelector( '#' + firstId );
				if ( firstEl ) {
					firstEl.focus();
				}
				if ( statusEl ) {
					statusEl.textContent = 'Please fix the highlighted fields.';
					statusEl.setAttribute( 'data-tone', 'error' );
				}
				return;
			}

			if ( submitBtn ) {
				submitBtn.setAttribute( 'disabled', '' );
			}
			if ( submitLabel ) {
				submitLabel.textContent = 'Sending…';
			}
			if ( statusEl ) {
				statusEl.textContent = '';
				statusEl.removeAttribute( 'data-tone' );
			}

			var fail = function () {
				if ( submitBtn ) {
					submitBtn.removeAttribute( 'disabled' );
				}
				if ( submitLabel ) {
					submitLabel.textContent = 'Send inquiry';
				}
				if ( statusEl ) {
					statusEl.textContent = 'Something went wrong. Email us directly at ' + toEmail + '.';
					statusEl.setAttribute( 'data-tone', 'error' );
				}
			};

			if ( endpoint ) {
				window
					.fetch( endpoint, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							Accept: 'application/json',
							'X-WP-Nonce': nonce,
						},
						body: JSON.stringify( data ),
					} )
					.then( function ( res ) {
						if ( ! res.ok ) {
							throw new Error( 'bad status' );
						}
						finish( false );
					} )
					.catch( fail );
			} else {
				// No backend configured — open a prefilled email so it works today.
				window.location.href = buildMailto( data );
				finish( true );
			}
		} );

		// Clear a field's error as the user fixes it.
		form.querySelectorAll( 'input, select, textarea' ).forEach( function ( el ) {
			el.addEventListener( 'input', function () {
				var id = el.id.replace( 'cf-', '' );
				var key = 'type' === id ? 'type' : id;
				if ( [ 'name', 'email', 'type', 'message' ].indexOf( key ) !== -1 ) {
					setError( key, '' );
				}
			} );
		} );
	}

	var boot = function () {
		initHeader();
		initReveals();
		initRails();
		initContactForm();
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
