# Memorandum compliance — Classifieds 1.4.0

This document records the Classifieds 1.4.0 alignment with the current
`hostellerie/memorandum` development baseline.

## Compatibility baseline

- Geeklog: 2.1.1 through 2.2.2
- PHP: 5.6 through 8.1
- Runtime plugin version: 1.4.0
- Supported direct upgrade baseline: Classifieds 1.3.2

The release workflow lints shipped PHP/INC source with PHP 5.6.

## Installation, upgrade and removal

Classifieds declares its tables, groups and features through the normal Geeklog
autoinstall contract. Configuration is created through Geeklog Configuration.
Upgrade code preserves administrator values, repairs configuration metadata,
converts owned tables to InnoDB and updates the plugin version only after the
required migration succeeds.

The autoinstall/bootstrap files explicitly declare plugin-owned globals so the
Geeklog 2.1.1 function-scope autoinstall path is supported.

The uninstall contract owns the four Classifieds tables and the Classifieds
groups/features.

## Public and administration rendering

Full public and administration pages use `COM_createHTMLDocument()`. Legacy
`COM_siteHeader()` / `COM_siteFooter()` full-page rendering is forbidden by
CI.

Classifieds does not force left/right block columns. Block rendering and the
site's right-block policy are left to Geeklog and the active theme through
`COM_createHTMLDocument()`.

Public and administration entry points verify that the plugin is active.
Administration additionally enforces `classifieds.admin`; mutation actions use
Geeklog security tokens.

## Administration UX

The administration provides persistent navigation to:

- ads;
- categories;
- Geeklog Configuration.

The main administration screen includes an installed Getting started guide.
Category administration supports manual CRUD and validated CSV import with a
preview/confirmation step.

Visible wording belongs to language files. English and French functional
language-key contracts are checked in CI.

## Assets

Classifieds CSS and administration JavaScript are owned by the plugin and stored
in dedicated files. Public asset URLs use:

```text
PLUGIN_VERSION-filemtime
```

for deterministic cache invalidation.

The Classifieds stylesheet remains available through the plugin lifecycle rather
than only on `/classifieds/index.php` because Classifieds can also render ads
inside Geeklog profile blocks.

## Content identity and interoperability

Provider-owned stable identities are:

```text
root
category:<cid>
ad:<clid>
```

Positive numeric ad IDs remain accepted as a read-time compatibility alias for
historical integrations.

The same stable identities are used for Item Info, canonical URL resolution,
contextual `PLG_itemDisplay()` rendering, metadata and lifecycle events.

Classifieds exposes:

- public menu integration;
- Geeklog search;
- autotags;
- Item Info for root, category and ad resources;
- canonical URL resolution;
- XML sitemap resources;
- save/delete lifecycle events;
- contextual `PLG_itemDisplay()` extension points;
- a bounded administration dashboard service and capability declaration.

Search, Item Info and sitemap discovery apply both ad and category visibility
where applicable.

## SEO

The public catalogue root, active categories and active ads are addressable
resources with canonical URLs.

Catalogue/category pages provide a visible page heading and resource-specific
page title. Ad pages derive a meta description from visible ad text. Operational
or duplicate route variants such as edit/contact/profile/filter views use
`noindex,follow` where appropriate.

The sitemap exposes the catalogue root, active categories and active ads while
respecting visibility constraints.

Classifieds 1.4.0 intentionally does not invent a generic Product JSON-LD object:
the plugin supports both offers and demands, so one schema type would not
faithfully describe every ad. Structured data should be added only when the
visible ad subtype can be represented accurately.

## Persistent media

Ad images are persistent public media and are intentionally stored under the
active site's configured images path in a Classifieds-specific directory. The
path is derived from the active site configuration, not from a shared plugin
cache or a hard-coded global directory.

Direct image URLs are part of the public ad presentation. The plugin sanitizes
stored filenames and keeps database/file lifecycle handling inside its image
helpers.

## Optional integrations

The Memorandum requires optional integrations only when they have a real user
role. Classifieds 1.4.0 does not add feeds, What's New or extra Geeklog dynamic
blocks merely to satisfy a checklist. They can be added later if a concrete
product requirement justifies them.

## Release validation

CI verifies:

- PHP 5.6 syntax for shipped PHP/INC files;
- absence of legacy full-page `COM_siteHeader()` / `COM_siteFooter()`;
- required `plugin.json` metadata;
- English/French functional language-key parity;
- one canonical definition per Classifieds Plugin API callback;
- one top-level `classifieds/` directory in the ZIP;
- required files inside the actual generated archive;
- ZIP integrity.

This document records intentional boundaries; it is not a substitute for
runtime testing on clean and upgraded Geeklog installations.
