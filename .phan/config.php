<?php

use Phan\Issue as PhanIssue;

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command-line arguments will be applied
 * after this file is read.
 */
return [
    // Supported values: `'5.6'`, `'7.0'`, `'7.1'`, `'7.2'`, `'7.3'`,
    // `'7.4'`, `null`.
    // If this is set to `null`,
    // then Phan assumes the PHP version which is closest to the minor version
    // of the php executable used to execute Phan.
    //
    // Note that the **only** effect of choosing `'5.6'` is to infer
    // that functions removed in php 7.0 exist.
    // (See `backward_compatibility_checks` for additional options)
    'target_php_version' => '7.3',
    // Run a quick version of checks that takes less time	                                        
    'quick_mode' => true,
    // Only emit critical issues to start with
    // (0 is low severity, 5 is normal severity, 10 is critical)
    'minimum_severity' => PhanIssue::SEVERITY_CRITICAL,
    // Add any issue types (such as `'PhanUndeclaredMethod'`)
    // to this list to inhibit them from being reported.
    'suppress_issue_types' => [
        //'PhanUndeclaredClassConstant',
        //'PhanUndeclaredMethod',
    ],
    // A list of directories that should be parsed for class and
    // method information. After excluding the directories
    // defined in exclude_analysis_directory_list, the remaining
    // files will be statically analyzed for errors.
    //
    // Thus, both first-party and third-party code being used by
    // your application should be included in this list.
    'directory_list' => ['src/', 'vendor/'],
    // A regex used to match every file name that you want to
    // exclude from parsing. Actual value will exclude every
    // "test", "tests", "Test" and "Tests" folders found in
    // "vendor/" directory.
    'exclude_file_regex' => '@^vendor/.*/(tests?|Tests?)/@',
    // A directory list that defines files that will be excluded
    // from static analysis, but whose class and method
    // information should be included.
    //
    // Generally, you'll want to include the directories for
    // third-party code (such as "vendor/") in this list.
    //
    // n.b.: If you'd like to parse but not analyze 3rd
    //       party code, directories containing that code
    //       should be added to both the `directory_list`
    //       and `exclude_analysis_directory_list` arrays.
    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
];
