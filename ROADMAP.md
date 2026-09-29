# Classifieds modernization roadmap

Target branch: `classifieds_1.4.0`

## Goal

Modernize the Classifieds plugin while preserving existing installations, data, URLs and Geeklog integration.

The modernization must:

- remove all telemetry and unsolicited external communication;
- merge the historical Pro edition into the standard plugin;
- remain upgrade-safe for existing Classifieds installations;
- follow the current Geeklog modernization guidance documented in `hostellerie/memorandum`;
- target Geeklog 2.1.1 through 2.2.2;
- target PHP 5.6 through PHP 8.1 during the current compatibility period;
- remain safe for shared-files / multi-database multisite deployments.

The work should evolve the existing plugin rather than replace it with an incompatible new application.

---

## Current baseline

Current public code:

- plugin version: 1.3.2;
- declared Geeklog minimum: 1.8.0;
- procedural architecture centered around `functions.inc`, `lib-edit.php`, `lib-contact.php` and `admin/index.php`;
- native Geeklog Configuration API already present, but using legacy declarations;
- MyISAM tables;
- legacy TimThumb copy embedded in `public_html/`;
- old table-based frontend templates;
- external social-network JavaScript embedded in ad detail pages;
- optional Pro code loaded from `{path_data}/classifieds_data/proversion/proversion.php`;
- installation telemetry sent by email from `plugin_postinstall_classifieds()`.

Existing data and stable identifiers must be preserved unless an explicit migration is implemented and tested.

---

# 1.4.0 — modernization foundation

## P0 — Privacy and external communication

### Remove installation telemetry

Delete the current installation statistics code from `plugin_postinstall_classifieds()`.

The plugin must no longer transmit:

- site URL;
- site name;
- plugin version;
- installation status;
- Pro-version status;
- any other installation or usage information.

Do not replace this with an opt-out setting. Classifieds should perform no telemetry.

### Audit every external request

Search the complete plugin for:

- `COM_mail()` calls not related to normal user/admin notifications;
- remote script tags;
- remote image or asset loading;
- HTTP requests;
- cURL;
- fopen wrappers to remote URLs;
- tracking pixels;
- third-party analytics.

Normal configured notifications to users/site administrators remain valid plugin functionality. Undisclosed developer telemetry does not.

---

## P0 — Merge the historical Pro version into Classifieds

The last known Pro archive contains:

- `proversion/proversion.php`;
- `proversion/catsql_english.php`;
- `proversion/readme.txt`.

The former Pro code must become normal Classifieds functionality. The runtime loader:

```php
$_CONF['path_data'] . 'classifieds_data/proversion/proversion.php'
```

must ultimately disappear.

### Integrate lifecycle email notifications

Merge and modernize:

- `CLASSIFIEDS_emailNewAd()`;
- `CLASSIFIEDS_emailEditAd()`;
- `CLASSIFIEDS_emailDeleteAd()`;
- `CLASSIFIEDS_emailAdExpire()`;
- `CLASSIFIEDS_getUserEmail()`.

Retain the existing configuration switches:

- `create_ad_email_user`;
- `mod_ad_email_user`;
- `delete_ad_email_user`;
- `expire_ad_email_user`;
- `create_ad_email_admin`;
- `mod_ad_email_admin`;
- `delete_ad_email_admin`;
- `expire_ad_email_admin`.

Requirements:

- user notification and admin notification must be independently respected;
- disabling user mail must not unintentionally suppress enabled admin mail;
- validate recipient addresses through normal Geeklog/user data;
- use site-configured sender addresses;
- avoid leaking private fields;
- preserve localization;
- remove obsolete `stripslashes()` assumptions where no longer appropriate;
- make the functions PHP 5.6–8.1 safe.

### Integrate scheduled expiration handling

Merge and modernize:

`plugin_runScheduledTask_classifieds()`

The scheduled task should:

- find active ads older than `active_days`;
- send the configured expiration notification once;
- update expiration/notification state safely;
- avoid duplicate emails when a task is retried;
- operate only on the current site's database;
- remain harmless when called repeatedly;
- log failures without breaking the complete scheduled-task run.

