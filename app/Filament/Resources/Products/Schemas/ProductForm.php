<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('sale_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('sku')
                    ->label('SKU')
                    ->default(null),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_bestseller')
                    ->required(),
                Toggle::make('deal_of_week')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->formatStateUsing(function ($state) {
                        $array = [];
                        if (is_string($state)) {
                            $array = json_decode($state, true) ?: [];
                        } elseif (is_array($state)) {
                            $array = $state;
                        } else {
                            return $state;
                        }

                        return array_map(function ($path) {
                            if (str_starts_with($path, 'storage/')) {
                                return substr($path, 8);
                            }
                            return $path;
                        }, $array);
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if (is_array($state)) {
                            $state = array_map(function ($path) {
                                if (!str_starts_with($path, 'storage/')) {
                                    return 'storage/' . $path;
                                }
                                return $path;
                            }, $state);
                        }
                        return json_encode($state);
                    })
                    ->columnSpanFull(),
            ]);
    }
}

