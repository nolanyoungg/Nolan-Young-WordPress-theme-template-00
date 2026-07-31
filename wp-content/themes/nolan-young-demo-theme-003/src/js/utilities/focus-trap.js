export const trapFocus = (container, event) => {
	if (event.key !== 'Tab') return;
	const focusable = [...container.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])')];
	if (!focusable.length) return;
	const first = focusable[0]; const last = focusable[focusable.length - 1];
	if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
	if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
};