Review whether `notification = 2` alone is still the clearest lifecycle state or whether the existing columns should be documented more explicitly before any schema change.

### Integrate republish / copy functionality

Merge and modernize:

- `CLASSIFIEDS_getBonusAdminButton()`;
- `CLASSIFIEDS_repost()`;
- `CLASSIFIEDS_adCopy()`;
- `CLASSIFIEDS_copyImages()`;
- `CLASSIFIEDS_copyImage()`.

Retain the existing `allow_republish` setting.

Required behavior:

- only permitted users may republish;
- ownership and Geeklog ACL checks remain authoritative;
- an active or deleted ad must not be republished when business rules forbid it;
- republishing creates a new ad instead of mutating historical identity;
- old ad state changes only after the new ad has been created successfully;
- image copies must be complete before the old record is marked deleted;
- failures must leave the original ad usable;
- operations must be retry-safe where practical.

### Integrate Pro category seed data

Review `catsql_english.php` as optional installation seed data.

Do not force historical categories on existing sites.

For fresh installations:

- keep category seeding optional or clearly installation-only;
- preserve translated/category-specific seed files where useful;
- do not overwrite administrator-defined categories;
- do not treat category seed content as runtime Pro functionality.

### Remove all edition-gating remnants

Remove or rewrite:

- `limited_edition`;
- `upgrade_proversion`;
- labels containing `(Pro version)`;
- detection based on `function_exists('CLASSIFIEDS_adCopy')`;
- documentation telling users to purchase/install Pro;
- the Pro loader;
- Pro-specific installation instructions.

After migration there is one plugin: **Classifieds**.

---

## P0 — PHP 8 compatibility audit

Audit all PHP files, including the former Pro code.

Known issues include:

### Remove `each()`

Replace every pattern such as:

```php
while (list($key, $value) = each($args))
```

with PHP 5.6-compatible `foreach` logic.

This occurs in the base plugin and the historical Pro image-copy code.

### Remove invalid/dead control flow

Review constructs such as `break` outside valid loop/switch contexts and unreachable code after `exit`.

### Fix argument signatures

Review functions where optional parameters precede required parameters, for example the historical Pro delete-email callback.

Make signatures unambiguous and compatible across PHP 5.6–8.1.

### Initialize variables

Audit variables used with `.=` or read before guaranteed initialization, including rendering variables such as `$retval`, `$display` and arrays populated conditionally.

### Protect array access

Replace unsafe assumptions such as:

```php
$array['key']
```

when the key may be absent.

Use PHP 5.6-compatible `isset()` patterns where necessary.

### Remove obsolete magic-quotes-era handling

Review:

- `COM_stripslashes()`;
- references to "Magic GPC Garbage";
- unnecessary `stripslashes()`;
- legacy request normalization.

Do not preserve transformations that can corrupt legitimate content.

### General compatibility pass

Test for:

- removed PHP functions;
- deprecated signatures;
- warnings promoted by PHP 8;
- implicit numeric conversions;
- null handling;
- undefined constants;
- count() on non-countable values;
- unsafe string/array assumptions.

---

## P0 — Security and input validation

Perform a complete request/SQL/output audit.

### Request handling

Prefer explicit request sources and validation over unrestricted `$_REQUEST`.

Classify each input as:

- integer ID;
- boolean;
- decimal price;
- short text;
- free text;
- filename/upload;
- enum;
- permission value.

Validate before use.

### SQL

Remove use of `addslashes()` as SQL protection.

Use the appropriate Geeklog database escaping/filtering facilities and numeric casts.

Review every dynamic query, especially:

- ad IDs;
- user IDs;
- category IDs;
- search values;
- postcode/city/title/text;
- sort/order values;
- Pro republish queries.

### Output escaping

Ensure user-controlled content is escaped according to context:

- HTML text;
- HTML attributes;
- URLs;
- JavaScript if any remains;
- email body.

Do not double-escape stored content.

