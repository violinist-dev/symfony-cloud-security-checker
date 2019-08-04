# symfony-cloud-security-checker
[![Build Status](https://travis-ci.org/violinist-dev/symfony-cloud-security-checker.svg?branch=master)](https://travis-ci.org/violinist-dev/symfony-cloud-security-checker)
[![Coverage Status](https://coveralls.io/repos/github/violinist-dev/symfony-cloud-security-checker/badge.svg?branch=master)](https://coveralls.io/github/violinist-dev/symfony-cloud-security-checker?branch=master)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)

Wraps the symfony command, so we can check for security updates, with local cache.

## Why?

Because if you try to use a service like the sensiolabs security checker (https://github.com/sensiolabs/security-checker / https://security.symfony.com/) it has a rate limit. The symfony command uses a local cache.

## Installation

```bash
composer require violinist-dev/symfony-cloud-security-checker
```

You also need to download the [symfony client](https://symfony.com/download) and make it available in your `$PATH`.

## Usage

```php
$checker = new \Violinist\SymfonyCloudSecurityChecker\SecurityChecker();
$directory = '/my/project/directory/with/composer/lock/file';
try {
    $result = $checker->checkDirectory($directory);
    // Result will now be an array keyed with projects that has security advisories. Like so, for the example in the
    // tests (dompdf/dompdf):
    //array (
    //    'dompdf/dompdf' =>
    //        array (
    //            'version' => 'v0.6.0',
    //            'advisories' =>
    //                array (
    //                    0 =>
    //                        array (
    //                            'title' => 'PHP remote file inclusion vulnerability in dompdf.php',
    //                            'link' => 'https://github.com/dompdf/dompdf/releases/tag/v0.6.2',
    //                            'cve' => 'CVE-2010-4879',
    //                        ),
    //                    1 =>
    //                        array (
    //                            'title' => 'Arbitrary file read in dompdf',
    //                            'link' => 'https://www.portcullis-security.com/security-research-and-downloads/security-advisories/cve-2014-2383/',
    //                            'cve' => 'CVE-2014-2383',
    //                        ),
    //                    2 =>
    //                        array (
    //                            'title' => 'Information Disclosure',
    //                            'link' => 'https://github.com/dompdf/dompdf/releases/tag/v0.6.2',
    //                            'cve' => 'CVE-2014-5011',
    //                        ),
    //                    3 =>
    //                        array (
    //                            'title' => 'Denial Of Service Vector',
    //                            'link' => 'https://github.com/dompdf/dompdf/releases/tag/v0.6.2',
    //                            'cve' => 'CVE-2014-5012',
    //                        ),
    //                    4 =>
    //                        array (
    //                            'title' => 'Remote Code Execution (complement of CVE-2014-2383)',
    //                            'link' => 'https://github.com/dompdf/dompdf/releases/tag/v0.6.2',
    //                            'cve' => 'CVE-2014-5013',
    //                        ),
    //                ),
    //        ),
    //)
}
catch (Exception $e) {
    // This can happen if you do not have the symfony command installed, and available in your PATH.
    // It can also happen if the command itself creates unexpected output. Like it probably would if you ran it for the
    // first time without an internet connection, for example.
}
```
