# Clean\Repository

[![Build Status](https://travis-ci.org/clean/repository.svg?branch=master)](https://travis-ci.org/clean/repository)
[![Code Climate](https://codeclimate.com/github/clean/repository/badges/gpa.svg)](https://codeclimate.com/github/clean/repository)
[![Test Coverage](https://codeclimate.com/github/clean/repository/badges/coverage.svg)](https://codeclimate.com/github/clean/repository/coverage)
[![Issue Count](https://codeclimate.com/github/clean/repository/badges/issue_count.svg)](https://codeclimate.com/github/clean/repository)
[![Latest Stable Version](https://poser.pugx.org/clean/repository/v/stable)](https://packagist.org/packages/clean/repository)
[![Total Downloads](https://poser.pugx.org/clean/repository/downloads)](https://packagist.org/packages/clean/repository)
[![License](https://poser.pugx.org/clean/repository/license)](https://packagist.org/packages/clean/repository)


Use a repository to separate the logic that retrieves the data and maps it to the entity model from the business logic that acts on the model. The business logic should be agnostic to the type of data that comprises the data source layer. For example, the data source layer can be a database or a Web service.

## Objectives

* You access the data source from many locations and want to apply centrally managed, consistent access rules and logic.
* You want to implement and centralize a caching strategy for the data source.
* You want to improve the code's maintainability and readability by separating business logic from data or service access logic.

## Installation

via [Composer](https://packagist.org/packages/clean/repository):

```json
"require": {
  "clean/repository": "dev-master"
}
```

## Idea and Implementation

Repository is and object that holds multiply criterias. Those criteria can represent query to database or GET request parameters or anything else that require creating some kind of request based on various parameters.  The idea is to hide concrate implementation of generating queries or requests behind semantic layer e.g.:

```php
/*
   get 
   4 'toyota' cars,
   not older than 10 year,
   only with diesel engine,
   with information about last 2 owners,
   include pictures of car
*/
$carRepository
    ->limit(4)
    ->filterByMark('toyota')
    ->notOlderThan(10)
    ->onlyDiesel()
    ->includeOwners([
        'getLatest' => 2,
    ])
    ->includePictures()
    ->assemble();
```

There are few rules worth to follow:

* when you need to reduce result use `filter...`, or `only...` method 
* when you need to sort result use `sortBy...` method
* when you need to extend result use `with...` method
* when you need to include related entity use `include...` method
* you can also define your own rules valid for your project like `notOlderThan`

## Working example:

* [Chinook database repository example](example/chinook)
