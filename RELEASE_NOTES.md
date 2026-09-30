# Classifieds 1.4.0 release notes

Development branch: `classifieds_1.4.0`

Classifieds 1.4.0 is a modernization release built from the last public 1.3.2 codebase. It keeps the existing content model and public URL structure while removing historical edition, telemetry, image-proxy and compatibility debt.

## Privacy and edition unification

- Removed installation telemetry.
- Removed upgrade telemetry.
- Removed all automatic reporting of site URL, site name, plugin version or edition status to the former developer address.
- Integrated the historical Pro lifecycle email functions into the standard plugin.
- Integrated scheduled expiration notifications.
- Integrated expired-ad republishing and image copying.
- Removed runtime loading of `{path_data}/classifieds_data/proversion/proversion.php`.
- Removed "limited edition" / "Pro version" UI and feature detection.
- Existing legacy Pro files are ignored and intentionally not deleted automatically.
- Historical Pro category seed data is not auto-imported.

There is now one Classifieds edition.

## Upgrade contract

The explicit in-place modernization baseline is:

`Classifieds 1.3.2 → Classifieds 1.4.0`

Older installations should first use the historical 1.3.2 upgrade path. This avoids carrying the 1.0–1.3 migration chain and obsolete filesystem mutations in modern runtime code.

The 1.4 upgrade:

- repairs native Geeklog configuration metadata while preserving administrator values;
- removes obsolete TimThumb settings;
- converts the four Classifieds tables to InnoDB;
- verifies/creates the site-scoped image directory;
- does not rename, delete or sleep on shared public plugin folders.

## PHP and security modernization

- Removed PHP 8-incompatible `each()`.
- Removed magic-quotes-era transformations.
- Removed application `addslashes()` persistence from maintained write paths.
- Normalizes scalar request parameters and rejects unexpected array values.
- Adds CSRF enforcement to ad/category state-changing operations.
- Centralizes ACL checks through Geeklog permissions.
- Fixes undefined-key/undefined-variable paths in forms, profiles, routing and pagination.
- Fixes the historical COUNT/pagination integer-as-array error.
- Rewrites the ad-detail path around explicit ID validation, ACL and publication state.
- Removes inline JavaScript from delete actions.
- Removes duplicated Geeklog user-profile code and uses `USER_showProfile()` directly.

## Contact and reporting

- Replaced copied legacy `profiles.php` mail code with a Classifieds-specific contact/report flow.
- Contact URLs carry only the ad ID.
- Recipient and subject are derived server-side from the ad record.
- Removed the unused "advise to a friend" route and story-based mail code.
- Contact/report sending enforces CSRF, speed-limit, spam and user email-preference checks.
- Report messages go to the site's configured administrator address.

## Ad persistence and lifecycle

New focused modules:

- `lib-ads.php` — transactional ad persistence, profile synchronization and deletion;
- `lib-images.php` — local image persistence;
- `lib-notifications.php` — lifecycle notifications and scheduled expiration;
- `lib-republish.php` — republishing/copy behavior;
- `lib-contact.php` — contact/report workflow.

Ad saves now follow:

`validate → persist → images → commit → profile/notification → lifecycle event`

- Create/edit emits `PLG_itemSaved()` after successful persistence.
- Soft/hard deletion emits `PLG_itemDeleted()`.
- Republishing emits save/delete lifecycle events.
- Existing images are not deleted before replacement uploads succeed.
- A failed replacement upload preserves the existing ad media.

## Images

- Removed `timthumb.php`.
- Removed `timthumb-config.php`.
- Removed TimThumb-only configuration values.
- Images continue to use the existing `images/classifieds/` storage.
- Geeklog upload/image support performs upload validation and optional resize.
- Frontend display uses the local image files directly with responsive CSS and lazy loading.
- No remote image proxy is used.

## Configuration and administration

- Added explicit native configuration tab hierarchy.
- Corrected text settings to use no selection array.
- Changed currency to a normal text setting instead of a nonexistent select-list ID.
- Added English/French tab metadata and configuration tooltips.
- Added upgrade repair for persisted `conf_values` metadata.
- Removed the misleading editable `classifieds_folder` setting from Geeklog Configuration. Fresh installs use the canonical public `/classifieds` directory; upgrades keep an existing custom value hidden only when needed for legacy compatibility, and runtime honors it only when that public directory actually exists.
- Replaced the old admin-menu template with the shared `plugin-admin-nav*` contract.
- Uses `ADMIN_createMenu()` for page-level administration actions.
- Configuration opens Geeklog's native Configuration UI.
- Removed the obsolete external documentation/jQuery-plugin warnings from the admin page.
- Removed the forced jQuery library dependency.

## Frontend

- Removed Google+, Facebook SDK and Twitter widget scripts.
- Replaced the ad-detail presentation table with semantic responsive markup.
- Replaced list tables with responsive article/card markup.
- Rebuilt ad/category/contact forms with labels, required fields and responsive controls.
- Removed legacy `<font>` markup and fixed-width image/detail assumptions.
- Renamed the stylesheet to stable `classifieds.css`.
- Added asset cache busting based on the deployed stylesheet modification time.

## Database and installation

- Fresh installs use InnoDB.
- Existing 1.3.2 tables are converted to InnoDB during upgrade.
- Fresh installs no longer run the broken/obsolete automatic category seed loader.
- The image directory is explicitly created/validated on install and upgrade.
- Existing table names, ad IDs and public ad URLs are preserved.

## Geeklog interoperability

Added:

