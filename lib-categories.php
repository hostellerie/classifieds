<?php

/* Reminder: always indent with 4 spaces (no tabs). */

/**
 * CSV category import helpers for Classifieds.
 *
 * CSV format:
 * key,category,parent_key,order
 *
 * The key columns are import-only identifiers used to resolve parent/child
 * relationships. Classifieds continues to persist its native cid/pid model.
 */

$phpSelf = isset($_SERVER['PHP_SELF']) ? (string) $_SERVER['PHP_SELF'] : '';

if (strpos(strtolower($phpSelf), 'lib-categories.php') !== false) {
    die('This file can not be used on its own.');
}

/**
 * Parse and validate a category CSV document without touching the database.
 *
 * @param string $csv
 * @return array
 */
function CLASSIFIEDS_parseCategoryCsv($csv)
{
    $result = array(
        'rows' => array(),
        'errors' => array(),
        'delimiter' => ',',
    );

    if (!is_string($csv) || trim($csv) === '') {
        $result['errors'][] = 'empty';
        return $result;
    }

    if (strlen($csv) > 262144) {
        $result['errors'][] = 'too_large';
        return $result;
    }

    $firstLineEnd = strpos($csv, "\n");
    $firstLine = ($firstLineEnd === false) ? $csv : substr($csv, 0, $firstLineEnd);
    $comma = str_getcsv($firstLine, ',');
    $semicolon = str_getcsv($firstLine, ';');
    $delimiter = (count($semicolon) > count($comma)) ? ';' : ',';
    $result['delimiter'] = $delimiter;

    $stream = fopen('php://temp', 'r+');
    if ($stream === false) {
        $result['errors'][] = 'read_failed';
        return $result;
    }

    fwrite($stream, $csv);
    rewind($stream);

    $header = fgetcsv($stream, 0, $delimiter);
    if (!is_array($header)) {
        fclose($stream);
        $result['errors'][] = 'header';
        return $result;
    }

    if (isset($header[0])) {
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', trim((string) $header[0]));
    }

    $normalizedHeader = array();
    foreach ($header as $column) {
        $normalizedHeader[] = strtolower(trim((string) $column));
    }

    $required = array('key', 'category', 'parent_key', 'order');
    if ($normalizedHeader !== $required) {
        fclose($stream);
        $result['errors'][] = 'header';
        return $result;
    }

    $keys = array();
    $lineNumber = 1;

    while (($fields = fgetcsv($stream, 0, $delimiter)) !== false) {
        $lineNumber++;

        $allEmpty = true;
        foreach ($fields as $field) {
            if (trim((string) $field) !== '') {
                $allEmpty = false;
                break;
            }
        }
        if ($allEmpty) {
            continue;
        }

        if (count($fields) !== 4) {
            $result['errors'][] = array('code' => 'columns', 'line' => $lineNumber);
            continue;
        }

        $key = strtolower(trim((string) $fields[0]));
        $category = trim((string) $fields[1]);
        $parentKey = strtolower(trim((string) $fields[2]));
        $orderRaw = trim((string) $fields[3]);

        if (!preg_match('/^[a-z0-9][a-z0-9._-]{0,63}$/', $key)) {
            $result['errors'][] = array('code' => 'key', 'line' => $lineNumber, 'value' => $key);
        }

        if (isset($keys[$key])) {
            $result['errors'][] = array('code' => 'duplicate_key', 'line' => $lineNumber, 'value' => $key);
        } else {
            $keys[$key] = $lineNumber;
        }

        if ($category === '' || strlen($category) > 128) {
            $result['errors'][] = array('code' => 'category', 'line' => $lineNumber, 'value' => $category);
        } elseif (function_exists('mb_strlen') && mb_strlen($category, 'UTF-8') > 32) {
            $result['errors'][] = array('code' => 'category', 'line' => $lineNumber, 'value' => $category);
        } elseif (!function_exists('mb_strlen') && strlen($category) > 32) {
            $result['errors'][] = array('code' => 'category', 'line' => $lineNumber, 'value' => $category);
        }

        if ($parentKey !== '' && $parentKey === $key) {
            $result['errors'][] = array('code' => 'self_parent', 'line' => $lineNumber, 'value' => $key);
        }

        if ($orderRaw === '') {
            $order = 0;
        } elseif (!ctype_digit($orderRaw) || (int) $orderRaw > 65535) {
            $result['errors'][] = array('code' => 'order', 'line' => $lineNumber, 'value' => $orderRaw);
            $order = 0;
        } else {
            $order = (int) $orderRaw;
        }

        $result['rows'][] = array(
            'line' => $lineNumber,
            'key' => $key,
            'category' => $category,
            'parent_key' => $parentKey,
            'order' => $order,
        );
    }

    fclose($stream);

    if (empty($result['rows']) && empty($result['errors'])) {
        $result['errors'][] = 'empty';
        return $result;
    }

    $byKey = array();
    foreach ($result['rows'] as $row) {
        if ($row['key'] !== '' && !isset($byKey[$row['key']])) {
            $byKey[$row['key']] = $row;
        }
    }

    foreach ($result['rows'] as $row) {
        if ($row['parent_key'] !== '' && !isset($byKey[$row['parent_key']])) {
            $result['errors'][] = array(
                'code' => 'missing_parent',
                'line' => $row['line'],
                'value' => $row['parent_key'],
            );
        }
    }

    // Detect cycles in the key -> parent_key graph.
    $state = array();
    $visit = function ($key) use (&$visit, &$state, $byKey, &$result) {
        if (isset($state[$key])) {
            if ($state[$key] === 1) {
                $result['errors'][] = array('code' => 'cycle', 'line' => $byKey[$key]['line'], 'value' => $key);
            }
            return;
        }

        $state[$key] = 1;
        $parent = isset($byKey[$key]) ? $byKey[$key]['parent_key'] : '';
        if ($parent !== '' && isset($byKey[$parent])) {
            $visit($parent);
        }
        $state[$key] = 2;
    };

    foreach ($byKey as $key => $row) {
        $visit($key);
    }

    return $result;
}

