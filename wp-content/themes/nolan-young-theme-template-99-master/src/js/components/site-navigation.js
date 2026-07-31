const OPEN_DELAY = 120;
const CLOSE_DELAY = 180;

export const initSiteNavigation = () => {
  const navigation = document.querySelector('.site-navigation');
  const toggle = document.querySelector('[data-nav-toggle]');
  const overlay = document.querySelector('[data-mega-overlay]');
  const menuItems = [...document.querySelectorAll('[data-mega-item]')];
  let openTimer;
  let closeTimer;

  if (!navigation || !toggle) return;

  const panelFor = (item) => item?.querySelector('[data-mega-panel]');
  const triggerFor = (item) => item?.querySelector('[data-mega-trigger]');

  const closeItem = (item, restoreFocus = false) => {
    const panel = panelFor(item);
    const trigger = triggerFor(item);

    panel?.classList.remove('is-open');
    trigger?.setAttribute('aria-expanded', 'false');
    if (restoreFocus) trigger?.focus();
  };

  const syncOverlay = () => {
    const hasOpenPanel = menuItems.some((item) => panelFor(item)?.classList.contains('is-open'));
    overlay?.classList.toggle('is-visible', hasOpenPanel);
    document.body.classList.toggle('is-menu-open', hasOpenPanel || navigation.classList.contains('is-open'));
  };

  const closeAll = (except = null, restoreFocus = false) => {
    menuItems.forEach((item) => {
      if (item !== except) closeItem(item, restoreFocus);
    });
    syncOverlay();
  };

  const openItem = (item) => {
    clearTimeout(closeTimer);
    closeAll(item);
    panelFor(item)?.classList.add('is-open');
    triggerFor(item)?.setAttribute('aria-expanded', 'true');
    syncOverlay();
  };

  menuItems.forEach((item) => {
    const trigger = triggerFor(item);
    const panel = panelFor(item);
    let pointerActivating = false;

    trigger?.addEventListener('pointerdown', () => {
      pointerActivating = true;
    });

    trigger?.addEventListener('click', () => {
      const isOpen = panel?.classList.contains('is-open');
      if (isOpen) {
        closeItem(item);
        syncOverlay();
      } else {
        openItem(item);
      }
      pointerActivating = false;
    });

    item.addEventListener('pointerenter', (event) => {
      if (event.pointerType === 'touch' || window.innerWidth <= 980) return;
      clearTimeout(closeTimer);
      openTimer = window.setTimeout(() => openItem(item), OPEN_DELAY);
    });

    item.addEventListener('pointerleave', (event) => {
      if (event.pointerType === 'touch' || window.innerWidth <= 980) return;
      clearTimeout(openTimer);
      closeTimer = window.setTimeout(() => {
        closeItem(item);
        syncOverlay();
      }, CLOSE_DELAY);
    });

    item.addEventListener('focusin', () => {
      if (!pointerActivating && window.innerWidth > 980) openItem(item);
    });

    item.addEventListener('focusout', (event) => {
      if (window.innerWidth <= 980 || item.contains(event.relatedTarget)) return;

      clearTimeout(closeTimer);
      closeTimer = window.setTimeout(() => {
        closeItem(item);
        syncOverlay();
      }, CLOSE_DELAY);
    });

    item.querySelectorAll('[data-mega-option]').forEach((option) => {
      const updateFeature = () => {
        const feature = item.querySelector('[data-mega-feature]');
        if (!feature) return;

        item.querySelectorAll('[data-mega-option]').forEach((candidate) => {
          candidate.classList.toggle('is-active', candidate === option);
        });

        feature.querySelector('[data-mega-code]').textContent = option.dataset.code || '';
        feature.querySelector('[data-mega-title]').textContent = option.dataset.title || '';
        feature.querySelector('[data-mega-description]').textContent = option.dataset.description || '';

        const links = feature.querySelector('[data-mega-links]');
        let labels = [];
        try {
          labels = JSON.parse(option.dataset.links || '[]');
        } catch {
          labels = [];
        }
        links.replaceChildren(...labels.map((label) => {
          const listItem = document.createElement('li');
          listItem.textContent = label;
          return listItem;
        }));
      };

      option.addEventListener('pointerenter', updateFeature);
      option.addEventListener('focus', updateFeature);
    });

    panel?.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 980) {
          navigation.classList.remove('is-open');
          toggle.setAttribute('aria-expanded', 'false');
        }
        closeAll();
      });
    });
  });

  toggle.addEventListener('click', () => {
    const isOpen = navigation.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(isOpen));
    document.body.classList.toggle('is-menu-open', isOpen);
    if (isOpen) navigation.querySelector('a, button')?.focus();
    else closeAll();
  });

  overlay?.addEventListener('click', () => closeAll());

  document.addEventListener('click', (event) => {
    if (!event.target.closest('.site-header')) closeAll();
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;

    const expanded = menuItems.find((item) => triggerFor(item)?.getAttribute('aria-expanded') === 'true');
    if (expanded) {
      closeAll(null, false);
      triggerFor(expanded)?.focus();
    } else if (navigation.classList.contains('is-open')) {
      navigation.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('is-menu-open');
      toggle.focus();
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) {
      navigation.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    }
    closeAll();
  });
};
