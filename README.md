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

## Images

Uploaded ad images remain in the site-scoped Geeklog public image directory:

`images/classifieds/`

The plugin creates/checks that directory during installation and upgrade. Images are resized through Geeklog's upload/image support and displayed directly; there is no remote image proxy or TimThumb dependency.

## Privacy

Classifieds 1.4.0 performs no developer telemetry and does not contact third-party social networks merely because a visitor views an ad.

## Development status

This branch is not yet a final release. Runtime validation is still required for fresh install, 1.3.2 upgrade, PHP compatibility, shared-files multisite, notifications, scheduled expiration, republishing, image operations and the Geeklog interoperability APIs.

See `ROADMAP.md` and `RELEASE_NOTES.md` for details.
