const PM = window.PM, $ = id => document.getElementById(id);
const months = PM.months;
let mi = 0, idx = 0;

function render() {
  if (!months.length) { document.querySelector('.panel').style.display = 'none'; $('monthsBar').style.display = 'none'; return; }
  const m = months[mi], a = m.items;
  idx = (idx + a.length) % a.length;
  $('monthTitle').textContent = m.name;
  $('counter').textContent = (idx + 1) + ' de ' + a.length;
  $('poster').src = a[idx].src;
  $('poster').alt = 'Cartel: ' + a[idx].name;
  $('posterName').textContent = a[idx].name;
  $('prev').disabled = $('next').disabled = a.length === 1;
  document.querySelectorAll('.month').forEach((b, i) => b.classList.toggle('active', i === mi));
}
$('monthsBar').innerHTML = months.map((m, i) => `<button class="month" data-i="${i}">${m.name}</button>`).join('');
document.querySelectorAll('.month').forEach(b => b.onclick = () => { mi = Number(b.dataset.i); idx = 0; render(); });
$('prev').onclick = () => { idx--; render(); };
$('next').onclick = () => { idx++; render(); };

let touchX = 0;
$('poster').addEventListener('touchstart', e => touchX = e.touches[0].clientX, { passive: true });
$('poster').addEventListener('touchend', e => { const dx = e.changedTouches[0].clientX - touchX; if (Math.abs(dx) > 35) { idx += dx < 0 ? 1 : -1; render(); } }, { passive: true });

function zoom(src) { $('large').src = src; $('lightbox').classList.add('show'); }
$('poster').onclick = () => zoom($('poster').src);
document.querySelectorAll('.retreat img').forEach(img => img.onclick = () => zoom(img.src));
$('close').onclick = () => $('lightbox').classList.remove('show');
$('lightbox').onclick = e => { if (e.target === $('lightbox')) $('lightbox').classList.remove('show'); };
document.addEventListener('keydown', e => { if (e.key === 'Escape') $('lightbox').classList.remove('show'); });
render();
