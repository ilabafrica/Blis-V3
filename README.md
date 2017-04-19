# Basic Laboratory Information System

BLIS is an open-source system to track patient specimens,Test and laboratory results.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
1. PHP >= 5.6.4
2. OpenSSL PHP Extension
3. PDO PHP Extension
4. Mbstring PHP Extension
5. Tokenizer PHP Extension
6. XML PHP Extension
```

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

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Coming soon
```

### And coding style tests

Explain what these tests test and why

```
Coming soon
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Derrick Rono** - *Initial work* - [drizzentic](https://github.com/drizzentic)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details

## Acknowledgments

* Developments Team