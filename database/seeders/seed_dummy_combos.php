<?php

// Bootstrap Laravel
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

echo "Seeding Dummy Combo Packs...\n";

// Get or create category
$category = Category::where('slug', 'dhoop-packs')->first();
if (!$category) {
    $category = Category::create([
        'name' => 'Dhoop Packs',
        'slug' => 'dhoop-packs',
        'description' => 'Curated premium combos and sampler packs for your wellness rituals.'
    ]);
}

// Check or create constituent products
$sandal = Product::where('slug', 'premium-sandalwood-dhoop')->first();
if (!$sandal) {
    $sandal = Product::create([
        'category_id' => $category->id,
        'name' => 'Premium Sandalwood Dhoop',
        'slug' => 'premium-sandalwood-dhoop',
        'price' => 250.00,
        'quantity' => 50,
        'weight' => 0.15, 'length' => 12, 'width' => 6, 'height' => 6,
        'description' => 'Pure sandalwood powder blended with organic cow dung.',
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);
}

$guggal = Product::where('slug', 'organic-guggal-cones')->first();
if (!$guggal) {
    $guggal = Product::create([
        'category_id' => $category->id,
        'name' => 'Organic Guggal Cones',
        'slug' => 'organic-guggal-cones',
        'price' => 180.00,
        'quantity' => 40,
        'weight' => 0.12, 'length' => 10, 'width' => 5, 'height' => 5,
        'description' => 'Aromatic guggal resin cones for purification.',
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);
}

$loban = Product::where('slug', 'classic-loban-sticks')->first();
if (!$loban) {
    $loban = Product::create([
        'category_id' => $category->id,
        'name' => 'Classic Loban Sticks',
        'slug' => 'classic-loban-sticks',
        'price' => 150.00,
        'quantity' => 30,
        'weight' => 0.10, 'length' => 10, 'width' => 5, 'height' => 5,
        'description' => 'Tranquilizing natural loban powder sticks.',
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);
}

$jasmine = Product::where('slug', 'mystic-jasmine-cones')->first();
if (!$jasmine) {
    $jasmine = Product::create([
        'category_id' => $category->id,
        'name' => 'Mystic Jasmine Cones',
        'slug' => 'mystic-jasmine-cones',
        'price' => 220.00,
        'quantity' => 25,
        'weight' => 0.11, 'length' => 10, 'width' => 5, 'height' => 5,
        'description' => 'Soothing jasmine blossom extracts.',
        'images' => json_encode(['images/premium_dhoop_product.png']),
        'is_active' => true,
    ]);
}

echo "Base ingredients verified/created.\n";

// Create Combo 1: Meditation Dhyana Combo (₹399 instead of ₹680)
$meditationCombo = Product::where('slug', 'meditation-dhyana-combo')->first();
if ($meditationCombo) {
    $meditationCombo->comboItems()->delete();
    $meditationCombo->delete();
}

$meditationCombo = Product::create([
    'category_id' => $category->id,
    'name' => 'Meditation Dhyana Combo',
    'slug' => 'meditation-dhyana-combo',
    'price' => 399.00,
    'is_combo' => true,
    'quantity' => 0,
    'weight' => 0.42, 'length' => 15, 'width' => 10, 'height' => 8,
    'description' => 'A curated combination of Sandalwood and Guggal to enhance concentration and deepen meditation.',
    'images' => json_encode(['images/premium_dhoop_product.png']),
    'is_active' => true,
]);
// 2x Sandalwood, 1x Guggal
$meditationCombo->comboItems()->create(['product_id' => $sandal->id, 'quantity' => 2]);
$meditationCombo->comboItems()->create(['product_id' => $guggal->id, 'quantity' => 1]);

echo "Created Combo: 'Meditation Dhyana Combo' (Sandalwood x 2 + Guggal x 1) for ₹399.00\n";


// Create Combo 2: Sacred Purifying Bundle (₹499 instead of ₹880)
$purifyingCombo = Product::where('slug', 'sacred-purifying-bundle')->first();
if ($purifyingCombo) {
    $purifyingCombo->comboItems()->delete();
    $purifyingCombo->delete();
}

$purifyingCombo = Product::create([
    'category_id' => $category->id,
    'name' => 'Sacred Purifying Bundle',
    'slug' => 'sacred-purifying-bundle',
    'price' => 499.00,
    'is_combo' => true,
    'quantity' => 0,
    'weight' => 0.55, 'length' => 18, 'width' => 12, 'height' => 8,
    'description' => 'Cleanse your home aura and remove negative energies with this classic blend of purifying ingredients.',
    'images' => json_encode(['images/premium_dhoop_product.png']),
    'is_active' => true,
]);
// 2x Loban, 2x Guggal, 1x Sandalwood
$purifyingCombo->comboItems()->create(['product_id' => $loban->id, 'quantity' => 2]);
$purifyingCombo->comboItems()->create(['product_id' => $guggal->id, 'quantity' => 2]);
$purifyingCombo->comboItems()->create(['product_id' => $sandal->id, 'quantity' => 1]);

echo "Created Combo: 'Sacred Purifying Bundle' (Loban x 2 + Guggal x 2 + Sandalwood x 1) for ₹499.00\n";


// Create Combo 3: Aromatherapy Blossom Pack (₹449 instead of ₹740)
$blossomCombo = Product::where('slug', 'aromatherapy-blossom-pack')->first();
if ($blossomCombo) {
    $blossomCombo->comboItems()->delete();
    $blossomCombo->delete();
}

$blossomCombo = Product::create([
    'category_id' => $category->id,
    'name' => 'Aromatherapy Blossom Pack',
    'slug' => 'aromatherapy-blossom-pack',
    'price' => 449.00,
    'is_combo' => true,
    'quantity' => 0,
    'weight' => 0.38, 'length' => 15, 'width' => 10, 'height' => 6,
    'description' => 'Sweet florals and warm sandalwood notes to create a calming, relaxed atmosphere in your living space.',
    'images' => json_encode(['images/premium_dhoop_product.png']),
    'is_active' => true,
]);
// 2x Jasmine, 1x Sandalwood
$blossomCombo->comboItems()->create(['product_id' => $jasmine->id, 'quantity' => 2]);
$blossomCombo->comboItems()->create(['product_id' => $sandal->id, 'quantity' => 1]);

echo "Created Combo: 'Aromatherapy Blossom Pack' (Jasmine x 2 + Sandalwood x 1) for ₹449.00\n";

echo "Seeding completed successfully!\n";
