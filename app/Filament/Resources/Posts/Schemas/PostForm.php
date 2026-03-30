<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use League\CommonMark\Extension\DescriptionList\Node\Description;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {

    return $schema
        ->components([
            // --- KOLOM KIRI (2/3) ---
            Group::make([
                Section::make("Post Details")
                    ->description("Fill in the details of the post") // Perbaikan: d kecil
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        // Grouping field utama menjadi 2 kolom
                        Group::make([
                            TextInput::make('title')
                                ->rules(["required","min:5","max:10"])
                                // ->rules('required'),
                                // ->required()
                                ->validationMessages([
                                    'required' => 'Title tidak boleh kosong.',
                                    'min' => 'Title minimal harus 5 karakter.',
                                    'max' => 'Ttile maksimal hanya 10 karakter.',
                                ])
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->rules('required|min:3')
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Slug harus unik dan tidak boleh sama.'
                                ]),
                            Select::make('category_id')
                                ->relationship("category", "name")
                                ->required()
                                ->preload()
                                ->searchable()
                                ->label('Category'),
                            ColorPicker::make("color"),
                        ])->columns(2), // Ini yang membuat field utama jadi 2 kolom

                        MarkdownEditor::make("content")
                            ->columnSpanFull(),
                    ]),
            ])->columnSpan(2),

            // --- KOLOM KANAN (1/3) ---
            Group::make([
                // Section 2 - image
                Section::make("Image Upload")
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make("image")
                            ->required()
                            ->disk("public")
                            ->directory("post")
                            ->image(),
                    ]),

                // Section 3 - meta
                Section::make("Meta Information")
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TagsInput::make("tags"),
                        Checkbox::make("published"),
                        DateTimePicker::make("published_at"),
                    ]),
            ])->columnSpan(1),
        ])
        ->columns(3); // Total grid utama dibagi 3
}
}