### CSRF

Verify all state-changing forms/actions use Geeklog security tokens:

- create/edit ad;
- delete ad;
- republish ad;
- category create/edit/delete;
- administration actions.

### Permissions

Review all ACL paths using:

- `SEC_hasRights()`;
- `SEC_hasAccess()`;
- `SEC_hasAccess2()`;
- Geeklog permission SQL helpers.

Do not rely on UI hiding for authorization.

---

## P0 — Remove TimThumb

Remove:

- `public_html/timthumb.php`;
- `public_html/timthumb-config.php`.

Replace thumbnail generation with Geeklog-supported image handling using the existing upload/image infrastructure.

Requirements:

- retain access to existing uploaded images;
- create thumbnails without remote image fetching;
- respect configured image library support (GD/ImageMagick/NetPBM as applicable);
- keep original/image migration non-destructive;
- no frontend request should silently rewrite the full image library.

If a persistent thumbnail cache is introduced, distinguish it clearly from source images so cache cleanup can never delete user uploads.

---

## P0 — Remove obsolete social widgets and third-party scripts

Remove automatic page loads for:

- Google+;
- Facebook SDK;
- Twitter/X widget JavaScript;
- any other obsolete social script embedded in templates.

If sharing remains available, use plain share links or the browser-native share mechanism where appropriate.

Viewing an ad must not contact unrelated social networks by default.

---

# Configuration modernization

## Correct Geeklog Configuration API declarations

Refactor `install_defaults.php` according to the current Memorandum guidance.

Use:

```text
subgroup
→ tab
→ fieldset
→ settings
```

Add an explicit symbolic tab such as:

```php
$c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'classifieds', 0);
```

### Fix selection arrays

Plain fields must use `NULL` for the `selection_array` argument instead of legacy placeholder `0`.

Every actual numeric selection-array ID must have a corresponding:

```php
$LANG_configselects['classifieds'][...]
```

entry.

### Configuration language contract

Ensure every maintained language provides the necessary metadata:

- `$LANG_configsections['classifieds']`;
- `$LANG_configsubgroups['classifieds']`;
- `$LANG_tab['classifieds']`;
- `$LANG_fs['classifieds']`;
- `$LANG_confignames['classifieds']`;
- `$LANG_configselects['classifieds']`.

English remains the fallback.

### Native tooltips

Implement:

```php
plugin_getconfigtooltip_classifieds($id)
```

and localized:

```php
$LANG_configtooltips['classifieds']
```

Use tooltips only for settings that benefit from contextual explanation, especially:

- active period;
- image limits;
- republishing;
- email notifications;
- login requirement;
- default ACLs;
- storage/migration options if introduced.

### Upgrade existing `conf_values`

Changing `install_defaults.php` is not enough for installed sites.

The 1.4.0 upgrade path must repair persisted configuration metadata when necessary, including incorrect `selectionArray` values.

The migration must:

1. create/repair target configuration entries;
2. preserve existing administrator values;
3. verify the target configuration;
4. only then mark the plugin upgrade complete.

---

# Administration modernization

## Use native Geeklog administration primitives first

Keep:

`plugin_getadminoption_classifieds()`

for the global administration entry.

Use `ADMIN_createMenu()` for page-local actions such as:

- New ad;
- New category;
- Back to ads;
- Back to categories.

## Persistent plugin navigation

For peer administration sections use the Memorandum shared convention:

- `plugin-admin-nav`;
- `plugin-admin-nav__primary`;
- `plugin-admin-nav__item`;
- `plugin-admin-nav__form`;
- `is-active`;
- `aria-current="page"`.

Initial sections:

- Ads;
- Categories;
- Configuration.

Do not make UIkit, Bootstrap, Denim or Eclipse classes the plugin contract.

Configuration must continue to open Geeklog's native Configuration UI rather than a duplicate plugin settings page.

## Administration responsiveness

Modernize admin layouts so they work with both current Geeklog themes and narrow screens.

Avoid fixed-width presentation tables where a responsive list/grid is more appropriate.

---

