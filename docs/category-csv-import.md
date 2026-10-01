# Category CSV import guide

Classifieds 1.4.0 can import a complete category hierarchy from a UTF-8 CSV file. The importer is designed so administrators never need to know or reuse database `cid` / `pid` values.

## Required columns

The first row must be exactly:

```csv
key,category,parent_key,order
```

- `key` — stable import identifier. It must be unique in the file. Allowed characters are lowercase letters, digits, dots, underscores and hyphens.
- `category` — category label shown to site users, maximum 32 characters.
- `parent_key` — `key` of the parent row. Leave it empty for a root category.
- `order` — display order among categories sharing the same parent, from 0 to 65535.

Comma and semicolon separators are accepted. UTF-8 with or without BOM is supported.

## Basic example

```csv
key,category,parent_key,order
vehicles,Vehicles,,10
cars,Cars,vehicles,10
motorcycles,Motorcycles,vehicles,20
real-estate,Real estate,,20
real-estate-sale,Sale,real-estate,10
real-estate-rental,Rental,real-estate,20
```

This creates:

```text
Vehicles
├── Cars
└── Motorcycles

Real estate
├── Sale
└── Rental
```

## More than two levels

The hierarchy is not limited to one category + one subcategory level.

```csv
key,category,parent_key,order
property,Property,,10
sale,For sale,property,10
apartments,Apartments,sale,10
houses,Houses,sale,20
```

This creates:

```text
Property
└── For sale
    ├── Apartments
    └── Houses
```

Rows do not have to be ordered parent-first. The importer resolves dependencies from the keys before writing to the database.

## Rules and validation

The importer validates the complete file before any database write. It rejects:

- a missing or modified four-column header;
- duplicate keys;
- invalid keys;
- empty or overlong category names;
- parent keys that are not present in the same file;
- a category referencing itself as parent;
- circular parent relationships;
- invalid display-order values;
- malformed rows;
- files larger than 256 KB.

If a category with the same name already exists under the same parent, that row is skipped instead of creating a duplicate.

## Recommended workflow

1. In Classifieds administration, open **Categories**.
2. Choose **Download CSV template**.
3. Edit the file in a spreadsheet or text editor.
4. Keep the exact header `key,category,parent_key,order`.
5. Use a unique `key` for every row.
6. Leave `parent_key` empty for root categories; otherwise use the parent row's `key`.
7. Upload the file using **Import categories from CSV**.
8. Review the preview. It shows which categories will be created and which existing categories will be skipped.
9. Confirm only when the preview is correct.

The file is parsed and validated again at confirmation time. The database import is transactional, so a database error does not leave a partial hierarchy.

## Spreadsheet tips

When using LibreOffice Calc or another spreadsheet:

- save/export as CSV in UTF-8;
- keep four columns only;
- do not let the spreadsheet convert keys into numbers or dates;
- avoid inserting formulas in the CSV fields;
- use plain integers in the `order` column.

## Why keys are used instead of database IDs

Database category IDs are local to each Geeklog installation. A CSV containing `cid` or `pid` values would therefore not be portable.

The import-only `key` / `parent_key` relationship makes the same CSV reusable on development, test and production sites while Classifieds continues to store its native `cid` / `pid` hierarchy internally.
