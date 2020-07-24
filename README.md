This package is a coding test for a job interview.

## About
Tasks were to:
- [x] Build REST API
- [x] Use Symfony 4.*
- [x] Use Doctrine
- [x] Don't use API Platform bundle
- [x] Content-Type is always `application/json` (request and response)
- [x] Symfony Best Practices

I also extended the app specs with some goodies:

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

For demo purposes, all that it's need to be configured is the `DATABASE_URL` variable.

## Build and run
Update the database schema:
```console
$ composer run-script update-database
```

After this you can use the `db_dump.sql` file to populate the database. You can also use it to directly build the db schema without update-database, however this file might not be up to date with migrations.

Build app for production:
```console
$ composer run-script build
$ symfony serve
```
> Remember once the app is in production mode bundles in the dev scope will unregister.

## Testing
```console
$ composer run-script test
```