- `plugin_getiteminfo_classifieds()`;
- `plugin_idToURL_classifieds()`;
- `plugin_collectSitemapItems_classifieds()`;
- page description/robots metadata and canonical URL;
- `plugin_getcapabilities_classifieds()`;
- `content.read`;
- `content.collection`;
- `content.search`;
- `content.url.resolve`;
- `content.lifecycle`;
- `dashboard.summary`;
- admin-only `service_dashboard_summary_classifieds()`.

The dashboard service owns its own metrics and storage warning logic; consumers such as Eclipse do not need to query Classifieds tables.

## Compatibility target

- Geeklog 2.1.1 through 2.2.2
- PHP 5.6 through PHP 8.1

This remains a **development snapshot**, not a final release.

## Validation still required

Before changing the version from `1.4.0` to `1.4.0`, run the complete runtime matrix, including:

- fresh install;
- upgrade from 1.3.2;
- upgrade where an old Pro file remains in `path_data`;
- Geeklog 2.1.1 / PHP 5.6;
- Geeklog 2.2.2 / PHP 8.1;
- shared-files multisite with one site upgraded and another still on 1.3.2;
- create/edit/soft-delete/hard-delete;
- image add/delete/replacement;
- scheduled expiration notifications;
- all user/admin email-notification combinations;
- republish success/failure;
- categories;
- search/autotags/comments;
- anonymous/member/admin ACLs;
- configuration UI/tooltips;
- Item Info, sitemap, lifecycle events and dashboard summary.

A local `php -l`/runtime pass could not be executed from the current tool container because its GitHub clone attempt had no DNS access. No claim of runtime validation is made by these release notes.


## Memorandum administration/configuration alignment

The administration and configuration implementation was re-audited against the current `hostellerie/memorandum` guidance.

Administration now follows the documented separation of responsibilities:

- Geeklog global admin discovery: `plugin_getadminoption_classifieds()`;
- Command & Control discovery: `plugin_cclabel_classifieds()`;
- page actions: `ADMIN_createMenu()`;
- persistent peer sections: shared `plugin-admin-nav*` markup;
- plugin settings: Geeklog native Configuration via POST `conf_group=classifieds`.

Configuration migration was also hardened after checking Geeklog Core's `config::add()` implementation. Since `config::add()` deletes and recreates an existing row, the 1.4.0 upgrade now calls it only for genuinely missing configuration entries. Existing administrator values are preserved while metadata such as type, fieldset, selection array, sort order and tab assignment is repaired in place.

The migration verifies the resulting group through `get_config('classifieds')` before completing.


## Consolidation before runtime testing

A further source-level cleanup removed remaining legacy behavior before the runtime matrix:

- Classifieds now uses Geeklog Core `SEC_loginRequiredForm()` instead of carrying a copied login form;
- republishing no longer performs redirects inside the business module;
- republish mail/lifecycle events are emitted only after the source ad is retired successfully;
- failed source retirement removes the provisional copy instead of leaving two active ads;
- scheduled expiration mail is one-shot per ad, avoiding duplicate delivery after partial failures;
- public list queries and pagination counts share the same publication/category/type/ACL filters;
- obsolete `ads_type` cookies and the dead `mode=s` route were removed;
- the main footer now uses the correct `classifieds_main_footer` configuration key;
- category option rendering now uses purpose-built, escaped helpers rather than dynamic generic SQL builders;
- opening the category administration list no longer mutates category ordering;
- comment callbacks now use the real Classifieds ACL contract.


## Native date/time formatting

Date/time rendering now follows Geeklog user preferences through `COM_getUserDateTimeFormat()` using Core `dateonly` and `timeonly` modes. The plugin-specific `date_format` and `time_format` settings and all direct `strftime()` calls were removed. Existing upgrade rows for those two obsolete settings are deleted during the 1.4.0 migration.


## Final source consolidation

Before entering runtime validation, the maintained PHP code was scanned for the targeted legacy patterns. The scan found no remaining TODO/FIXME markers, PHP 8-incompatible `each()`, direct `strftime()`, application `addslashes()`/`stripslashes()`, generic `SELECT *`, no-op `WHERE 1=1`, or direct `$_GET`/`$_POST` access.

Additional final corrections:

- persisted configuration is merged over in-memory defaults before derived paths are built;
- new ads now apply the configured Geeklog default ACLs instead of SQL-table defaults;
- republished ads preserve source ACLs;
- Classifieds administrators have a consistent item-management override;
- comment availability follows ad publication/expiration state;
- category hierarchy/deletion rules prevent orphaned ads and child categories;
- image metadata changes participate in the database transaction while physical deletion is deferred until after commit;
- hard-delete database work completes before image files are removed;
- legacy CSS conflicting with the responsive list markup was removed.

The source is now intentionally at a **runtime validation gate**. Further changes should be driven by reproducible test failures rather than additional speculative refactoring.


## Contextual FAQ and generic item display

Classifieds now implements the current Memorandum content-interoperability model required by FAQ 1.3.0 contextual associations.

Stable Classifieds identities are:

- `root` for the catalogue/home page;
- `category:<cid>` for category pages;
- `ad:<clid>` for full ads.

Item Info exposes these resources with `id`, `title`, `url`, `type`, `subtype`, `is-container`, `parent-id` and `parent-subtype` where applicable. Existing positive numeric IDs are still accepted as ad aliases.

Classifieds also calls Geeklog's generic `PLG_itemDisplay($id, 'classifieds')` dispatcher at provider-owned stable locations:

- after the main list on the Classifieds home page;
- after the list on category pages;
- after the primary ad content and before comments on full ad pages.

This enables FAQ, Hub and future consumers to contribute contextual server-rendered fragments without Classifieds knowing their tables or APIs.

Category filters now use stable GET URLs and category list visibility is aligned with category ACLs.
