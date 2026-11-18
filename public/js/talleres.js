const PM = window.PM, $ = id => document.getElementById(id);
const months = PM.months;
let current = 0;

function cards(items) {
  return items.length
    ? items.map(x => `<article class="poster"><img src="${x.src}" alt="Cartel: ${x.title}" loading="lazy"><div class="meta"><strong>${x.title}</strong><small>${[x.date, x.place].filter(Boolean).join(' · ')}</small></div></article>`).join('')
    : '<div class="empty">Todavía no hay carteles publicados para este mes.</div>';
}
function zoom() {
  document.querySelectorAll('.poster img').forEach(img => img.onclick = () => { $('large').src = img.src; $('large').alt = img.alt; $('viewer').showModal(); });
}
function nav(prefix) {
  const v = $(prefix + 'view'), prev = $(prefix + 'prev'), next = $(prefix + 'next');
  function update() { const max = v.scrollWidth - v.clientWidth; prev.disabled = v.scrollLeft < 10; next.disabled = max < 10 || v.scrollLeft >= max - 10; }
  function move(d) { v.scrollBy({ left: d * ((v.querySelector('.poster')?.getBoundingClientRect().width || 400) + 18), behavior: 'smooth' }); setTimeout(update, 400); }
  prev.onclick = () => move(-1); next.onclick = () => move(1);
  v.addEventListener('scroll', update, { passive: true });
  return update;
}
const updateW = nav('w'), updateR = nav('r'), updateP = nav('p');

function render() {
  const m = months[current];
  $('monthTitle').textContent = m.label;
  $('months').innerHTML = months.map((x, i) => `<button data-i="${i}" class="${i === current ? 'active' : ''}" aria-pressed="${i === current}">${x.name}</button>`).join('');
  document.querySelectorAll('[data-i]').forEach(b => b.onclick = () => { current = Number(b.dataset.i); render(); });
  $('wtrack').innerHTML = cards(PM.workshops.filter(x => x.month === m.key));
  $('wview').scrollLeft = 0; zoom(); setTimeout(updateW, 30);
}
$('rtitle').textContent = PM.retreats.length ? [PM.retreats[0].title, PM.retreats[0].date].filter(Boolean).join(' · ') : 'Próximamente';
$('ptitle').textContent = PM.past.length ? PM.past[0].title : 'Aún no hay retiros publicados';
$('rtrack').innerHTML = cards(PM.retreats);
$('ptrack').innerHTML = cards(PM.past);
render(); zoom();
setTimeout(updateR, 30); setTimeout(updateP, 30);
$('close').onclick = () => $('viewer').close();
$('viewer').onclick = e => { if (e.target === $('viewer')) $('viewer').close(); };
