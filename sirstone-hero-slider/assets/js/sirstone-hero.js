/*! Sirstone Hero Slider — front-end behaviour (vanilla JS, no dependencies) */
(function () {
	'use strict';

	var ROOT = '.ssh-hero';

	function toInt(value, fallback) {
		var n = parseInt(value, 10);
		return isNaN(n) ? fallback : n;
	}

	function toArray(list) {
		return Array.prototype.slice.call(list);
	}

	function Slider(root) {
		var cfg = {};
		try {
			cfg = JSON.parse(root.getAttribute('data-settings') || '{}');
		} catch (e) {
			cfg = {};
		}

		this.root = root;
		this.slides = toArray(root.querySelectorAll('.ssh-slide'));
		this.railBtns = toArray(root.querySelectorAll('.ssh-rail__btn'));
		this.progBtns = toArray(root.querySelectorAll('.ssh-progress__btn'));
		this.btnPrev = root.querySelector('.ssh-ctrl--prev');
		this.btnNext = root.querySelector('.ssh-ctrl--next');
		this.btnPlay = root.querySelector('.ssh-ctrl--play');

		// reading direction of the slider (set from the site language); mirrors navigation, swipe and transitions
		this.rtl = (window.getComputedStyle(root).direction || root.getAttribute('dir')) === 'rtl';

		this.reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
		this.cfg = {
			autoplay: !!cfg.autoplay && !cfg.editor && !this.reduce,
			speed: Math.max(1000, toInt(cfg.speed, 6500)),
			pauseHover: cfg.pauseHover !== false,
			pauseFocus: cfg.pauseFocus !== false,
			loop: cfg.loop !== false,
			swipe: cfg.swipe !== false,
			keyboard: cfg.keyboard !== false,
			duration: Math.max(0, toInt(cfg.duration, 1150)),
			start: Math.max(0, toInt(cfg.start, 0)),
			mouseFx: !!cfg.mouseFx
		};

		this.current = Math.min(this.cfg.start, Math.max(0, this.slides.length - 1));
		this.autoplayOn = this.cfg.autoplay;
		this.locked = false;
		this.timer = null;
		this.leaveTimer = null;
		this.remaining = this.cfg.speed;
		this.startedAt = 0;
		this.reasons = {};
		this.destroyed = false;

		// smoothed pointer (parallax / spotlight)
		this.tx = 0;
		this.ty = 0;
		this.cx = 0;
		this.cy = 0;
		this.raf = null;

		this.bind();
		this.init();
	}

	Slider.prototype.init = function () {
		var root = this.root;

		root.style.setProperty('--ssh-speed', this.cfg.speed + 'ms');
		root.classList.toggle('is-static', !this.autoplayOn);
		root.setAttribute('aria-live', this.autoplayOn ? 'off' : 'polite');
		root.setAttribute('data-dir', this.visualDir('next'));

		this.slides.forEach(function (s, i) {
			s.classList.toggle('is-active', i === this.current);
		}, this);

		this.sync();

		if (this.autoplayOn) {
			this.restartProgress();
			this.schedule();
		}
		if (this.btnPlay) {
			this.btnPlay.classList.toggle('is-off', !this.autoplayOn);
			this.btnPlay.setAttribute('aria-pressed', this.autoplayOn ? 'false' : 'true');
		}
	};

	/* ---------------- state → DOM ---------------- */

	Slider.prototype.sync = function () {
		var cur = this.current;

		this.slides.forEach(function (s, i) {
			var on = i === cur;
			s.setAttribute('aria-hidden', on ? 'false' : 'true');
			if (on) {
				s.removeAttribute('inert');
			} else {
				s.setAttribute('inert', '');
			}
		});

		[this.railBtns, this.progBtns].forEach(function (list) {
			list.forEach(function (b, i) {
				var on = i === cur;
				b.classList.toggle('is-active', on);
				if (on) {
					b.setAttribute('aria-current', 'true');
				} else {
					b.removeAttribute('aria-current');
				}
			});
		});
	};

	Slider.prototype.restartProgress = function () {
		var self = this;
		this.progBtns.forEach(function (b, i) {
			b.classList.remove('is-run');
			b.classList.toggle('is-done', self.autoplayOn && i < self.current);
		});
		void this.root.offsetWidth; // force reflow so the CSS animation restarts
		if (this.autoplayOn && this.progBtns[this.current]) {
			this.progBtns[this.current].classList.add('is-run');
		}
	};

	/* ---------------- navigation ---------------- */

	Slider.prototype.goTo = function (index, dir) {
		var n = this.slides.length;
		if (n < 2 || this.locked || this.destroyed) {
			return;
		}

		if (this.cfg.loop) {
			index = ((index % n) + n) % n;
		} else if (index < 0 || index >= n) {
			return;
		}
		if (index === this.current) {
			return;
		}

		var self = this;
		var prev = this.slides[this.current];
		var next = this.slides[index];
		dir = dir || (index > this.current ? 'next' : 'prev');

		var fx = this.reduce ? 'none' : (next.getAttribute('data-fx') || 'fade');
		var dur = fx === 'none' ? 0 : this.cfg.duration;

		clearTimeout(this.leaveTimer);
		this.slides.forEach(function (s) {
			if (s !== prev && s !== next) {
				s.classList.remove('is-leaving');
			}
		});

		this.root.setAttribute('data-dir', this.visualDir(dir));
		this.root.setAttribute('data-tr', fx);

		if (dur > 0) {
			prev.classList.add('is-leaving');
		}
		prev.classList.remove('is-active');
		next.classList.remove('is-leaving');
		next.classList.add('is-active');

		this.current = index;
		this.sync();

		if (dur > 0) {
			this.locked = true;
			this.leaveTimer = setTimeout(function () {
				prev.classList.remove('is-leaving');
				self.locked = false;
			}, dur + 60);
		}

		if (this.autoplayOn) {
			this.restartProgress();
			this.schedule();
		}
	};

	// The CSS transitions are written for LTR (next enters from the right), so RTL flips the side.
	Slider.prototype.visualDir = function (dir) {
		if (!this.rtl) {
			return dir;
		}
		return dir === 'next' ? 'prev' : 'next';
	};

	Slider.prototype.next = function () {
		this.goTo(this.current + 1, 'next');
	};

	Slider.prototype.prev = function () {
		this.goTo(this.current - 1, 'prev');
	};

	/* ---------------- autoplay ---------------- */

	Slider.prototype.isPaused = function () {
		var r = this.reasons;
		for (var k in r) {
			if (Object.prototype.hasOwnProperty.call(r, k) && r[k]) {
				return true;
			}
		}
		return false;
	};

	Slider.prototype.schedule = function () {
		clearTimeout(this.timer);
		this.timer = null;
		this.remaining = this.cfg.speed;
		this.resume();
	};

	Slider.prototype.resume = function () {
		var self = this;
		if (!this.autoplayOn || this.isPaused() || this.timer) {
			return;
		}
		this.startedAt = Date.now();
		this.timer = setTimeout(function () {
			self.timer = null;
			if (!self.root.isConnected) {
				self.destroy();
				return;
			}
			if (!self.cfg.loop && self.current >= self.slides.length - 1) {
				self.autoplayOn = false;
				return;
			}
			self.next();
		}, Math.max(0, this.remaining));
		this.root.classList.remove('is-paused');
	};

	Slider.prototype.pause = function () {
		if (this.timer) {
			clearTimeout(this.timer);
			this.timer = null;
			this.remaining = Math.max(0, this.remaining - (Date.now() - this.startedAt));
		}
		this.root.classList.add('is-paused');
	};

	Slider.prototype.setPause = function (reason, value) {
		this.reasons[reason] = value;
		if (this.isPaused()) {
			this.pause();
		} else {
			this.resume();
		}
	};

	Slider.prototype.toggleAutoplay = function () {
		this.autoplayOn = !this.autoplayOn;
		this.root.classList.toggle('is-static', !this.autoplayOn);
		this.root.setAttribute('aria-live', this.autoplayOn ? 'off' : 'polite');

		if (this.btnPlay) {
			this.btnPlay.classList.toggle('is-off', !this.autoplayOn);
			this.btnPlay.setAttribute('aria-pressed', this.autoplayOn ? 'false' : 'true');
		}

		clearTimeout(this.timer);
		this.timer = null;
		this.restartProgress();
		if (this.autoplayOn) {
			this.schedule();
		}
	};

	/* ---------------- pointer effects (parallax / spotlight) ---------------- */

	Slider.prototype.stepPointer = function () {
		var self = this;
		this.cx += (this.tx - this.cx) * 0.08;
		this.cy += (this.ty - this.cy) * 0.08;
		this.root.style.setProperty('--ssh-mx', this.cx.toFixed(4));
		this.root.style.setProperty('--ssh-my', this.cy.toFixed(4));

		if (Math.abs(this.tx - this.cx) > 0.002 || Math.abs(this.ty - this.cy) > 0.002) {
			this.raf = requestAnimationFrame(function () {
				self.stepPointer();
			});
		} else {
			this.raf = null;
		}
	};

	Slider.prototype.kickPointer = function () {
		var self = this;
		if (!this.raf) {
			this.raf = requestAnimationFrame(function () {
				self.stepPointer();
			});
		}
	};

	/* ---------------- events ---------------- */

	Slider.prototype.bind = function () {
		var self = this;
		var root = this.root;
		var canHover = !!(window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches);

		this.railBtns.forEach(function (b, i) {
			b.addEventListener('click', function () { self.goTo(i); });
		});
		this.progBtns.forEach(function (b, i) {
			b.addEventListener('click', function () { self.goTo(i); });
		});
		if (this.btnPrev) {
			this.btnPrev.addEventListener('click', function () { self.prev(); });
		}
		if (this.btnNext) {
			this.btnNext.addEventListener('click', function () { self.next(); });
		}
		if (this.btnPlay) {
			this.btnPlay.addEventListener('click', function () { self.toggleAutoplay(); });
		}

		// hover pause + pointer effects
		if (canHover) {
			root.addEventListener('mouseenter', function () {
				root.classList.add('is-hover');
				if (self.cfg.pauseHover) {
					self.setPause('hover', true);
				}
			});
			root.addEventListener('mouseleave', function () {
				root.classList.remove('is-hover');
				if (self.cfg.pauseHover) {
					self.setPause('hover', false);
				}
				if (self.cfg.mouseFx) {
					self.tx = 0;
					self.ty = 0;
					self.kickPointer();
				}
			});
			if (this.cfg.mouseFx) {
				root.addEventListener('mousemove', function (e) {
					var rect = root.getBoundingClientRect();
					if (!rect.width || !rect.height) {
						return;
					}
					self.tx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
					self.ty = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
					self.kickPointer();
				}, { passive: true });
			}
		}

		// keyboard focus pause (only keyboard focus, not the focus a mouse click leaves behind)
		if (this.cfg.pauseFocus) {
			root.addEventListener('focusin', function (e) {
				var visible = true;
				try {
					visible = e.target.matches(':focus-visible');
				} catch (err) {
					visible = true;
				}
				if (visible) {
					self.setPause('focus', true);
				}
			});
			root.addEventListener('focusout', function (e) {
				if (!e.relatedTarget || !root.contains(e.relatedTarget)) {
					self.setPause('focus', false);
				}
			});
		}

		// keyboard arrows
		if (this.cfg.keyboard) {
			root.addEventListener('keydown', function (e) {
				if (e.key === 'ArrowRight') {
					self.rtl ? self.prev() : self.next();
				} else if (e.key === 'ArrowLeft') {
					self.rtl ? self.next() : self.prev();
				} else if (e.key === 'Home') {
					self.goTo(0);
				} else if (e.key === 'End') {
					self.goTo(self.slides.length - 1);
				}
			});
		}

		// touch / pen swipe
		if (this.cfg.swipe && window.PointerEvent) {
			var sx = 0, sy = 0, tracking = false;
			root.addEventListener('pointerdown', function (e) {
				if (e.pointerType === 'mouse') {
					return;
				}
				tracking = true;
				sx = e.clientX;
				sy = e.clientY;
			}, { passive: true });
			root.addEventListener('pointerup', function (e) {
				if (!tracking) {
					return;
				}
				tracking = false;
				var dx = e.clientX - sx;
				var dy = e.clientY - sy;
				if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.4) {
					// swiping toward the start of the line goes forward: left in LTR, right in RTL
						(dx < 0) !== self.rtl ? self.next() : self.prev();
				}
			}, { passive: true });
			root.addEventListener('pointercancel', function () { tracking = false; }, { passive: true });
		}

		// pause while the tab is hidden / the slider is off-screen
		this.onVisibility = function () {
			if (!root.isConnected) {
				self.destroy();
				return;
			}
			self.setPause('hidden', document.hidden);
		};
		document.addEventListener('visibilitychange', this.onVisibility);

		if ('IntersectionObserver' in window) {
			this.io = new IntersectionObserver(function (entries) {
				entries.forEach(function (en) {
					self.setPause('offscreen', !en.isIntersecting);
				});
			}, { threshold: 0.2 });
			this.io.observe(root);
		}
	};

	Slider.prototype.destroy = function () {
		this.destroyed = true;
		clearTimeout(this.timer);
		clearTimeout(this.leaveTimer);
		if (this.raf) {
			cancelAnimationFrame(this.raf);
		}
		if (this.io) {
			this.io.disconnect();
		}
		document.removeEventListener('visibilitychange', this.onVisibility);
	};

	/* ---------------- boot ---------------- */

	function initAll(scope) {
		toArray((scope || document).querySelectorAll(ROOT)).forEach(function (el) {
			if (!el.__sshHero) {
				el.__sshHero = new Slider(el);
			}
		});
	}

	var hooked = false;

	function registerElementorHook() {
		if (hooked || !window.elementorFrontend || !window.elementorFrontend.hooks) {
			return;
		}
		hooked = true;
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/sirstone-hero-slider.default',
			function ($scope) {
				initAll($scope && $scope[0] ? $scope[0] : document);
			}
		);
	}

	// Elementor fires this as a jQuery event and as a native one depending on the version.
	registerElementorHook();
	window.addEventListener('elementor/frontend/init', registerElementorHook);
	if (window.jQuery) {
		window.jQuery(window).on('elementor/frontend/init', registerElementorHook);
	}

	function boot() {
		initAll(document);

		// Editor only: the widget HTML is re-rendered on every control change.
		if (document.body.classList.contains('elementor-editor-active') && 'MutationObserver' in window) {
			new MutationObserver(function () { initAll(document); })
				.observe(document.body, { childList: true, subtree: true });
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
