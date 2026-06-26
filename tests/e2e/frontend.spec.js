"use strict";

const AxeBuilder = require("@axe-core/playwright").default;
const { expect, test } = require("@playwright/test");

const collectBrowserErrors = (page) => {
  const errors = [];

  page.on("console", (message) => {
    if (message.type() === "error") {
      errors.push(`console: ${message.text()}`);
    }
  });

  page.on("pageerror", (error) => {
    errors.push(`pageerror: ${error.message}`);
  });

  return errors;
};

test("front page renders the required accessible shell without browser errors", async ({
  page,
}) => {
  const browserErrors = collectBrowserErrors(page);

  await page.goto("/");

  await expect(page.locator("html")).toHaveAttribute("lang", /.+/);
  await expect(
    page.getByRole("link", { name: "Skip to content" }),
  ).toHaveAttribute("href", "#primary");
  await expect(
    page.getByRole("navigation", { name: "Primary navigation" }),
  ).toBeVisible();
  await expect(page.locator("main#primary")).toBeVisible();
  await expect(page.locator("footer")).toBeVisible();
  expect(browserErrors).toEqual([]);
});

test("mobile menu opens, closes with Escape, and restores focus", async ({
  page,
}) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto("/");

  const menuButton = page.getByRole("button", { name: "Menu" });
  const navigation = page.getByRole("navigation", {
    name: "Primary navigation",
  });

  await expect(menuButton).toHaveAttribute("aria-expanded", "false");
  await menuButton.click();
  await expect(menuButton).toHaveAttribute("aria-expanded", "true");
  await expect(navigation).toHaveClass(/is-open/);

  await page.keyboard.press("Escape");
  await expect(menuButton).toHaveAttribute("aria-expanded", "false");
  await expect(navigation).not.toHaveClass(/is-open/);
  await expect(menuButton).toBeFocused();
});

test("front page has no serious or critical automated accessibility violations", async ({
  page,
}) => {
  await page.goto("/");

  const results = await new AxeBuilder({ page })
    .withTags(["wcag2a", "wcag2aa", "wcag21a", "wcag21aa"])
    .analyze();

  const blockingViolations = results.violations.filter((violation) =>
    ["serious", "critical"].includes(violation.impact),
  );

  expect(blockingViolations).toEqual([]);
});
