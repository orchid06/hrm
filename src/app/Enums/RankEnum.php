<?php

namespace App\Enums;

enum RankEnum {

    case up;
    case down;

    /**
     * get enum status
     */
    public function status(): string
    {
        return match($this)
        {
            RankEnum::up => '1',
            RankEnum::down => '0',
        };
    }


    public static function toArray() :array{
        return [
            'Up' => (RankEnum::up)->status(),
            'Down' => (RankEnum::down)->status()
        ];
    }

}