/**
 * Find an existing category by its name under one parent.
 *
 * @param int $pid
 * @param string $category
 * @return int
 */
function CLASSIFIEDS_findCategoryByParentAndName($pid, $category)
{
    global $_TABLES;

    $safe = DB_escapeString($category);
    return (int) DB_getItem(
        $_TABLES['cl_cat'],
        'cid',
        "pid = " . (int) $pid . " AND category = '" . $safe . "'"
    );
}

/**
 * Build a preview using the same dependency resolution as the real import.
 *
 * @param array $rows
 * @return array
 */
function CLASSIFIEDS_previewCategoryImport($rows)
{
    $resolved = array();
    $pending = array_values($rows);
    $preview = array();
    $virtualId = -1;
    $guard = count($pending) + 1;

    while (!empty($pending) && $guard-- > 0) {
        $next = array();
        $progress = false;

        foreach ($pending as $row) {
            if ($row['parent_key'] !== '' && !isset($resolved[$row['parent_key']])) {
                $next[] = $row;
                continue;
            }

            $pid = ($row['parent_key'] === '') ? 0 : $resolved[$row['parent_key']];
            $existingCid = CLASSIFIEDS_findCategoryByParentAndName($pid, $row['category']);

            if ($existingCid > 0) {
                $resolved[$row['key']] = $existingCid;
                $status = 'skip';
            } else {
                // Negative IDs let children resolve against categories that will
                // be created earlier in the same import without touching the DB.
                $resolved[$row['key']] = $virtualId--;
                $status = 'create';
            }

            $row['status'] = $status;
            $preview[] = $row;
            $progress = true;
        }

        if (!$progress) {
            break;
        }
        $pending = $next;
    }

    return $preview;
}

