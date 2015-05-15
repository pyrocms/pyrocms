# Contribution Guide

Thank you for considering contributing to the Streams Platform! Please review the entire guide before sending a pull request.

## Bug Reports

We strongly encourages pull requests, not just bug reports.

"Bug Report" should contain a title and a clear detailed description of the issue. You should also include as much relevant information as possible and a code sample that demonstrates the issue. The goal of a bug report is to make it easy for yourself - and others - to replicate the bug and develop a fix.

Remember, bug reports are created in the hope that others with the same problem will be able to collaborate with you on solving it. Do not expect that the bug report will automatically see any activity or that others will jump to fix it. Creating a bug report serves to help yourself and others start on the path of fixing the problem.


## Which Branch?

All bug fixes should be sent to the latest stable branch. Bug fixes should never be sent to the master branch unless they fix features that exist only in the upcoming release.

Minor features that are fully backwards compatible with the current Laravel release may be sent to the latest stable branch.

Major new features should always be sent to the master branch, which contains the upcoming Laravel release.

If you are unsure if your feature qualifies as a major or minor, please ask Taylor Otwell in the #laravel-dev IRC channel (Freenode).


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.


## Coding Style

Laravel follows the PSR-4 and PSR-1 coding standards. In addition to these standards, the following coding standards should be followed:

The class namespace declaration must be on the same line as <?php.
A class' opening { must be on the same line as the class name.
Functions and control structures must use Allman style braces.
Indent with tabs, align with spaces.