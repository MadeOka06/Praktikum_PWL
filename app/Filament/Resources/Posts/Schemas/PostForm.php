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
use Filament\Tables\Columns\IconColumn;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')->required()
                ->minLength(5),
                TextInput::make('slug')
                ->required()
                ->unique(),
                Select::make('category_id')
                ->label('Category')
                ->options(\App\Models\Category::all()
                ->pluck('name', 'id')),
                ColorPicker::make("color"),
                MarkdownEditor::make("Content"),
                FileUpload::make("image")
                ->disk("public")
                ->directory("post"),
                TagsInput::make("tags"),
                Checkbox::make("published"),
                DateTimePicker::make("published_at"),
            ]);
    }
}