# Frontend modernization

## Replace presentation tables

Refactor public templates toward semantic HTML:

- `article`;
- `header`;
- `section`;
- `figure`;
- `aside`;
- `nav`.

Do not use tables solely to place an image beside contact details.

## Responsive ad detail

Desktop concept:

```text
Title / price
metadata
--------------------------------
gallery            contact
gallery            advertiser
--------------------------------
description
comments
```

Mobile concept:

```text
title
price / metadata
gallery
description
contact
comments
```

Remove fixed constraints such as:

- `min-width: 500px`;
- rigid 250px side columns;
- inline presentation attributes;
- `<font>` elements.

## Forms

Modernize create/edit forms:

- semantic labels;
- explicit label/input association;
- responsive controls;
- clear required markers;
- accessible validation errors;
- preserve Geeklog CSRF token;
- preserve existing field values after validation errors;
- mobile-friendly image upload controls.

## CSS

Replace the version-named `classifieds_130.css` with a stable asset name such as:

`classifieds.css`

Use Geeklog asset loading/cache busting rather than encoding the historical plugin version in the filename.

Keep selectors plugin-scoped to avoid theme conflicts.

---

# Image and persistent-storage strategy

Existing images must remain available.

Short-term 1.4.0 priority:

- remove TimThumb;
- preserve current files;
- generate safe thumbnails using supported local image libraries.

Longer-term storage modernization may move persistent user uploads toward site-scoped storage derived from `$_CONF['path_data']`.

Any storage migration must follow the Memorandum persistent-storage and shared-files rules:

- current-site scoped;
- non-destructive;
- idempotent;
- retryable;
- old source retained until target verified;
- uploading new shared plugin files must not itself migrate another site's data.

Do not combine a storage migration with unrelated UI work unless it can be tested independently.

---

# Database modernization

## Preserve existing schema initially

Keep the existing logical tables during 1.4.0:

- `cl`;
- `cl_cat`;
- `cl_pic`;
- `cl_users`.

Avoid gratuitous identifier changes.

## InnoDB

Use InnoDB for fresh installations.

For existing MyISAM installations, provide a controlled and tested migration if conversion is included in 1.4.0.

Do not make the frontend depend on the conversion having run merely because new files were uploaded.

## Schema audit

Review legacy field types, including:

- `catid varchar(32)`;
- `pid varchar(32)`;
- `pi_pid varchar(40)`.

Do not change types until compatibility with existing data, queries and upgrades is proven.

Document the semantics of:

- `status`;
- `type`;
- `enable`;
- `notification`;
- `deleted`;
- `modif`.

Avoid overlapping lifecycle flags without a documented meaning.

---

# Geeklog content interoperability

Classified ads are first-class Geeklog content and should expose standard provider APIs.

## Item Info

Implement:

`plugin_getiteminfo_classifieds()`

Support at least normalized fields useful to generic consumers:

- id;
- title;
- description;
- URL;
- owner/author;
- created;
- modified;
- hits;
- category;
- image where appropriate.

Collection support should be bounded and ACL-aware.

## Stable URL resolution

Implement:

`plugin_idToURL_classifieds()`

Preserve existing public URLs during 1.4.x.

## Lifecycle

Implement provider lifecycle integration where appropriate:

- item saved;
- item deleted/removed.

Ensure create/edit/delete/republish paths notify generic consumers only after successful state changes.

## Search

Keep and modernize the existing:

- `plugin_searchtypes_classifieds()`;
- `plugin_dopluginsearch_classifieds()`.

Search results must respect:

- permissions;
- enabled/deleted state;
- expiration policy.

## Autotags

Retain the existing `[classifieds:]` integration.

Harden ID validation and output escaping.

## Capabilities

Declare appropriate capabilities once their provider APIs are stable:

- `content.read`;
- `content.collection`;
- `content.search`;
- `content.popular` when hits are meaningful;
- `content.url.resolve`;
- `content.lifecycle`;
- `dashboard.summary`.

Do not expose write capabilities until a bounded, permissioned service contract is deliberately designed.

