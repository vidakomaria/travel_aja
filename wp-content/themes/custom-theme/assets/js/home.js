(() => {
 const form = document.querySelector('#itinerary-form');
 if (!form) return;
 const date = form.querySelector('[name="tanggal"]');
 const now = new Date();
 date.min = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}`;
 form.querySelectorAll('.interest-chip').forEach(button => button.addEventListener('click', () => {
  const selected = button.getAttribute('aria-pressed') !== 'true';
  button.setAttribute('aria-pressed', String(selected)); button.classList.toggle('selected', selected);
 }));
 form.addEventListener('submit', event => {
  event.preventDefault();
  if (!form.reportValidity()) return;
  const interests = [...form.querySelectorAll('.interest-chip[aria-pressed="true"]')].map(b => b.dataset.interest);
  const status = form.querySelector('#trip-status');
  const link = form.querySelector('#trip-whatsapp-link');
  link.hidden = true; status.hidden = false;
  if (!interests.length) { status.textContent = 'Pilih minimal satu pilihan perjalanan.'; return; }
  const pax = form.querySelector('[name="pax"]'); const budget = form.querySelector('[name="budget"]');
  const message = `Halo, saya ingin merencanakan perjalanan.\nJumlah wisatawan: ${pax.selectedOptions[0].textContent.trim()}\nAnggaran per orang: ${budget.selectedOptions[0].textContent.trim()}\nTanggal: ${date.value}\nPilihan: ${interests.join(', ')}`;
  const number = (form.dataset.whatsapp || '').replace(/\D/g, '');
  status.textContent = number ? 'Ringkasan siap. Buka WhatsApp untuk meninjau dan mengirim permintaan Anda.' : `${message}\n\nKontak WhatsApp belum tersedia. Silakan simpan ringkasan perjalanan ini.`;
  if (number) { link.href = `https://wa.me/${number}?text=${encodeURIComponent(message)}`; link.hidden = false; }
 });
})();
