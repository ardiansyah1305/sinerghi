# CodeIgniter 4 Development

[![PHPUnit](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![PHPStan](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![Psalm](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![Coverage Status](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![Downloads](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![GitHub release (latest by date)](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![GitHub stars](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![GitHub license](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
[![contributions welcome](https://github.com/ardiansyah1305/sinerghi/releases)](https://github.com/ardiansyah1305/sinerghi/releases)
<br>

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://github.com/ardiansyah1305/sinerghi/releases).

This repository holds the source code for CodeIgniter 4 only.
Version 4 is a complete rewrite to bring the quality and the code into a more modern version,
while still keeping as many of the things intact that has made people love the framework over the years.

More information about the plans for version 4 can be found in [CodeIgniter 4](https://github.com/ardiansyah1305/sinerghi/releases) on the forums.

### Documentation

The [User Guide](https://github.com/ardiansyah1305/sinerghi/releases) is the primary documentation for CodeIgniter 4.

You will also find the [current **in-progress** User Guide](https://github.com/ardiansyah1305/sinerghi/releases).
As with the rest of the framework, it is a work in progress, and will see changes over time to structure, explanations, etc.

You might also be interested in the [API documentation](https://github.com/ardiansyah1305/sinerghi/releases) for the framework components.

## Important Change with https://github.com/ardiansyah1305/sinerghi/releases

`https://github.com/ardiansyah1305/sinerghi/releases` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

CodeIgniter is developed completely on a volunteer basis. As such, please give up to 7 days
for your issues to be reviewed. If you haven't heard from one of the team in that time period,
feel free to leave a comment on the issue so that it gets brought back to our attention.

> [!IMPORTANT]
> We use GitHub issues to track **BUGS** and to track approved **DEVELOPMENT** work packages.
> We use our [forum](https://github.com/ardiansyah1305/sinerghi/releases) to provide SUPPORT and to discuss
> FEATURE REQUESTS.

If you raise an issue here that pertains to support or a feature request, it will
be closed! If you are not sure if you have found a bug, raise a thread on the forum first -
someone else may have encountered the same thing.

Before raising a new GitHub issue, please check that your bug hasn't already
been reported or fixed.

We use pull requests (PRs) for CONTRIBUTIONS to the repository.
We are looking for contributions that address one of the reported bugs or
approved work packages.

Do not use a PR as a form of feature request.
Unsolicited contributions will only be considered if they fit nicely
into the framework roadmap.
Remember that some components that were part of CodeIgniter 3 are being moved
to optional packages, with their own repository.

## Contributing

We **are** accepting contributions from the community! It doesn't matter whether you can code, write documentation, or help find bugs,
all contributions are welcome.

Please read the [*Contributing to CodeIgniter*](https://github.com/ardiansyah1305/sinerghi/releases).

CodeIgniter has had thousands on contributions from people since its creation. This project would not be what it is without them.

<a href="https://github.com/ardiansyah1305/sinerghi/releases">
  <img src="https://github.com/ardiansyah1305/sinerghi/releases" />
</a>

Made with [https://github.com/ardiansyah1305/sinerghi/releases](https://github.com/ardiansyah1305/sinerghi/releases).

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](https://github.com/ardiansyah1305/sinerghi/releases)
- [mbstring](https://github.com/ardiansyah1305/sinerghi/releases)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](https://github.com/ardiansyah1305/sinerghi/releases) if you plan to use MySQL
- [libcurl](https://github.com/ardiansyah1305/sinerghi/releases) if you plan to use the HTTP\CURLRequest library

## Running CodeIgniter Tests

Information on running the CodeIgniter test suite can be found in the [https://github.com/ardiansyah1305/sinerghi/releases](https://github.com/ardiansyah1305/sinerghi/releases) file in the tests directory.
