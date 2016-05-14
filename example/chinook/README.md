# Chinook Database Repository Example

https://chinookdatabase.codeplex.com/

Implementation of repository for chinook sample database to show how to approach to coding of repository pattern for RDBMS database.
The whole idea is to have ORM like query model with full controll over statement execution and data hydration.

## Example of usage:

Return AC/DC albums that contains track with name `Bad Boy Boogie` with all tracks details for those albums:

```php
use Example\Chinook\Artists\Repository as ArtistsRepository;

$data = (new ArtistsRepository())
    ->includeAlbums([
        'onlyWithTrackName' => 'Bad Boy Boogie',
        'includeTracks' => []
    ])
    ->filterByName('AC/DC')
    ->assemble()
;
```