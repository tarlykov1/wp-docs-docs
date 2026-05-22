#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT/wp-document-library-ru"
zip -r "$ROOT/dist/wp-document-library-ru.zip" wp-document-library-ru.php assets includes readme.txt
