<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MovieSearchTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        DB::purge('sqlite');

        Schema::create('genres', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('films', function (Blueprint $table): void {
            $table->id();
            $table->text('title');
            $table->text('sinopsis');
            $table->integer('year');
            $table->text('poster');
            $table->timestamps();
        });

        DB::table('films')->insert([
            [
                'title' => 'The Dark Knight',
                'sinopsis' => 'A film synopsis',
                'year' => 2008,
                'poster' => 'dark-knight.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Inception',
                'sinopsis' => 'Another film synopsis',
                'year' => 2010,
                'poster' => 'inception.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        view()->share('genres', collect());
    }

    public function test_movie_search_finds_partial_title_without_case_sensitivity(): void
    {
        $this->get('/movies?search=dark')
            ->assertOk()
            ->assertSee('The Dark Knight')
            ->assertDontSee('Inception');
    }

}
