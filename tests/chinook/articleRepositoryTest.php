<?php namespace Test\Clean\Example\Chinook\Article\Repository;

use Example\Chinook\Artists\Repository as ArtistsRepository;
use Example\Chinook\Albums\Collection as AlbumsCollection;
use Example\Chinook\Tracks\Collection as TracksCollection;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testGettingArtists()
    {
        $repository = new ArtistsRepository();
        $data = $repository
            ->limit(11)
            ->assemble();

        $this->assertEquals(11, $data->count());
    }

    public function testFilterByArtistName()
    {
        $repository = new ArtistsRepository();
        $data = $repository
            ->filterByName('BackBeat')
            ->assemble();

        $this->assertEquals(1, $data->count());
        $this->assertEquals('BackBeat', $data->first()->name);
    }

    public function testIncludeAlbums()
    {
        $data = (new ArtistsRepository())
            ->includeAlbums()
            ->limit(1)
            ->assemble()
        ;

        $this->assertTrue(isset($data->Albums));

        foreach($data->Albums as $album) {
            $this->assertEquals($data->artistId, $album->artistId);
        }
    }

    public function testIncludeAlbumsOnlyWithTrackName()
    {
        $data = (new ArtistsRepository())
            ->includeAlbums([
                'onlyWithTrackName' => 'Bad Boy Boogie',
            ])
            ->filterByName('AC/DC')
            ->assemble()
        ;

        $this->assertEquals(1, $data->Albums->count());
        $this->assertEquals('Let There Be Rock', $data->Albums->title);
    }

    public function testIncludeAlbumsWithTracks()
    {
        $data = (new ArtistsRepository())
            ->includeAlbums([
                'includeTracks' => []
            ])
            ->limit(1)
            ->assemble()
        ;

        $this->assertTrue(isset($data->Albums));
        $this->assertInstanceOf(AlbumsCollection::class, $data->Albums);

        foreach($data->Albums as $album) {
            $this->assertEquals($data->artistId, $album->artistId);
            $this->assertTrue(isset($album->Tracks));
            $this->assertInstanceOf(TracksCollection::class, $album->Tracks);
            foreach ($album->Tracks as $track) {
                $this->assertEquals($album->albumId, $track->albumId);
            }
        }
    }

    public function testGenerateHashForDifferentCriteria()
    {
        $repository = (new ArtistsRepository())
            ->limit(1)
        ;
        $hash1 = $repository->getHash();
        
        $repository = (new ArtistsRepository())
            ->includeAlbums()
            ->limit(1)
        ;
        $hash2 = $repository->getHash();

        $repository = (new ArtistsRepository())
            ->includeAlbums([
                'includeTracks' => [
                    'filterByName' => 'Bad Boy Boogie',
                ]
            ])
            ->limit(1)
        ;
        $hash3 = $repository->getHash();

        $this->assertEquals(40, strlen($hash1));
        $this->assertEquals(40, strlen($hash2));
        $this->assertEquals(40, strlen($hash3));
        $this->assertFalse($hash1 == $hash2);
        $this->assertFalse($hash2 == $hash3);
        $this->assertFalse($hash3 == $hash1);
    }
}
