# Translation workflow

1. Run `composer run make-pot` from this plugin directory after changing translatable PHP strings.
2. Create or update a locale-specific `.po` file from the POT catalog, for example `nyforms-es_ES.po`.
3. Compile the `.po` file to its matching `.mo` file and include both files in the release package.

The plugin loads translations from this directory on WordPress `init`.
