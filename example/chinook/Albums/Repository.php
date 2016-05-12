<?php namespace Example\Chinook\Albums;

use Example\Chinook\AbstractRepository;
use Example\Chinook\Tracks\Repository as TracksRepository;

class Repository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();

        $this->getBaseCriteria()
            ->cols([
                'a.AlbumId' => 'albumId',
                'a.Title' => 'title',
                'a.ArtistId' => 'artistId',
            ])
            ->from('albums as a');
    }

    public function assemble()
    {
        $collection = parent::assemble();

        if ($this->hasCriteria('Tracks')) {
            $tracks = $this->getCriteria('Tracks')
                ->filterByAlbumIds($collection->getAllValuesForProperty('albumId'))
                ->assemble();

            $collection->bindCollection($tracks, ['albumId' => 'albumId'], 'Tracks');
        }

        return $collection;
    }

    public function filterByArtistIds(array $ids)
    {
        $this->getBaseCriteria()
            ->where('ArtistId IN (:filterByArtistIds)')
            ->bindValues([
                'filterByArtistIds' => $ids,
            ])
        ;

        return $this;
    }

    public function onlyWithTrackName($name)
    {
        $this->getBaseCriteria()
            ->join(
                'LEFT',
                'tracks as t',
                't.AlbumId == a.AlbumId'
            )
            ->where('t.Name == :onlyWithTrackName')
            ->bindValue('onlyWithTrackName', $name)
        ;
        return $this;
    }

    public function includeTracks(array $params = [])
    {
        $this->setCriteria(
            'Tracks',
            (new TracksRepository)->invoke((object)$params)
        );
            
        return $this;
    }
}
