<?php

namespace App\Filament\Resources\Products\Schemas;

use Dom\Text;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Tabs::make('Product Tabs')
                ->tabs([
                    Tab::make('Product Details')
                    ->icon('heroicon-o-circle-stack')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->color('primary'),
                        TextEntry::make('id')
                            ->label('product ID'),
                        TextEntry::make('sku')
                            ->label('Product SKU')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('created_at')
                            ->label('Product Creation Date')
                            ->date('d M Y')
                            ->color('info'),
                    ]), 
                    Tab::make('Product Price and Stock')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        TextEntry::make('price')
                        ->label('Product Price')
                        ->weight('bold')
                        ->color('primary')
                        ->icon('heroicon-s-currency-dollar'),
                        TextEntry::make('stock')
                        ->label('Product Stock')
                        ->badge()
                        ->color(fn ($state): string => match (true){
                            $state <= 0 => 'danger',
                            $state <= 10 => 'warning',
                            default => 'success',
                        })
                        ]),
                    Tab::make('Media and Status')
                    ->icon('heroicon-o-photo')
                    ->schema([
                    ImageEntry::make('image')
                        ->label('Product Image')
                        ->disk('public'),
                    TextEntry::make('price')
                        ->label('Product Price')
                        ->weight('bold')
                        ->color('primary')
                        ->icon('heroicon-s-currency-dollar'),
                    TextEntry::make('stock')
                        ->label('Product Stock')
                        ->weight('bold')
                        ->icon('heroicon-o-briefcase')
                        ->color('primary'),
                    IconEntry::make('is_active')
                        ->label('Is Active?')
                        ->boolean(),
                    IconEntry::make('is_featured')
                        ->label('Is Featured?')
                        ->boolean(),
                ]),
            ]) ->columnSpanFull(),
             
            ]);
    }
}
