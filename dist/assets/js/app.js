/* Arusuvai Mess — shared interactions */
(function () {
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

  // Sticky nav shadow
  const nav = $('.nav');
  if (nav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 10);
    onScroll(); window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Mobile menu
  $$('[data-burger]').forEach(b => b.addEventListener('click', () => $('.mobile-menu')?.classList.toggle('open')));

  // Dropdowns (language, notifications)
  $$('[data-dropdown]').forEach(wrap => {
    const btn = wrap.querySelector('[data-dropdown-btn]');
    const menu = wrap.querySelector('[data-dropdown-menu]');
    btn?.addEventListener('click', e => {
      e.stopPropagation();
      const open = !(wrap.classList.contains('open') || menu?.classList.contains('open'));
      $$('[data-dropdown]').forEach(w => { w.classList.remove('open'); w.querySelector('[data-dropdown-menu]')?.classList.remove('open'); });
      wrap.classList.toggle('open', open); menu?.classList.toggle('open', open);
    });
  });
  document.addEventListener('click', e => {
    $$('[data-dropdown]').forEach(w => {
      if (!w.contains(e.target)) { w.classList.remove('open'); w.querySelector('[data-dropdown-menu]')?.classList.remove('open'); }
    });
  });

  // Dashboard sidebar (mobile)
  $$('[data-side-toggle]').forEach(b => b.addEventListener('click', () => $('.side')?.classList.toggle('open')));

  // Reveal on scroll
  const io = 'IntersectionObserver' in window ? new IntersectionObserver(entries => {
    entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
  }, { threshold: .12, rootMargin: '0px 0px -40px 0px' }) : null;
  $$('.reveal').forEach(el => io ? io.observe(el) : el.classList.add('in'));

  // Count-up numbers
  const counters = $$('[data-count]');
  const cio = 'IntersectionObserver' in window ? new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      const el = en.target, end = parseFloat(el.dataset.count), dur = 1400, t0 = performance.now();
      const fmt = v => (el.dataset.prefix || '') + Math.round(v).toLocaleString() + (el.dataset.suffix || '');
      const tick = t => { const p = Math.min(1, (t - t0) / dur); el.textContent = fmt(end * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(tick); };
      requestAnimationFrame(tick); cio.unobserve(el);
    });
  }, { threshold: .4 }) : null;
  counters.forEach(c => cio ? cio.observe(c) : null);

  // Segmented control with sliding thumb
  window.initSeg = function (seg, onChange) {
    const thumb = seg.querySelector('.thumb');
    const btns = $$('button', seg);
    const move = b => { if (thumb) { thumb.style.left = b.offsetLeft + 'px'; thumb.style.width = b.offsetWidth + 'px'; } };
    btns.forEach(b => b.addEventListener('click', () => {
      btns.forEach(x => x.classList.remove('on')); b.classList.add('on'); move(b); onChange && onChange(b.dataset.value);
    }));
    const on = seg.querySelector('button.on') || btns[0];
    requestAnimationFrame(() => move(on));
    window.addEventListener('resize', () => move(seg.querySelector('button.on')));
  };

  // Toasts
  window.toast = function (title, msg, icon = '🔔', ms = 4200) {
    let wrap = $('.toasts');
    if (!wrap) { wrap = document.createElement('div'); wrap.className = 'toasts'; document.body.appendChild(wrap); }
    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = `<i>${icon}</i><div><b></b><small></small></div>`;
    t.querySelector('b').textContent = title; t.querySelector('small').textContent = msg;
    wrap.appendChild(t);
    setTimeout(() => { t.style.transition = '.4s'; t.style.opacity = 0; t.style.transform = 'translateY(10px)'; setTimeout(() => t.remove(), 400); }, ms);
  };
  $$('[data-toast]').forEach(b => b.addEventListener('click', e => {
    if (b.tagName === 'A' && b.getAttribute('href') === '#') e.preventDefault();
    const [title, msg, icon] = b.dataset.toast.split('|'); toast(title, msg || '', icon || '✅');
  }));

  // Confetti
  window.confetti = function () {
    const c = document.createElement('canvas'); c.className = 'confetti'; document.body.appendChild(c);
    const ctx = c.getContext('2d'); const W = c.width = innerWidth, H = c.height = innerHeight;
    const cols = ['#f4b41a', '#ee7a1b', '#c73a1d', '#2e8b4e', '#17603a', '#fff1c9'];
    const ps = Array.from({ length: 160 }, () => ({ x: W / 2 + (Math.random() - .5) * 200, y: H / 3, vx: (Math.random() - .5) * 16, vy: Math.random() * -14 - 4, r: Math.random() * 7 + 4, c: cols[Math.random() * cols.length | 0], a: Math.random() * 6, s: Math.random() * .3 - .15 }));
    let f = 0;
    (function draw() {
      ctx.clearRect(0, 0, W, H);
      ps.forEach(p => { p.vy += .35; p.x += p.vx; p.y += p.vy; p.vx *= .99; p.a += p.s; ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.a); ctx.fillStyle = p.c; ctx.fillRect(-p.r / 2, -p.r / 4, p.r, p.r / 2); ctx.restore(); });
      if (++f < 220) requestAnimationFrame(draw); else c.remove();
    })();
  };
})();
