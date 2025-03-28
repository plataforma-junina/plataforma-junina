<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->strict()
    ->ignoring(App\Http\Controllers\Controller::class);
arch()->preset()->laravel();
arch()->preset()->security();
