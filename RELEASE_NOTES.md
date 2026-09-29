# Classifieds 1.4.0-dev release notes

Development branch: `classifieds_1.4.0`

## Integrated in the current development snapshot

- Removed installation telemetry that emailed site URL, site name, plugin version and edition information to the former developer address.
- Removed equivalent telemetry from the plugin upgrade path.
- Integrated the historical Pro lifecycle notification functions into the standard plugin.
- User and administrator lifecycle notifications are now independent; disabling user mail no longer suppresses enabled administrator mail.
- Integrated the scheduled expiration task.
- Expiration state is only marked notified after the enabled notification path completes successfully; failures remain retryable.
- Integrated republish/copy functionality into the standard plugin.
- Integrated image copying used when republishing an ad.
- The original ad is preserved when creation or image copy of the replacement fails.
- Removed runtime loading of `{path_data}/classifieds_data/proversion/proversion.php`.
- Existing legacy Pro files are intentionally left untouched and ignored, avoiding destructive migration.
- Removed "limited edition" / "Pro version" labels from maintained English and French language files.
- Set development code version to `1.4.0-dev`.
- Protected the normal 1.3.2 -> 1.4.0 upgrade from the old public-folder rename/delete path so shared-files deployments do not mutate shared public files during a normal modern upgrade.

## Historical Pro category seed

The supplied `catsql_english.php` was reviewed but is not imported automatically in this development snapshot. Despite its filename, most category labels are French and the list is a broad opinionated marketplace taxonomy. Automatically inserting it would be inappropriate for existing sites and questionable as a default for new sites.

A later installer cleanup may expose category seed data as an explicit optional choice.

## Still pending before 1.4.0 final

See `ROADMAP.md`. Major remaining work includes:

- PHP 8 compatibility audit of the base plugin;
- input/SQL/output security pass;
- TimThumb removal;
- configuration metadata modernization for Geeklog 2.2.2;
- admin and frontend modernization;
- interoperability APIs, sitemap and metadata;
- database/install modernization;
- complete fresh-install, upgrade and shared-files test matrix.

This development snapshot is not yet a final release.


## PHP 8 and write-path hardening

The current development snapshot also includes the first compatibility/security pass:

- removed PHP 8-incompatible `each()` use;
- removed legacy magic-quotes-era argument rewriting from image handling;
- request filtering now tolerates absent keys and rejects unexpected array values for scalar fields;
- ad create/edit/delete/copy/republish state changes now enforce Geeklog CSRF tokens;
- category create/edit/delete state changes now enforce Geeklog CSRF tokens;
- category forms now submit the native Geeklog CSRF token;
- ad/category persistence now uses validated numeric values and `DB_escapeString()` instead of `addslashes()`;
- fixed undefined form data and route variables that produced PHP 8 warnings;
- fixed the active-ad pagination count implementation, which could fail on PHP 8 because an integer was treated as an array;
- removed the final runtime/admin check for the old Pro file.

The broader security/PHP audit is still in progress; this is not yet the final 1.4.0 release.
