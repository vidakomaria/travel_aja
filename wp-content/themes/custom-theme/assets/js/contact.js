document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('contact-trip-form');
	const status = document.getElementById('contact-trip-status');
	if (!form || !status) return;
	form.addEventListener('submit', function (event) {
		event.preventDefault();
		if (!form.reportValidity()) return;
		const data = new FormData(form);
		const message = [
			'Halo Transijen, saya ingin berkonsultasi tentang perjalanan.',
			'',
			'Nama: ' + data.get('name'),
			'Jumlah orang: ' + data.get('people'),
			'Budget per orang: ' + data.get('budget'),
			'Tanggal keberangkatan: ' + data.get('date'),
			'Minat/destinasi: ' + (data.get('interest') || '-'),
			'Catatan: ' + (data.get('notes') || '-')
		].join('\n');
		const number = (form.dataset.whatsapp || '').replace(/\D/g, '');
		if (number) {
			window.open('https://wa.me/' + number + '?text=' + encodeURIComponent(message), '_blank', 'noopener');
			status.textContent = 'WhatsApp dibuka dengan ringkasan perjalanan Anda.';
		} else {
			status.textContent = 'Ringkasan perjalanan Anda:\n\n' + message + '\n\nIsi nomor WhatsApp melalui Appearance → Customize → Kontak & Footer agar formulir dapat mengirim ke WhatsApp.';
		}
	});
});
