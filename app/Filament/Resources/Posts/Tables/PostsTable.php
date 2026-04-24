<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;


class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')
                ->label('ID')
                ->toggleable(isToggledHiddenByDefault:true)
                ->sortable(),
                TextColumn::make('title')
                ->sortable()
                ->toggleable()
                ->searchable(),
                TextColumn::make('slug')
                ->sortable()
                ->toggleable()
                ->searchable(),
                TextColumn::make('category.name')
                ->toggleable()
                ->sortable()
                ->searchable(),
                ColorColumn::make('color')
                ->toggleable(),
                ImageColumn::make('image')
                ->toggleable()
                ->disk('public'),
                IconColumn::make('published')
                ->toggleable()
                ->boolean(),
                TextColumn::make('created_at')
                ->toggleable()
                ->label('Created At')
                ->dateTime()
                ->sortable(),
                TextColumn::make('tags')
                ->label('Tags')
                ->toggleable(isToggledHiddenByDefault:true),
            ]) ->defaultSort('created_at','desc')
            ->filters([
                Filter::make('created_at')
                ->label('Creation Date')
                ->schema([
                    DatePicker::make('created_at')
                    ->label('Select Date : ')
                ])
                ->query(function ($query,$data){
                    return $query
                    ->when(
                        $data['created_at'],
                        fn($query,$date) => $query->whereDate('created_at',$date),
                    );
                }),
                SelectFilter::make('catefory_id')
                ->relationship('category','name')
                ->label('Category')
                ->preload(),
                Filter::make('title')
                ->label('Title')
                ->schema([
                    TextInput::make('title')
                    ->label('Select Title')
                ])
                ->query(function($query,$data){
                    return $query
                    ->when(
                        $data['title'],
                        fn($query,$title) => $query->wheretitle('title',$title),
                    );
                }),
                Filter::make('slug')
                ->label('slug')
                ->schema([
                    TextInput::make('slug')
                    ->label('Select Slug')
                ])
                ->query(function($query,$data){
                    return $query
                    ->when(
                        $data['slug'],
                        fn($query,$slug) => $query->wheretitle('slug',$slug),
                    );
                })
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