## Dashboard summary

Provide a read-only bounded `dashboard.summary` service for generic administration consumers such as Eclipse.

Candidate metrics:

- active ads;
- expired ads;
- disabled ads;
- deleted ads if operationally useful;
- categories.

Candidate alerts:

- upload directory unavailable;
- failed persistent-storage requirement;
- pending operational condition if one is introduced.

The provider calculates these values. Consumers must not query Classifieds tables directly.

---

# SEO and discoverability

## Metadata

Implement:

`plugin_getmetatags_classifieds()`

for individual ads.

Generate appropriate:

- page title;
- meta description;
- canonical URL;
- Open Graph metadata where supported by the normal Geeklog path.

Do not reintroduce third-party social SDKs to provide metadata.

## Sitemap

Implement:

`plugin_collectSitemapItems_classifieds()`

Include only content that should be indexable and visible to the requesting/public context.

## Lifecycle/indexability policy

Define explicitly:

- active ad: public/indexable when ACL permits;
- expired ad: decide whether it remains readable, normally noindex if retained only for users/history;
- disabled ad: not indexable;
- deleted ad: unavailable, with a consistent 404/410 or explanatory policy.

Do not allow stale sitemap entries to expose unavailable ads.

## Structured data

Evaluate structured data only where a correct schema can be produced from actual ad data.

Do not add misleading Product/Offer markup merely for SEO.

---

# plugin.json and installer metadata

Keep the existing static manifest and align it with tested support.

Target form after compatibility is verified:

```json
{
  "schema": 1,
  "id": "classifieds",
  "name": "Classifieds",
  "icon": "admin/images/classifieds.png",
  "requires": {
    "geeklog": "2.1.1",
    "php": "5.6.0"
  }
}
```

Keep `requires.geeklog` aligned with `pi_gl_version`.

Do not declare PHP support until the compatibility test matrix passes.

---

# Installation and upgrade safety

## Fresh install

Test:

- table creation;
- initial configuration;
- permissions/groups;
- optional category seeding;
- image storage;
- admin configuration page;
- frontend create/view/edit/delete.

## Upgrade from 1.3.2

The upgrade must preserve:

- ads;
- category IDs and hierarchy;
- images;
- user ad profile data;
- permissions;
- existing configuration values;
- URLs;
- comments;
- historical lifecycle state.

## Historical Pro installations

A site may already have:

`{path_data}/classifieds_data/proversion/proversion.php`

The 1.4.0 runtime must not require this file.

Upgrade behavior should:

- recognize that Pro functionality is now built in;
- preserve configuration values already used by Pro;
- not delete administrator data automatically;
- optionally log/document that the external Pro file is obsolete;
- avoid loading both implementations simultaneously.

Do not automatically delete the legacy file during the first upgrade unless there is a compelling safety reason. Leaving an unused file is safer than destructive cleanup.

## Shared-files multisite

Test the Memorandum transition case:

```text
shared plugin files: 1.4.0
site A persisted state: 1.4.0
site B persisted state: 1.3.2
```

Site B must remain operational until its own plugin upgrade runs.

New runtime code must tolerate the previous persisted schema/configuration where required.

Upgrading site A must not modify site B's database, configuration or site-scoped files.

---

# Cleanup and maintainability

## functions.inc

Keep Plugin API callbacks in `functions.inc`, but progressively move business logic into focused include files where this reduces risk.

Possible organization:

```text
functions.inc
lib-common.php
lib-ads.php
lib-images.php
lib-notifications.php
lib-admin.php
lib-contact.php
```

Do not perform a large object-oriented rewrite merely for style.

## Naming

Retain the `CLASSIFIEDS_` prefix for compatibility during 1.4.x unless a function is internal and can be safely replaced.

## Error handling

Replace direct `echo` + `exit` patterns in reusable business functions where practical with explicit return/error handling.

Use `COM_errorLog()` for diagnostics, not as presentation markup.

## Documentation

Update README with:

