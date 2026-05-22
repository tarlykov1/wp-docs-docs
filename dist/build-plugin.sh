#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
zip -r "$ROOT/dist/wp-document-library-ru.zip" \
  wp-document-library-ru.php \
  assets \
  includes \
  templates \
  languages \
  readme.txt
