<?php namespace Example\Chinook\Artists;

use Example\Chinook\AbstractRepository;
use Example\Chinook\Albums\Repository as AlbumsReposiory;

class Repository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->getBaseCriteria()
            ->cols([
                'ArtistId' => 'artistId',
                'Name' => 'name',
            ])
            ->from('artists');
    }

    public function assemble()
    {
        $collection = parent::assemble();

        if ($this->hasCriteria('Albums')) {
            $albums = $this->getCriteria('Albums')
                ->filterByArtistIds($collection->getAllValuesForProperty('artistId'))
                ->assemble();

            $collection->bindCollection($albums, ['artistId' => 'artistId'], 'Albums');
        }

        return $collection;
    }

    public function filterByName($name)
    {
        $this->getBaseCriteria()
            ->where('name == :filterByName')
            ->bindValues([
                'filterByName' => $name,
            ])
        ;

        return $this;
    }

    public function includeAlbums(array $params = [])
    {
        $this->setCriteria(
            'Albums',
            (new AlbumsReposiory)->invoke((object)$params)
        );
            
        return $this;
    }
}
