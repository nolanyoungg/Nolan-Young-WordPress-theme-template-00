#!/usr/bin/env bash

set -euo pipefail

readonly max_tracked_bytes=$((5 * 1024 * 1024))
declare -a forbidden_paths=()
declare -a oversized_paths=()
tracked_count=0
failed=0

while IFS= read -r -d '' file; do
	tracked_count=$((tracked_count + 1))
	lower_path="$(printf '%s' "$file" | LC_ALL=C tr '[:upper:]' '[:lower:]')"
	base_name="${lower_path##*/}"
	wrapped_path="/${lower_path}/"
	forbidden=0

	case "$wrapped_path" in
		*/node_modules/* | */vendor/* | */coverage/* | */.idea/* | */.vscode/* | \
			*/wp-admin/* | */wp-includes/* | */wp-content/uploads/*)
			forbidden=1
			;;
	esac

	if [[ "$lower_path" != */* && "$lower_path" == wp-*.php ]]; then
		forbidden=1
	fi

	case "$base_name" in
		.env | .env.*)
			if [[ "$base_name" != ".env.example" ]]; then
				forbidden=1
			fi
			;;
		.ds_store | thumbs.db | auth.json | .npmrc | .phpunit.result.cache | \
			wp-config.php | local-config.php | wp-config-local.php)
			forbidden=1
			;;
	esac

	case "$lower_path" in
		*.sql | *.sql.gz | *.sqlite | *.sqlite3 | *.db | *.wpress | \
			*.pem | *.key | *.p12 | *.pfx | *.jks | *.keystore | \
			*.crt | *.cer | *.log | *.zip | *.tar | *.tar.gz | \
			*.tgz | *.rar | *.7z | *.phar)
			forbidden=1
			;;
	esac

	if (( forbidden != 0 )); then
		forbidden_paths+=( "$file" )
	fi

	size="$(git cat-file -s ":$file")"
	if (( size > max_tracked_bytes )); then
		oversized_paths+=( "${size}:${file}" )
	fi
done < <(git ls-files -z)

if (( ${#forbidden_paths[@]} > 0 )); then
	echo "Forbidden tracked paths were found:"
	printf ' - %q\n' "${forbidden_paths[@]}"
	failed=1
fi

if (( ${#oversized_paths[@]} > 0 )); then
	echo "Tracked files over the 5 MiB limit were found:"
	for entry in "${oversized_paths[@]}"; do
		size="${entry%%:*}"
		file="${entry#*:}"
		printf ' - %s bytes: %q\n' "$size" "$file"
	done
	failed=1
fi

if (( $# > 0 )) && ! git diff --check "$@" >/dev/null 2>&1; then
	echo "Git diff whitespace validation failed; run git diff --check locally."
	failed=1
fi

if (( failed != 0 )); then
	exit 1
fi

echo "Repository guardrails passed for ${tracked_count} tracked files."