- current compatibility;
- installation;
- upgrade from 1.3.2;
- historical Pro integration;
- scheduled task behavior;
- image/storage notes;
- configuration;
- privacy/no-telemetry statement.

Add release notes for 1.4.0.

---

# Test matrix

Minimum environments:

| Geeklog | PHP | Purpose |
| --- | --- | --- |
| 2.1.1 | 5.6 | oldest supported compatibility path |
| 2.1.1 | 8.1 where viable | legacy Geeklog with modern PHP diagnostic pass |
| 2.2.2 | 8.1 | primary modernization target |

Also test relevant currently available PHP 8.x environments during development, but do not broaden the declared support range without deliberate policy.

Functional tests:

- fresh install;
- upgrade from 1.3.2 base;
- upgrade from 1.3.2 + historical Pro file;
- frontend before running upgrade after new shared files are deployed;
- create ad;
- edit ad;
- delete ad;
- expire ad;
- scheduled expiration notification;
- user/admin email combinations;
- republish expired ad;
- forbidden republish;
- image upload;
- image deletion;
- image copy during republish;
- category CRUD;
- category hierarchy;
- search;
- autotag;
- comments;
- anonymous/member/admin ACLs;
- configuration UI;
- configuration tooltips;
- mobile layouts;
- sitemap;
- Item Info;
- dashboard summary;
- two-site shared-files isolation.

---

# Suggested implementation order

## Phase 1 — 1.4.0-dev bootstrap

- [x] bump development code version to 1.4.0-dev;
- [x] update compatibility declarations to the 2.1.1–2.2.2 / PHP 5.6–8.1 modernization target (final declaration remains subject to runtime validation);
- [x] add release/upgrade notes skeleton;
- [x] add explicit shared-files-safe upgrade structure.

## Phase 2 — privacy and Pro merge

- [x] remove installation and upgrade telemetry;
- [x] import Pro notification functions;
- [x] import scheduled expiration task;
- [x] import republish/copy logic;
- [x] import image-copy logic;
- [x] review category seed file (not auto-imported: historical file is an opinionated mostly-French taxonomy);
- [x] remove Pro loader and edition gating;
- [x] preserve historical Pro configuration (existing settings reused; legacy Pro file ignored but not deleted).

## Phase 3 — PHP/security stabilization

- [x] replace `each()`;
- [ ] repair PHP 8 warnings/fatals;
- [x] audit and normalize request input on state-changing/public routing paths;
- [ ] audit SQL escaping;
- [ ] audit output escaping;
- [x] audit ACL checks and centralize ad visibility/edit authorization;
- [x] audit CSRF tokens for ad/category state-changing actions;
- [x] remove magic-quotes-era transformations.

### Phase 3 progress

Completed in the current development snapshot:

- contact/report flow rewritten from scratch around the ad id; recipient and subject are derived server-side from the database;
- removed the dead "advise to a friend" route and legacy mail-to-friend code copied from Geeklog profiles;
- removed the duplicated Classifieds user-profile renderer and use Geeklog core `USER_showProfile()` directly;
- ad access checks now enforce native Geeklog ACLs instead of checking only the deleted flag;
- category/ad missing-field validators now use explicit arrays and bounded IDs, avoiding PHP 8 string-to-array errors;
- removed PHP 8-incompatible `each()` use from image handling;
- made request filtering safe when expected scalar keys are absent or submitted as arrays;
- enabled server-side CSRF validation for ad create/edit/delete/copy/republish writes;
- added CSRF protection to category administration writes;
- replaced legacy `addslashes()` persistence with `DB_escapeString()` in ad/category writes;
- forced numeric IDs, flags and enum-like values to bounded integer values before SQL use;
- fixed a PHP 8-breaking ad-count/pagination bug that treated an integer row count as an array;
- initialized request state, pagination variables, counters and common edit-form fields to avoid undefined-key warnings;
- fixed undefined variables in public contact/advice/profile routes;
- removed obsolete magic-quotes-era mutation from image handling.

Still required before Phase 3 can be marked complete:

