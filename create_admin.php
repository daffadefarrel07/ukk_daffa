<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::forceCreate([
    'name' => 'Admin',
    'nis' => 'admin',
    'password' => Hash::make('admin'),
    'is_admin' => true,
]);

echo "Admin created: nis='admin', password='admin'\n";
?>

