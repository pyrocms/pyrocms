# Contribution Guide

Thank you for considering contributing to Pyro! Please review the entire guide before sending a pull request.

## Bug Reports

Wes strongly encourages pull requests, not just bug reports.

"Bug Report" should contain a title and a clear detailed description of the issue. You should also include as much relevant information as possible and a code sample that demonstrates the issue. The goal of a bug report is to make it easy for yourself - and others - to replicate the bug and develop a fix.

Remember, bug reports are created in the hope that others with the same problem will be able to collaborate with you on solving it. Do not expect that the bug report will automatically see any activity or that others will jump to fix it. Creating a bug report serves to help yourself and others start on the path of fixing the problem.


## Which Repository?

Please send all issues to the base `pyrocms/pyrocms` repository in order to keep them consolidated. Send all pull requests to the respective repository in which they apply to and the branch as described below.


## Which Branch?

All bug fixes should be sent to the latest stable branch. Bug fixes should never be sent to the master branch unless they fix features that exist only in the upcoming release.

Minor features that are fully backwards compatible with the current Pyro release may be sent to the latest stable branch.

Major new features should always be sent to the master branch, which contains the upcoming Pyro release.

If you are unsure if your feature qualifies as a major or minor, please ask Ryan Thompson in the #general Slack channel (pyrocms.slack.com).


## Security Vulnerabilities

If you discover a security vulnerability within Pyro, please send an e-mail to Ryan Thompson at ryan@pyrocms.com. All security vulnerabilities will be promptly addressed.


## Coding Style

Pyro follows the PSR-4, PSR-2 and PSR-1 coding standards. In addition to these standards, the following coding standards should be followed:

The class namespace declaration must be on the same line as <?php.
Indent with tabs, align with spaces.
