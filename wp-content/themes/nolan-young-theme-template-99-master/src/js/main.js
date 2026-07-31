import { initAccordions } from './components/accordion';
import { initArticleContents, initCopyArticleLink } from './components/article-contents';
import { initMetrics } from './components/metrics';
import { initModals } from './components/modal';
import { initReadingProgress } from './components/reading-progress';
import { initReveal } from './components/reveal';
import { initSiteNavigation } from './components/site-navigation';
import { initTabs } from './components/tabs';
import { initWorkFilter } from './components/work-filter';

document.addEventListener('DOMContentLoaded', () => {
  initSiteNavigation();
  initAccordions();
  initArticleContents();
  initCopyArticleLink();
  initModals();
  initTabs();
  initReveal();
  initMetrics();
  initWorkFilter();
  initReadingProgress();
});
