document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('contact-trip-form');
	const status = document.getElementById('contact-trip-status');
	if (!form || !status) return;
	form.addEventListener('submit', function (event) {
		event.preventDefault();
		const data = new FormData(form);
		const isEnglish = document.documentElement.lang.toLowerCase().startsWith('en');
		const fields = isEnglish
			? [['Name', 'name'], ['Group size', 'people'], ['Budget per person', 'budget'], ['Departure date', 'date'], ['Destinations or activities', 'interest'], ['Notes', 'notes']]
			: [['Nama', 'name'], ['Jumlah orang', 'people'], ['Budget per orang', 'budget'], ['Tanggal keberangkatan', 'date'], ['Minat/destinasi', 'interest'], ['Catatan', 'notes']];
		const details = fields
			.map(function ([label, key]) {
				const value = String(data.get(key) || '').trim();
				return value ? label + ': ' + value : '';
			})
			.filter(Boolean);
		const greeting = isEnglish
			? 'Hello Travel Aja, I would like to ask about planning a trip.'
			: 'Halo Travel Aja, saya ingin berkonsultasi tentang perjalanan.';
		const message = [greeting, ...details].join('\n');
		const number = (form.dataset.whatsapp || '').replace(/\D/g, '');
		if (number) {
			window.open('https://wa.me/' + number + '?text=' + encodeURIComponent(message), '_blank', 'noopener');
			status.textContent = 'WhatsApp dibuka dengan ringkasan perjalanan Anda.';
		} else {
			status.textContent = 'Ringkasan perjalanan Anda:\n\n' + message + '\n\nIsi nomor WhatsApp melalui Appearance → Customize → Kontak & Footer agar formulir dapat mengirim ke WhatsApp.';
		}
	});
});
