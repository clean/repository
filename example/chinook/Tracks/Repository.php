<?php namespace Example\Chinook\Tracks;

use Example\Chinook\AbstractRepository;

class Repository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->getBaseCriteria()
            ->cols([
                'TrackId' => 'trackId',
                'Name' => 'name',
                'AlbumId' => 'albumId',
                'MediaTypeId' => 'mediaTypeId',
                'GenreId' => 'genreId',
                'Composer' => 'composer',
                'Milliseconds' => 'milliseconds',
                'Bytes' => 'bytes',
                'UnitPrice' => 'unitPrice',
            ])
            ->from('tracks');
    }

    public function assemble()
    {
        $collection = parent::assemble();

        return $collection;
    }

    public function filterByAlbumIds(array $ids)
    {
        $this->getBaseCriteria()
            ->where('albumId IN (:filterByAlbumIds)')
            ->bindValues([
                'filterByAlbumIds' => $ids,
            ])
        ;

        return $this;
    }

    public function filterByName($name)
    {
        $this->getBaseCriteria()
            ->where('name == (:filterByName)')
            ->bindValues([
                'filterByName' => $name,
            ])
        ;

        return $this;
    }
}
