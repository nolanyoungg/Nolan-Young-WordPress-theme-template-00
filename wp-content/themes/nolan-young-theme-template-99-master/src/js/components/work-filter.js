export const initWorkFilter = () => {
  const controls = [...document.querySelectorAll('[data-work-filter]')];
  const projects = [...document.querySelectorAll('[data-project-category]')];
  if (!controls.length || !projects.length) return;

  controls.forEach((control) => control.addEventListener('click', () => {
    const filter = control.dataset.workFilter;
    controls.forEach((candidate) => candidate.classList.toggle('is-active', candidate === control));
    projects.forEach((project) => {
      project.hidden = filter !== 'all' && project.dataset.projectCategory !== filter;
    });
  }));
};
