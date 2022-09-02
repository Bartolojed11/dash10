<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class AllBlacksTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $fakeResponse = [
            [
                'id' => 1,
                'name' => 'Foo-first Foo-last',
                'number' => 2,
                'position' => 'foo-position',
                'height' => 345,
                'weight' => 678,
                'age' => 90,
                'points' => 1,
                'games' => 2,
                'tries' => 3,
                'conversions' => 4,
                'penalties' => 5,
            ],
        ];

        // throw an exception if any non-matching requests are attempted
        Http::preventStrayRequests();

        Http::fake([
            'zeald.com/*' => Http::response($fakeResponse),
        ]);
    }

    public function testItSuppliesViewWithBasicPlayerDetails()
    {
        $response = $this->get('/allblacks/3');

        $response->assertStatus(200)
            ->assertViewHasAll([
                'id' => 1,
                'name' => 'Foo-first Foo-last',
                'number' => 2,
                'position' => 'foo-position',
                'height' => 345,
                'weight' => 678,
                'age' => 90,
                'points' => 1,
                'games' => 2,
                'tries' => 3,
                'conversions' => 4,
                'penalties' => 5,
            ]);
    }

    public function testItDeterminesNameParts()
    {
        $response = $this->get('/allblacks/3');

        $response->assertViewHasAll([
            'first_name' => 'Foo-first',
            'last_name' => 'Foo-last',
        ]);
    }

    public function testItDeterminesImage()
    {
        $response = $this->get('/allblacks/3');

        $response->assertViewHasAll([
            'image' => 'foo-first-foo-last.png',
        ]);
    }

    public function testTheViewRendersTeamLogo()
    {
        $response = $this->get('/allblacks/3');

        $response->assertSeeInOrder([
            '/images/teams/allblacks.png',
            'All blacks logo',
        ]);
    }

    public function testTheViewRendersPlayerNameAndNumber()
    {
        $response = $this->get('/allblacks/3');

        $response->assertSeeInOrder([
            '#2',
            'Foo-first',
            'Foo-last',
        ]);
    }

    public function testTheViewRendersPlayerProfilePhoto()
    {
        $response = $this->get('/allblacks/3');

        $response->assertSeeInOrder([
            '/images/players/allblacks/foo-first-foo-last.png',
            'alt="Foo-first Foo-last"',
        ], false);
    }

    public function testTheViewRendersFeaturedStats()
    {
        $response = $this->get('/allblacks/3');

        $response->assertSeeInOrder([
            'Points',
            '1',
            'Games',
            '2',
            'Tries',
            '3',
        ]);
    }

    public function testTheViewRenderesAdditionalPlayerData()
    {
        $response = $this->get('/allblacks/3');

        $response->assertSeeInOrder([
            'Position', 'foo-position',
            'Weight', '678KG',
            'Height', '345CM',
            'Age', '90 years',
        ]);
    }
}
