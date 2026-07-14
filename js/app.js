/* ============================================
   EcoDrive — Shared JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- USER MENU DROPDOWN (click toggle) ---------- */
  document.querySelectorAll('.user-menu').forEach(function (menu) {
    var badge = menu.querySelector('.user-badge');
    if (badge) {
      badge.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('dropdown-open');
      });
    }
    document.addEventListener('click', function (e) {
      if (!menu.contains(e.target)) menu.classList.remove('dropdown-open');
    });
  });

  /* ---------- BURGER MENU ---------- */
  document.querySelectorAll('.burger').forEach(function (btn) {
    btn.addEventListener('click', function () {
      this.classList.toggle('open');
      this.setAttribute('aria-expanded', this.classList.contains('open'));
      var nav = this.closest('nav');
      if (nav) nav.classList.toggle('open');
    });
  });

  /* ---------- SCROLL REVEAL (Intersection Observer) ---------- */
  var revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    revealElements.forEach(function (el) { revealObserver.observe(el); });
  }

  /* ---------- BACK TO TOP ---------- */
  var backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      backToTop.classList.toggle('visible', window.scrollY > 400);
    });
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ---------- TOAST SYSTEM ---------- */
  window.showToast = function (message, type) {
    type = type || 'info';
    var container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }
    var icons = { success: '\u2705', error: '\u274C', info: '\u2139\uFE0F' };
    var toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.innerHTML =
      '<span class="toast-icon">' + (icons[type] || '') + '</span>' +
      '<span>' + message + '</span>' +
      '<button class="toast-close" aria-label="Fermer">&times;</button>';
    container.appendChild(toast);
    toast.querySelector('.toast-close').addEventListener('click', function () {
      dismissToast(toast);
    });
    setTimeout(function () { dismissToast(toast); }, 4500);
  };
  function dismissToast(toast) {
    if (!toast || toast.classList.contains('toast-leaving')) return;
    toast.classList.add('toast-leaving');
    setTimeout(function () { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 350);
  }

  /* ---------- SMOOTH SCROLL FOR ANCHOR LINKS ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var targetId = this.getAttribute('href');
      if (targetId === '#') return;
      var target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ---------- COUNTER ANIMATION ---------- */
  var counterElements = document.querySelectorAll('.animate-counter');
  if (counterElements.length) {
    var counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var target = parseFloat(el.getAttribute('data-target')) || 0;
          var suffix = el.getAttribute('data-suffix') || '';
          var prefix = el.getAttribute('data-prefix') || '';
          var duration = parseInt(el.getAttribute('data-duration')) || 1500;
          var start = performance.now();
          function step(now) {
            var progress = Math.min((now - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = target * eased;
            el.textContent = prefix + formatNumber(current) + suffix;
            if (progress < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
          counterObserver.unobserve(el);
        }
      });
    }, { threshold: 0.5 });
    counterElements.forEach(function (el) { counterObserver.observe(el); });
  }
  function formatNumber(n) {
    if (Number.isInteger(n)) return n.toLocaleString('fr-FR');
    return n.toLocaleString('fr-FR', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
  }

  /* ---------- GLOW ON HOVER (mouse tracking) ---------- */
  document.querySelectorAll('.glow-on-hover').forEach(function (el) {
    el.addEventListener('mousemove', function (e) {
      var rect = this.getBoundingClientRect();
      var x = ((e.clientX - rect.left) / rect.width) * 100;
      var y = ((e.clientY - rect.top) / rect.height) * 100;
      this.style.setProperty('--mouse-x', x + '%');
      this.style.setProperty('--mouse-y', y + '%');
    });
  });

  /* ---------- SKELETON LOADING ---------- */
  window.showSkeleton = function (container, items) {
    items = items || 3;
    var html = '';
    for (var i = 0; i < items; i++) {
      html += '<div class="skeleton skeleton-image" style="margin-bottom:12px"></div>' +
              '<div class="skeleton skeleton-title"></div>' +
              '<div class="skeleton skeleton-text"></div>' +
              '<div class="skeleton skeleton-text" style="width:50%"></div>';
    }
    container.innerHTML = html;
  };

  /* ---------- BATTERY ANIMATION ---------- */
  var batteryFills = document.querySelectorAll('.battery-fill[data-width]');
  if (batteryFills.length) {
    var batteryObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          var w = el.getAttribute('data-width');
          setTimeout(function () { el.style.width = w; }, 200);
          batteryObserver.unobserve(el);
        }
      });
    }, { threshold: 0.3 });
    batteryFills.forEach(function (el) { batteryObserver.observe(el); });
  }

  /* ---------- PROGRESS CONNECTOR ANIMATION ---------- */
  document.querySelectorAll('.progress-connector.done').forEach(function (el) {
    var fill = el.querySelector('.connector-fill');
    if (fill) {
      var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) { fill.style.width = '100%'; obs.unobserve(entry.target); }
        });
      }, { threshold: 0.5 });
      obs.observe(el);
    }
  });

  /* ---------- DYNAMIC YEAR IN FOOTER ---------- */
  var yearEl = document.querySelector('.footer-year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  /* ---------- LIGHTBOX (car slider images) ---------- */
  var sliderViewports = document.querySelectorAll('.slider-viewport');
  sliderViewports.forEach(function (viewport) {
    viewport.addEventListener('click', function (e) {
      if (e.target.closest('.slider-arrow')) return;
      var slider = this.closest('.car-slider');
      if (!slider) return;
      var slides = slider.querySelectorAll('.slider-slide img');
      if (!slides.length) return;

      // Find current active slide index
      var track = slider.querySelector('.slider-track');
      var activeIdx = 0;
      if (track) {
        var tx = track.style.transform;
        var match = tx.match(/-?(\d+(\.\d+)?)/);
        if (match) activeIdx = Math.round(parseFloat(match[1]) / 100);
      }

      buildLightbox(slides, activeIdx, this);
    });
  });

  function buildLightbox(images, startIdx, opener) {
    var existing = document.querySelector('.lightbox');
    if (existing) existing.remove();

    var currentIdx = startIdx || 0;
    var total = images.length;

    var lb = document.createElement('div');
    lb.className = 'lightbox';
    lb.innerHTML =
      '<button class="lightbox-close" aria-label="Fermer">&times;</button>' +
      (total > 1 ? '<button class="lightbox-nav lightbox-prev" aria-label="Précédent">&#8249;</button>' : '') +
      (total > 1 ? '<button class="lightbox-nav lightbox-next" aria-label="Suivant">&#8250;</button>' : '') +
      '<img class="lightbox-img" src="" alt="">' +
      (total > 1 ? '<div class="lightbox-counter"></div>' : '');
    document.body.appendChild(lb);

    function update() {
      var img = images[currentIdx];
      var src = typeof img === 'string' ? img : img.src;
      lb.querySelector('.lightbox-img').src = src;
      var counter = lb.querySelector('.lightbox-counter');
      if (counter) counter.textContent = (currentIdx + 1) + ' / ' + total;
    }

    function next() { currentIdx = (currentIdx + 1) % total; update(); }
    function prev() { currentIdx = (currentIdx - 1 + total) % total; update(); }
    function close() {
      lb.classList.remove('open');
      if (opener && typeof opener.focus === 'function') opener.focus();
      setTimeout(function () { if (lb.parentNode) lb.parentNode.removeChild(lb); }, 350);
    }

    lb.querySelector('.lightbox-close').addEventListener('click', close);
    var prevBtn = lb.querySelector('.lightbox-prev');
    var nextBtn = lb.querySelector('.lightbox-next');
    if (prevBtn) prevBtn.addEventListener('click', function (e) { e.stopPropagation(); prev(); });
    if (nextBtn) nextBtn.addEventListener('click', function (e) { e.stopPropagation(); next(); });

    lb.addEventListener('click', function (e) {
      if (e.target === lb) close();
    });

    document.addEventListener('keydown', function handler(e) {
      if (!lb.parentNode) { document.removeEventListener('keydown', handler); return; }
      if (e.key === 'Escape') close();
      if (e.key === 'ArrowRight') { e.preventDefault(); next(); }
      if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); }
    });

    update();
    // Focus trap: focus first focusable element
    var firstFocusable = lb.querySelector('.lightbox-close');
    if (firstFocusable) {
      firstFocusable.setAttribute('tabindex', '-1');
      firstFocusable.focus();
    }
    // Trigger animation
    requestAnimationFrame(function () { lb.classList.add('open'); });
  }

  /* ---------- SLIDER AUTO-ADVANCE ---------- */
  document.querySelectorAll('.car-slider').forEach(function (slider) {
    var track = slider.querySelector('.slider-track');
    var slides = slider.querySelectorAll('.slider-slide');
    if (!track || slides.length < 2) return;
    var dots = slider.querySelectorAll('.slider-dot');
    var current = 0;
    var timer;
    function goTo(idx) {
      if (idx < 0) idx = slides.length - 1;
      if (idx >= slides.length) idx = 0;
      current = idx;
      track.style.transform = 'translateX(-' + (current * 100) + '%)';
      dots.forEach(function (d, i) { d.classList.toggle('active', i === current); });
    }
    function advance() { goTo(current + 1); }
    function startAuto() { stopAuto(); timer = setInterval(advance, 5000); }
    function stopAuto() { if (timer) { clearInterval(timer); timer = null; } }
    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);
    slider.addEventListener('touchstart', stopAuto, { passive: true });
    slider.addEventListener('touchend', startAuto);
    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { goTo(i); startAuto(); });
    });
    startAuto();
  });

  /* ---------- FORM VALIDATION ---------- */
  function validateField(field) {
    var parent = field.closest('.form-group') || field.parentNode;
    var errorEl = parent.querySelector('.field-error');
    if (errorEl) errorEl.remove();
    field.classList.remove('field-invalid', 'field-valid');
    var rules = [];
    if (field.required || field.hasAttribute('data-msg-required')) {
      rules.push({ test: function (v) { return v.trim() !== ''; }, msg: field.getAttribute('data-msg-required') || 'Ce champ est requis.' });
    }
    if (field.type === 'email' && field.hasAttribute('data-msg-email')) {
      rules.push({ test: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }, msg: field.getAttribute('data-msg-email') });
    }
    if (field.hasAttribute('minlength') || field.hasAttribute('data-minlength')) {
      var min = parseInt(field.getAttribute('minlength') || field.getAttribute('data-minlength'));
      rules.push({ test: function (v) { return v.length >= min; }, msg: field.getAttribute('data-msg-minlength') || 'Minimum ' + min + ' caractères.' });
    }
    if (field.hasAttribute('data-msg-tel')) {
      rules.push({ test: function (v) { return /^[0-9\s\+\-\(\)]{8,}$/.test(v); }, msg: field.getAttribute('data-msg-tel') });
    }
    if (field.hasAttribute('data-match')) {
      var targetName = field.getAttribute('data-match');
      var form = field.closest('form');
      var target = form ? form.querySelector('[name="' + targetName + '"]') : null;
      if (target) {
        rules.push({ test: function (v) { return v === target.value; }, msg: field.getAttribute('data-msg-match') || 'Les champs ne correspondent pas.' });
      }
    }
    for (var ri = 0; ri < rules.length; ri++) {
      if (!rules[ri].test(field.value)) {
        field.classList.add('field-invalid');
        var err = document.createElement('div');
        err.className = 'field-error';
        err.textContent = rules[ri].msg;
        parent.appendChild(err);
        return false;
      }
    }
    field.classList.add('field-valid');
    return true;
  }

  document.querySelectorAll('form[data-validate]').forEach(function (form) {
    form.setAttribute('novalidate', '');

    // Real-time validation on blur
    form.querySelectorAll('input, textarea, select').forEach(function (input) {
      input.addEventListener('blur', function () {
        if (this.value.trim() !== '' || this.classList.contains('field-invalid')) {
          validateField(this);
        }
      });
      input.addEventListener('input', function () {
        if (this.classList.contains('field-invalid') || this.classList.contains('field-valid')) {
          validateField(this);
        }
      });
    });

    form.addEventListener('submit', function (e) {
      var firstInvalid = null;
      form.querySelectorAll('input, textarea, select').forEach(function (field) {
        if (!validateField(field) && !firstInvalid) {
          firstInvalid = field;
        }
      });
      if (firstInvalid) {
        e.preventDefault();
        firstInvalid.focus();
      }
    });
  });

  /* ---------- PASSWORD VISIBILITY TOGGLE ---------- */
  document.querySelectorAll('.pwd-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = this.parentElement.querySelector('input');
      if (input.type === 'password') { input.type = 'text'; this.textContent = '\uD83D\uDE48'; }
      else { input.type = 'password'; this.textContent = '\uD83D\uDC41'; }
    });
  });

  /* ---------- SCROLL PROGRESS BAR ---------- */
  var progressBar = document.querySelector('.scroll-progress');
  if (!progressBar) {
    progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);
  }
  window.addEventListener('scroll', function () {
    var scrollTop = window.scrollY;
    var docHeight = document.documentElement.scrollHeight - window.innerHeight;
    var pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    progressBar.style.width = pct + '%';
  });

});