/**
 * Import a previously validated CSV category set.
 *
 * @param array $rows
 * @return array
 */
function CLASSIFIEDS_importCategories($rows)
{
    global $_TABLES, $_USER;

    $result = array(
        'created' => 0,
        'skipped' => 0,
        'error' => '',
    );

    $resolved = array();
    $createdIds = array();
    $pending = array_values($rows);
    $guard = count($pending) + 1;

    DB_query('START TRANSACTION');

    while (!empty($pending) && $guard-- > 0) {
        $next = array();
        $progress = false;

        foreach ($pending as $row) {
            if ($row['parent_key'] !== '' && !isset($resolved[$row['parent_key']])) {
                $next[] = $row;
                continue;
            }

            $pid = ($row['parent_key'] === '') ? 0 : (int) $resolved[$row['parent_key']];
            $existingCid = CLASSIFIEDS_findCategoryByParentAndName($pid, $row['category']);

            if ($existingCid > 0) {
                $resolved[$row['key']] = $existingCid;
                $result['skipped']++;
                $progress = true;
                continue;
            }

            $sql = "INSERT INTO {$_TABLES['cl_cat']} "
                . "(pid, category, catorder, catdeleted, owner_id) VALUES ("
                . (int) $pid . ", '"
                . DB_escapeString($row['category']) . "', "
                . (int) $row['order'] . ", 0, "
                . (int) $_USER['uid'] . ")";

            DB_query($sql);
            if (DB_error()) {
                DB_query('ROLLBACK');
                $result['error'] = 'database';
                return $result;
            }

            $cid = (int) DB_insertId();
            if ($cid <= 0) {
                DB_query('ROLLBACK');
                $result['error'] = 'database';
                return $result;
            }

            $resolved[$row['key']] = $cid;
            $createdIds[] = $cid;
            $result['created']++;
            $progress = true;
        }

        if (!$progress) {
            DB_query('ROLLBACK');
            $result['error'] = 'dependency';
            return $result;
        }

        $pending = $next;
    }

    if (!empty($pending)) {
        DB_query('ROLLBACK');
        $result['error'] = 'dependency';
        return $result;
    }

    DB_query('COMMIT');

    if (!DB_error()) {
        foreach ($createdIds as $createdCid) {
            PLG_itemSaved('category:' . (int) $createdCid, 'classifieds');
        }
    }

    return $result;
}

/**
 * Render localized validation errors.
 *
 * @param array $errors
 * @return string
 */
function CLASSIFIEDS_categoryImportErrorsHtml($errors)
{
    global $_CONF, $LANG_CLASSIFIEDS_ADMIN;

    if (empty($errors)) {
        return '';
    }

    $html = '<div class="plugin-alert plugin-alert--danger"><p><strong>'
        . htmlspecialchars($LANG_CLASSIFIEDS_ADMIN['csv_errors_title'], ENT_QUOTES, $_CONF['default_charset'])
        . '</strong></p><ul>';

    foreach ($errors as $error) {
        if (is_string($error)) {
            $code = $error;
            $line = 0;
            $value = '';
        } else {
            $code = isset($error['code']) ? $error['code'] : 'invalid';
            $line = isset($error['line']) ? (int) $error['line'] : 0;
            $value = isset($error['value']) ? (string) $error['value'] : '';
        }

        $key = 'csv_error_' . $code;
        $message = isset($LANG_CLASSIFIEDS_ADMIN[$key])
            ? $LANG_CLASSIFIEDS_ADMIN[$key]
            : $LANG_CLASSIFIEDS_ADMIN['csv_error_invalid'];

        if ($line > 0) {
            $message = sprintf($message, $line, $value);
        }

        $html .= '<li>'
            . htmlspecialchars($message, ENT_QUOTES, $_CONF['default_charset'])
            . '</li>';
    }

    $html .= '</ul></div>';
    return $html;
}

?>