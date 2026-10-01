# Classifieds for Geeklog

Classifieds provides small classified ads integrated with Geeklog permissions, users, search, comments, autotags and administration.

Development branch: `classifieds_1.4.0`  
Current development version: `1.4.0`

## Compatibility target

- Geeklog 2.1.1 through 2.2.2
- PHP 5.6 through PHP 8.1

The compatibility declaration is the target for the 1.4.0 modernization work and still requires the complete runtime test matrix before the final release.

## Upgrade baseline

Classifieds 1.4.0 has one explicit in-place upgrade baseline:

- Classifieds 1.3.2 → Classifieds 1.4.0

Installations older than 1.3.2 should first be upgraded with the historical 1.3.2 package. This keeps the 1.4.0 migration small, deterministic and safe for shared-files deployments.

## 1.4.0 modernization

The 1.4.0 branch:

- removes all installation and upgrade telemetry;
- integrates the historical Pro functions into the standard plugin;
- removes the Pro/limited-edition runtime model;
- supports PHP 8-compatible code paths;
- removes TimThumb and renders local uploaded images directly;
- removes obsolete Google+, Facebook and Twitter widget scripts;
- modernizes Geeklog Configuration metadata, tabs and tooltips;
- uses InnoDB for fresh installs and upgrades existing Classifieds tables;
- modernizes administration navigation and frontend templates;
- exposes Item Info, URL resolution, lifecycle, sitemap, capabilities and dashboard summary contracts;
- uses transactional ad persistence and explicit lifecycle events;
- keeps existing ad IDs, tables and public URL structure.

Legacy `classifieds_data/proversion/proversion.php` files are ignored by 1.4.0 code and are not deleted automatically.

The public plugin route is now canonicalized to `/classifieds` and is no longer an editable Geeklog Configuration setting. During an upgrade, a historical custom public folder is retained only as hidden compatibility when that directory actually exists on disk.

## Publication access policy

Classifieds preserves its historical publication-access behavior:

- if no group is assigned the `classifieds.publish` feature, every registered (logged-in) user may publish ads;
- as soon as one or more groups are assigned `classifieds.publish`, publication is restricted to users who have that feature through those groups;
- anonymous users cannot publish.

This makes `classifieds.publish` an optional restriction mechanism rather than a mandatory setup step. Existing sites that already reserve publication to one or more dedicated groups keep that behavior unchanged.

## Category CSV import

Category administration can import a UTF-8 CSV file with the columns:

```csv
key,category,parent_key,order
vehicles,Vehicles,,10
cars,Cars,vehicles,10
motorcycles,Motorcycles,vehicles,20
```

`key` and `parent_key` are import-only identifiers used to resolve the hierarchy; the database keeps its native `cid` / `pid` structure. Root categories use an empty `parent_key`. Rows may appear in any order. The importer validates the complete file before writing, detects missing parents and cycles, previews create/skip actions, skips categories already present under the same parent, and revalidates on confirmation.

See `docs/category-csv-import.md` for the complete end-user guide, examples and spreadsheet/export recommendations.

## Images

Uploaded ad images remain in the site-scoped Geeklog public image directory:

`images/classifieds/`

The plugin creates/checks that directory during installation and upgrade. Images are resized through Geeklog's upload/image support and displayed directly; there is no remote image proxy or TimThumb dependency.

## Privacy

Classifieds 1.4.0 performs no developer telemetry and does not contact third-party social networks merely because a visitor views an ad.

## Development status

This branch is not yet a final release. Runtime validation is still required for fresh install, 1.3.2 upgrade, PHP compatibility, shared-files multisite, notifications, scheduled expiration, republishing, image operations and the Geeklog interoperability APIs.

See `ROADMAP.md` and `RELEASE_NOTES.md` for details.
