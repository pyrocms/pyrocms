---
title: Contributing
---

## Contributing[](#contributing)

This section will go over how to contribute to PyroCMS, addons, and it's components.



### Bug Reports[](#contributing/bug-reports)

To encourage active collaboration, pull requests are strongly encouraged, not just bug reports. "Bug reports" may also be sent in the form of a pull request.

However, if you file a bug report, your issue should contain a title and a clear, detailed description of the issue. You should include as much relevant information as possible and a code sample or link to your repository that demonstrates the issue. The goal of a bug report is to make it easy for yourself - and others - to replicate the bug and develop a fix quickly.

Remember, bug reports are created in the hope that others with the same problem will be able to collaborate with you on solving it. Do not expect that the bug report will automatically see any activity or that others will jump to fix it. Creating a bug report serves to help yourself and others start on the path of fixing the problem you are experiencing.

Please submit _all_ bug reports to the [http://github.com/pyrocms/pyrocms](PyroCMS repository). All pull requests must be submitted to the applicable addon repository.

When submitting bug reports for other addons to the PyroCMS repository please prefix the repository the bug report is for by prefixing it with the application addon.

    [streams-platform] Your bug report title here.



### Development Discussion[](#contributing/development-discussion)

Discussion regarding bugs, new features, and implementation of existing features should take place on the [http://pyrocms.com/forum](PyroCMS forum). Discussion can also be had in the [PyroCMS Slack team](https://pyrocms.slack.com/). Ryan Thompson, the lead developer, is typically present in the channel on weekdays from 10am-4pm (UTC-06:00 or America/Chicago).



### Which Branch?[](#contributing/which-branch)

*All** bug fixes should be sent to the latest stable branch. Bug fixes should **never** be sent to the `master` branch unless no develop branch exists for whatever reason.

**Minor** features that are **fully backwards compatible** with the current release may be sent to the latest stable branch.

**Major** new features should always be sent to the `develop` branch, which contains upcoming releases.

If you are unsure if your feature qualifies as a major or minor, please ask `ryanthompson` in the `#general` [PyroCMS Slack channel](https://pyrocms.slack.com/).



### Security Vulnerabilities[](#contributing/security-vulnerabilities)

If you discover a security vulnerability within PyroCMS, please send an e-mail to Ryan Thompson at [ryan@pyrocms.com](mailto:ryan@pyrocms.com). All security vulnerabilities will be promptly addressed.



### Coding Style[](#contributing/coding-style)

Streams Platform and all addons follow the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.