- finish the residual SQL/output audit of less-used read/helper paths;
- run the PHP 8 warning/fatal pass in a real Geeklog runtime;
- validate the complete state-changing workflow under Geeklog 2.1.1 and 2.2.2.

Additional cleanup completed after the initial Phase 3 pass:

- rewrote `CLASSIFIEDS_viewAd()` around explicit ID validation, ACLs and a single visibility policy;
- extracted `lib-ads.php` for transactional ad persistence and lifecycle events;
- extracted `lib-images.php` for media persistence;
- made new image uploads non-destructive: existing images are removed only after replacement uploads succeed;
- centralized soft/hard deletion and removed orphan-prone controller SQL;
- removed ambiguous GET/POST `op` selection controls from edit forms;
- removed the dead direct-copy and preview routes;
- reduced the supported in-place upgrade chain to the explicit 1.3.2 baseline, removing old public-folder mutation code and `sleep(5)`;
- removed the forced jQuery dependency.

## Phase 4 — image pipeline

- [x] remove TimThumb;
- [x] replace the thumbnail proxy with direct local image rendering and responsive CSS sizing;
- [x] preserve existing image storage and filenames;
- [ ] test republish image copy;
- [x] document the 1.4.x persistent image strategy.

## Phase 5 — configuration/admin

- [x] add explicit tab hierarchy;
- [x] fix `selection_array` declarations;
- [x] add/repair language metadata;
- [x] add native configuration tooltips;
- [x] implement upgrade repair for existing `conf_values`;
- [x] modernize persistent plugin admin navigation;
- [x] use `ADMIN_createMenu()` for page actions.

## Phase 6 — frontend

- [x] remove external social scripts;
- [x] modernize ad-list templates;
- [x] modernize ad-detail template;
- [x] modernize forms;
- [x] replace presentation table layout;
- [x] responsive/mobile pass;
- [x] semantic labels, required fields and accessible form structure pass;
- [x] rename CSS to stable `classifieds.css` and add cache busting.

## Phase 7 — Geeklog interoperability

- [x] Item Info;
- [x] ID-to-URL;
- [x] lifecycle events for create/edit/delete/republish;
- [x] ACL-aware sitemap provider;
- [x] ad-page description/robots metadata and canonical URL;
- [x] provider-neutral capabilities declaration;
- [x] admin-only `dashboard.summary` service.

## Phase 8 — database/release validation

- [x] use InnoDB for fresh install;
- [x] implement existing-table engine migration to InnoDB;
- [ ] document lifecycle columns;
- [ ] run full upgrade matrix;
- [ ] run shared-files multisite matrix;
- [x] rewrite README for the 1.4.0 modernization state;
- [x] maintain 1.4.0-dev release notes (final release wording remains pending runtime validation);
- [ ] set final version to 1.4.0 only after migration and compatibility tests pass.

---

# Non-goals for the first modernization release

Do not block 1.4.0 on:

- a full framework rewrite;
- replacing all procedural code with classes;
- changing every database identifier/type;
- changing established public URLs;
- implementing a public REST API;
- implementing payment features;
- implementing write-capability automation;
- moving all existing uploads to a new storage system without a separately tested migration.

The priority is a clean, private, complete, upgrade-safe Classifieds plugin that works as one unified edition on modern Geeklog.


---

## Memorandum compliance audit — administration and configuration

Reviewed against:

- `hostellerie/memorandum/plugin-admin-navigation.md`;
- `hostellerie/memorandum/plugin-configuration-migration-guide-2.2.2.md`;
- `hostellerie/memorandum/plugin-configuration-tooltips.md`.

### Administration navigation

Implemented:

- [x] native `plugin_getadminoption_classifieds()` global administration entry;
- [x] native `plugin_cclabel_classifieds()` Command & Control entry;
- [x] both hooks enforce `classifieds.admin`;
- [x] persistent peer navigation uses the shared `plugin-admin-nav*` contract;
- [x] current section uses `is-active` and `aria-current="page"`;
- [x] Configuration remains Geeklog Core-owned and is opened through POST `conf_group=classifieds`;
- [x] page-local actions use `ADMIN_createMenu()` where its native link-action model fits;
- [x] fallback CSS is theme-neutral and responsive;
- [x] no UIkit, Bootstrap, Eclipse or Denim class is required by the plugin contract;
- [x] obsolete custom admin-menu template removed.

