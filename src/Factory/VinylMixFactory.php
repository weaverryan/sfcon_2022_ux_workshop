<?php

namespace App\Factory;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use function Symfony\Component\String\u;

/**
 * @extends ModelFactory<VinylMix>
 *
 * @method static VinylMix|Proxy createOne(array $attributes = [])
 * @method static VinylMix[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static VinylMix|Proxy find(object|array|mixed $criteria)
 * @method static VinylMix|Proxy findOrCreate(array $attributes)
 * @method static VinylMix|Proxy first(string $sortedField = 'id')
 * @method static VinylMix|Proxy last(string $sortedField = 'id')
 * @method static VinylMix|Proxy random(array $attributes = [])
 * @method static VinylMix|Proxy randomOrCreate(array $attributes = [])
 * @method static VinylMix[]|Proxy[] all()
 * @method static VinylMix[]|Proxy[] findBy(array $attributes)
 * @method static VinylMix[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static VinylMix[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static VinylMixRepository|RepositoryProxy repository()
 * @method VinylMix|Proxy create(array|callable $attributes = [])
 */
final class VinylMixFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'title' => u(self::faker()->words(5, true))->title(),
            'description' => self::faker()->paragraph(),
            'genre' => self::faker()->randomElement(['pop', 'rock']),
            'votes' => self::faker()->numberBetween(-50, 50),
            'tracks' => TrackFactory::new()->many(5, 10),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(VinylMix $vinylMix): void {})
        ;
    }

    protected static function getClass(): string
    {
        return VinylMix::class;
    }
}
