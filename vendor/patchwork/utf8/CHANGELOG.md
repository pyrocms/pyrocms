## v1.1.16 (2013-12-06)

- fix $_FILES bootup filtering
- fix mbstring shim behavior with invalid utf8 strings

## v1.1.15 (2013-11-23)

- u::toAscii() is now locale sensitive and allows a substitution character
- use LSB for more extension openness
- handle null for mb_substr() shim length as in PHP 5.4.8
- fix casts to string
- fix mbstring MB_CASE_TITLE shim on edge case
- small optimizations
- add a changelog

## v1.1.14 (2013-11-04)

- set default_charset to UTF-8 at bootup
- remove bootup PCRE warning
- fix iconv internal_encoding shim
- fix bootup dependencies
- add tests for normalizers consts
- readme update

## v1.1.13 (2013-10-11)

- new u::filter(): normalizes to UTF-8 NFC, converting from CP-1252 when needed
- new u::json_decode(), u::filter_input() and u::filter_input_array() for NFC safeness
- reference Unicode 6.3
- more tests
- readme update

## v1.1.12 (2013-10-03)

- new Patchwork\TurkishUtf8 class extends Patchwork\Utf8 with Turkish specifics
- expose Patchwork\Utf8\Bootup::filterString() for UF-8 NFC strings normalization
- normalize inputs EOL to work around https://bugs.php.net/65732
- update composer.json

## v1.1.11 (2013-08-19)

- updates related to PHP bugs 52211 and 61860
- fixes and tests for iconv shim
- fixes and tests for mbstring shim

## v1.1.10 (2013-08-13)

- update .gitattributes export-ignore
- fixes and tests for intl::grapheme_extract() shim
- fixes and tests for iconv shim
- fixes and tests for mbstring shim

## v1.1.9 (2013-08-04)

- know that PHP bug 61860 has been fixed in 5.5.1
- fix intl::grapheme_strlen() shim on edge case
- fix case sensitive encoding checks for mbstring shim
- some more fixes, tests and optimizations

## v1.1.8 since v1.1.0 (2013-05-24)

- filter leading combining chars in inputs for NFC safeness
- fixes, tests and optimizations
- readme update

## v1.1.0 (2013-04-18)

- PSR-0 autoloading and explicit bootup configuration is now required

## v1.0.6 since v1.0.0 (2013-04-22)

- add extra characters for ASCII transliterations
- move bootup stages in namespaced functions for greater modularity
- NFC normalization for autoglobal inputs
- better setlocale() initialization
- fix fatal error caused by multiple bootup inclusion
- fix bootup

## v1.0.0 (2012-10-15)

- first official release of a work started in 2007
- Apache v2.0 / GPL v2.0 dual-licensed
- PHP portability implementations for mbstring, iconv, intl grapheme_*() and utf8_encode/decode()
- Unicode compliant and portable Normalizer
- grapheme clusters aware UTF-8 handling string functions replica
- PHP runtime environment configuration for UTF-8
- extra functions for UTF-8 validity checks, transliterations and case folding
- covered by unit tests
