export const focusTrap = (element) => { const items = element.querySelectorAll('a,button,input,textarea,[tabindex]:not([tabindex="-1"])'); if (items[0]) items[0].focus(); };
