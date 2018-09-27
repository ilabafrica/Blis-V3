<p>
<a href="https://travis-ci.org/ilabafrica/Blis-V3"><img src="https://travis-ci.org/ilabafrica/Blis-V3.svg" alt="Build Status"></a>
</p>

# Basic Laboratory Information System

BLIS is an open-source system to track patient specimens,Test and laboratory results.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Installing

A step by step series of examples that tell you have to get a development env running

Installing dependencies

```
composer install
```

Configure the environment variables

```
Make a copy of the .env.example as .env and put the correct credentials into the file.
``` 

Migrate the database tables

```
php artisan migrate
```

Seed test data

```
php artisan db:seed
```
Configure Passport for Api Authentication

```
php artisan passport:install
```

Start the development server

```
php artisan serve
```

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE) for details

## Acknowledgments

BLIS is a port of the Basic Laboratory Information System ([BLIS](https://github.com/C4G/BLIS)) to the Laravel PHP Framework by [@iLabAfrica](http://www.ilabafrica.ac.ke/).
BLIS was originally developed by C4G. 
