'use strict';

const { defineConfig } = require('@playwright/test');
const baseModule = require('@wordpress/scripts/config/playwright.config');
const baseConfig = baseModule.default || baseModule;

module.exports = defineConfig({
  ...baseConfig,
  testDir: './tests/e2e',
  fullyParallel: false,
  workers: 1,
  retries: 1,
  use: {
    ...baseConfig.use,
    baseURL: 'http://localhost:8889',
    trace: 'retain-on-failure',
    screenshot: 'only-on-failure'
  },
  reporter: [['line'], ['html', { open: 'never' }]]
});
