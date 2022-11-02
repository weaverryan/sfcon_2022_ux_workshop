<?php

namespace App\Factory;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use function Symfony\Component\String\u;

/**
 * @extends ModelFactory<Track>
 *
 * @method static Track|Proxy createOne(array $attributes = [])
 * @method static Track[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Track[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Track|Proxy find(object|array|mixed $criteria)
 * @method static Track|Proxy findOrCreate(array $attributes)
 * @method static Track|Proxy first(string $sortedField = 'id')
 * @method static Track|Proxy last(string $sortedField = 'id')
 * @method static Track|Proxy random(array $attributes = [])
 * @method static Track|Proxy randomOrCreate(array $attributes = [])
 * @method static Track[]|Proxy[] all()
 * @method static Track[]|Proxy[] findBy(array $attributes)
 * @method static Track[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Track[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TrackRepository|RepositoryProxy repository()
 * @method Track|Proxy create(array|callable $attributes = [])
 */
final class TrackFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'songTitle' => u(self::faker()->text(50))->title(),
            'artistName' => self::faker()->name(),
            'length' => self::faker()->numberBetween(180, 420),
            'trackNumber' => self::faker()->numberBetween(0, 20),
            'mix' => VinylMixFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Track $track): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Track::class;
    }
}
