const PM = window.PM, $ = id => document.getElementById(id);
const months = PM.months;                  // solo meses con carteles, desde el mes actual
const view = $('pview'), track = $('ptrack'), prev = $('prev'), next = $('next');
let mi = 0;                                // el primero es el mes en curso (o el siguiente con carteles)

// Las flechas solo aparecen si los carteles no caben (más de 4 en escritorio)
function arrows() {
  const need = view.scrollWidth > view.clientWidth + 4;
  prev.hidden = next.hidden = !need;
  if (need) {
    prev.disabled = view.scrollLeft < 6;
    next.disabled = view.scrollLeft >= view.scrollWidth - view.clientWidth - 6;
  }
}
const step = () => (track.querySelector('.pcard')?.getBoundingClientRect().width || 240) + 14;

function render() {
  if (!months.length) { document.querySelector('.panel').style.display = 'none'; $('monthsBar').style.display = 'none'; return; }
  const m = months[mi];
  $('monthTitle').textContent = m.name;
  $('counter').textContent = m.items.length + (m.items.length === 1 ? ' cartel' : ' carteles');
  track.innerHTML = m.items.map(x =>
    `<figure class="pcard"><img src="${x.src}" alt="Cartel: ${x.name}" loading="lazy"><figcaption>${x.name}</figcaption></figure>`).join('');
  track.querySelectorAll('img').forEach(img => img.onclick = () => zoom(img.src));
  view.scrollLeft = 0;
  document.querySelectorAll('.month').forEach((b, i) => b.classList.toggle('active', i === mi));
  requestAnimationFrame(arrows);
}

$('monthsBar').innerHTML = months.map((m, i) => `<button class="month" data-i="${i}">${m.name}</button>`).join('');
document.querySelectorAll('.month').forEach(b => b.onclick = () => { mi = Number(b.dataset.i); render(); });
prev.onclick = () => view.scrollBy({ left: -step(), behavior: 'smooth' });
next.onclick = () => view.scrollBy({ left: step(), behavior: 'smooth' });
view.addEventListener('scroll', arrows, { passive: true });
addEventListener('resize', arrows);
addEventListener('load', arrows);
// se recalcula cuando el diseño cambia de tamaño (carga de fuentes, giro del móvil, etc.)
if ('ResizeObserver' in window) { const ro = new ResizeObserver(arrows); ro.observe(view); ro.observe(track); }

function zoom(src) { $('large').src = src; $('lightbox').classList.add('show'); }
document.querySelectorAll('.retreat img').forEach(img => img.onclick = () => zoom(img.src));
$('close').onclick = () => $('lightbox').classList.remove('show');
$('lightbox').onclick = e => { if (e.target === $('lightbox')) $('lightbox').classList.remove('show'); };
document.addEventListener('keydown', e => { if (e.key === 'Escape') $('lightbox').classList.remove('show'); });
render();
