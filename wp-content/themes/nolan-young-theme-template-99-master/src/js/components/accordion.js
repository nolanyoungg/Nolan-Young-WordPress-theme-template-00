export const accordions=()=>document.querySelectorAll('[data-accordion]').forEach((item)=>item.addEventListener('click',()=>item.classList.toggle('is-open')));
