<?php

declare(strict_types=1);

namespace TBoileau\FatFreeFramework\Templating;

class DateTimeHelper extends \Prefab
{
    public static function format(string $datetime) {
        return (new \DateTime($datetime))->format('d/m/Y H:i');
    }
}
