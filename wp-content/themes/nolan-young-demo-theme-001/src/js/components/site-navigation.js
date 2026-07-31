export const initSiteNavigation = () => {
  const navigation = document.querySelector('.site-navigation');
  const toggle = document.querySelector('[data-nav-toggle]');
  const overlay = document.querySelector('[data-mega-overlay]');
  const menuItems = [...document.querySelectorAll('[data-mega-item]')];
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
    closeAll(item);
    panelFor(item)?.classList.add('is-open');
    triggerFor(item)?.setAttribute('aria-expanded', 'true');
    syncOverlay();
  };

  menuItems.forEach((item) => {
    const trigger = triggerFor(item);
    const panel = panelFor(item);

    trigger?.addEventListener('click', () => {
      const isOpen = panel?.classList.contains('is-open');
      if (isOpen) {
        closeItem(item);
        syncOverlay();
      } else {
        openItem(item);
      }
    });

    const serviceTabs = [...item.querySelectorAll('[data-service-tab]')];
    const servicePanels = [...item.querySelectorAll('[data-service-panel]')];

    const activateService = (activeTab) => {
      const activePanelId = activeTab.getAttribute('aria-controls');

      serviceTabs.forEach((tab) => {
        const isActive = tab === activeTab;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', String(isActive));
        tab.tabIndex = isActive ? 0 : -1;
      });

      servicePanels.forEach((servicePanel) => {
        const isActive = servicePanel.id === activePanelId;
        const shouldAnimate = isActive && servicePanel.hidden;

        servicePanel.hidden = !isActive;
        servicePanel.classList.toggle('is-active', isActive);

        if (shouldAnimate) {
          servicePanel.classList.remove('is-entering');
          window.requestAnimationFrame(() => servicePanel.classList.add('is-entering'));
        }
      });
    };

    serviceTabs.forEach((tab, index) => {
      tab.addEventListener('pointerenter', () => activateService(tab));
      tab.addEventListener('focus', () => activateService(tab));
      tab.addEventListener('click', () => activateService(tab));
      tab.addEventListener('keydown', (event) => {
        const keyTargets = {
          ArrowDown: (index + 1) % serviceTabs.length,
          ArrowRight: (index + 1) % serviceTabs.length,
          ArrowUp: (index - 1 + serviceTabs.length) % serviceTabs.length,
          ArrowLeft: (index - 1 + serviceTabs.length) % serviceTabs.length,
          Home: 0,
          End: serviceTabs.length - 1,
        };

        if (!(event.key in keyTargets)) return;

        event.preventDefault();
        serviceTabs[keyTargets[event.key]].focus();
      });
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
