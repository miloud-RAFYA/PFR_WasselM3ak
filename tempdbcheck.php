<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\\Contracts\\Console\\Kernel');
$kernel->bootstrap();

$count = App\Models\Suive::count();
echo 'Suive count: ' . $count . PHP_EOL;

$demande = App\Models\Demande::where('status', 'in_progress')->with('suivres')->first();
if ($demande) {
    echo 'First in_progress demande id=' . $demande->id . ' suivres=' . $demande->suivres->count() . PHP_EOL;
}
