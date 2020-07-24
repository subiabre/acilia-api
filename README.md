1. [About](#About)
2. [Installing](#Installing)
3. [Configuring](#Configuring)
4. [Build and run](#Build-and-run)
5. [Testing](#Testing)

## About
Given app specs are:
- [x] Use Symfony 4.*
- [x] Use Doctrine
- [x] Don't use API Platform bundle
- [x] Content-Type is always `application/json` (request and response)
- [x] DB dump file with test data

I also extended the app specs with some goodies:
- [x] Use [Symfony best practices](https://symfony.com/doc/4.4/best_practices.html)
- [x] Use [snowflake](https://blog.twitter.com/engineering/en_us/a/2010/announcing-snowflake.html) based ids. Safer than default numeric ids and allow for easier escalation.
- [x] Use composer scripts to ease app development and deployment.

## Installing
Before installing this application, make sure the [Symfony binary](https://symfony.com/download) is installed in your system.

Clone:
```console
$ git clone https://github.com/subiabre/acilia-api
```

Install dependencies:
```console
$ composer install
```

## Configuring
Create a `.env.local` and edit it to override the default environment variables.
```console
$ cp .env .env.local
```

For demo purposes all that it's need to be configured is the `DATABASE_URL` variable.

## Build and run
Update the database schema.

You can either use the `db_dump.sql` file to create and populate the database schema, however this file might not be up to date with migrations; the alternative is to only build the schema from the latest migration:

```console
$ composer run-script update-database
```

Build app for production:
```console
$ composer run-script build
$ symfony serve
```
> Remember once the app is in production mode bundles in the dev scope will unregister.

## Testing
This application uses PHPUnit for testing.
```console
$ composer run-script test
```
