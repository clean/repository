# Clean\Repository

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clean/repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clean/repository/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clean/repository/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/clean/repository/?branch=master)
[![Build Status](https://travis-ci.org/clean/repository.svg?branch=master)](https://travis-ci.org/clean/repository)

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
   not older then 10 year,
   only with disel engine,
   with information about last 2 owners,
   include pictures of car
*/
$carRepository
    ->limit(4)
    ->filterByMark('toyota')
    ->notOlderThen(10)
    ->onlyDisel()
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
* you can also define your own rules valid for your project like `notOlderThen`
