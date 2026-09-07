# Repository agent instructions

| Surface | Audience | Owns |
| --- | --- | --- |
| README.md | Engineers | How to install, use and customise the presets |
| AGENTS.md | Agents | Guardrails |

## Hard rules

A Composer plugin that adds quality-checking tools to a Drupal project. It wraps
[GrumPHP](https://github.com/phpro/grumphp) through its
[shim](https://github.com/phpro/grumphp-shim) and ships Axelerant's presets.

- The `.dist` files are overwritten on every `composer install`. Never change a
  consuming project's `.dist` file to alter behaviour; the change belongs here,
  or in a copy renamed without the suffix in that project.
- Changing a shipped preset changes every project that installs this plugin.
  Treat a rule change as a release, not a tweak.
- The plugin installs git hooks. Anything touching hook installation is tested
  against a real checkout, because a broken hook fails silently at commit time.
- `resources/` holds the files copied into a consuming project; `src/` is the
  plugin that copies them. A new preset needs an entry in both.
- Version constraints here are inherited by every consuming project, so widen
  them deliberately and narrow them only in a major.

## Before claiming done

```bash
composer validate --strict
php ./vendor/bin/grumphp git:init
```

Run the installed `docs_audit.py` against this checkout, and the repository's
own tests.

## Where to look

| Question | File |
| --- | --- |
| What this installs and how to customise it | `README.md` |
| What changed and when | `CHANGELOG.md` |
| Which files land in a consuming project | `resources/` |
