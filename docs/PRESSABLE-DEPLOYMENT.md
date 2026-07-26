# Pressable deployment

This repository owns only these WordPress components:

- `wp-content/themes/nolan-young-theme-template-01`
- `wp-content/plugins/nyforms`
- `wp-content/plugins/nymegamenu`

It does not own WordPress core, environment configuration, the database,
uploads, Pressable-managed files, must-use plugins, or other site-installed
themes and plugins.

## GitHub integration paths

Configure the Pressable staging site with:

- Repository: `nolanyoungg/Nolan-Young-WordPress-theme-template-00`
- Deployment branch: `staging`
- Repository subdirectory: `wp-content/`
- Destination path: `wp-content/`
- Deployment exclusions: the committed root `.deployignore`

Configure production with the same paths and `main` only after staging has been
verified. Pressable's integration synchronizes on pushes to the selected branch;
it does not wait for a new post-push CI run. The safe gate is therefore a
protected branch that only accepts pull requests whose required checks already
passed.

Pressable synchronization can delete destination files that are absent from
Git. The root `.deployignore` protects every server-side `wp-content` entry by
default, then allows only this repository's theme and two plugins to
synchronize. It also excludes development sources, dependency directories,
tests, Composer metadata, build tooling, diagnostics, and archives from the
owned components.

Commit and push `.deployignore` before enabling or triggering the integration.
See Pressable's
[Deploy From GitHub documentation](https://pressable.com/knowledgebase/deploy-from-github/)
for the current synchronization behavior.

## Required GitHub settings

After `Repository CI` has completed successfully at least once, configure
branch rules for both `main` and `staging`:

- require a pull request and at least one approval;
- require CODEOWNERS review and dismiss stale approvals;
- require conversation resolution and an up-to-date branch;
- block force pushes, deletions, and direct pushes; and
- require all `Repository CI` checks:
  - `Repository guardrails`
  - `Gitleaks`
  - `Root npm build`
  - `PHP syntax (PHP 7.4)`
  - `PHP syntax (PHP 8.4)`
  - `Composer standards (Theme)`
  - `Composer standards (NYForms)`
  - `Composer standards (NY Mega Menu)`

Keep GitHub secret scanning and push protection enabled. The optional `Theme
Package` workflow must not be a required branch check.

## Staging-first deployment sequence

1. Open a pull request targeting `staging`.
2. Confirm every required `Repository CI` check passes.
3. Run WordPress PHPUnit and runtime checks in a configured WordPress test
   environment when the change affects those paths.
4. Back up the Pressable staging site and inventory its existing themes,
   plugins, must-use plugins, uploads, and other server-owned content.
5. Merge the reviewed commit to `staging`.
6. Confirm the Pressable Git History entry reports a successful deployment.
7. Verify that the owned theme and plugins updated, unrelated server content
   remains intact, and development-only files were not deployed.
8. Smoke-test the frontend, WordPress administration, navigation, forms,
   accessibility paths, and logs.
9. Promote the same verified commit through a pull request to `main`.
10. Confirm required checks again, take a production backup, merge, and monitor
    the production deployment.

## Optional installable theme ZIP

Routine CI runs `npm ci` and `npm run build`; it never packages the theme.
When an installable ZIP is needed, manually run the `Theme Package` workflow or
push a reviewed `v*` version tag. That workflow runs root `npm run package`,
requires exactly one timestamped ZIP, validates its integrity and single theme
root directory, and uploads it as a short-retention artifact.

The ZIP is for WordPress installation and release review. Pressable's GitHub
integration deploys the committed runtime files selected by `.deployignore`,
not the workflow artifact.