### Native configuration

Implemented:

- [x] configuration uses `config::get_instance()->get_config('classifieds')`;
- [x] fresh install hierarchy is explicit: subgroup → tab → fieldsets → settings;
- [x] symbolic `tab_main` is registered and localized;
- [x] every maintained setting is assigned to explicit tab id `0`;
- [x] plain text settings use `NULL` for `selection_array`;
- [x] select controls use only declared selection-array IDs (`3` and `12`);
- [x] English and French provide `$LANG_configsections`, `$LANG_configsubgroups`, `$LANG_tab`, `$LANG_fs`, `$LANG_confignames`, and `$LANG_configselects`;
- [x] `plugin_getconfigtooltip_classifieds()` uses localized `$LANG_configtooltips['classifieds']`;
- [x] tooltips are limited to consequential/ambiguous settings;
- [x] upgrade creates only missing configuration rows;
- [x] upgrade never blindly calls `config::add()` for existing settings, because Core deletes/recreates those rows;
- [x] upgrade repairs persisted configuration metadata without replacing administrator values;
- [x] obsolete TimThumb settings are removed explicitly;
- [x] migrated configuration is verified through `get_config('classifieds')` before the plugin version is advanced.

### Runtime validation still required

Source-level compliance is complete, but final release still requires:

- [ ] open Classifieds Configuration under Geeklog 2.1.1 with warnings enabled;
- [ ] open Classifieds Configuration under Geeklog 2.2.2 / PHP 8.1 with warnings enabled;
- [ ] verify search/autocomplete on the Configuration page;
- [ ] verify all tooltips in English and French;
- [ ] verify Ads / Categories / Configuration navigation under Denim and Eclipse;
- [ ] verify narrow-screen administration navigation;
- [ ] upgrade a real 1.3.2 configuration with non-default values and confirm those values are unchanged.


### Source-contract verification

A source-level consistency check was run after the Memorandum audit:

- 25 maintained configuration settings are declared in `install_defaults.php`;
- all 25 have matching `$LANG_confignames['classifieds']` entries in English;
- all 25 have matching `$LANG_confignames['classifieds']` entries in French;
- symbolic `tab_main` exists in both languages;
- selection arrays `3` and `12` exist in both languages;
- all required shared admin navigation classes are present;
- `plugin_getadminoption_classifieds()`, `plugin_cclabel_classifieds()`, and `plugin_getconfigtooltip_classifieds()` are present.

No additional administration/configuration compatibility layer should be added unless runtime testing demonstrates a concrete need.


### Consolidation pass after Memorandum audit

Additional cleanup completed before runtime testing:

- [x] replaced the copied Classifieds login form with Geeklog Core `SEC_loginRequiredForm()`;
- [x] removed dead Pro/save/relay UI variables and language strings;
- [x] separated republish business logic from redirects;
- [x] made republish notifications/lifecycle fire only after the source ad is successfully retired;
- [x] remove provisional republished copies if the source transition fails;
- [x] make expiration notifications one-shot per ad to avoid duplicate mail after partial recipient failures;
- [x] unify list/count visibility filters so pagination respects category, type, publication state and ACLs;
- [x] public lists now explicitly require enabled, non-deleted, non-expired ads in active categories;
- [x] removed obsolete type cookies and the dead public save route;
- [x] fixed the `classifieds_main_footer` configuration key typo;
- [x] replaced generic category SQL/option builders with two purpose-built helpers;
- [x] removed read-time category reordering and other GET side effects;
- [x] modernized comment callbacks and removed references to nonexistent `classifieds.edit`.

- [x] date/time display now follows Geeklog user preferences through `COM_getUserDateTimeFormat()`; plugin-specific `strftime()` settings were removed.
