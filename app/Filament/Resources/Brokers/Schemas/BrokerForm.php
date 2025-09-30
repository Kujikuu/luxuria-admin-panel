<?php

namespace App\Filament\Resources\Brokers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BrokerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->description('Enter the broker\'s basic personal details')
                    ->icon(Heroicon::OutlinedUser)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->placeholder('Enter broker\'s full name')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->columnSpan(1),
                                TextInput::make('role')
                                    ->label('Professional Role')
                                    ->placeholder('e.g., Senior Real Estate Agent')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        Hidden::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('residence')
                            ->label('Location/Residence')
                            ->placeholder('e.g., New York, NY')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Profile Image')
                    ->description('Upload a professional profile photo')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        FileUpload::make('image')
                            ->label('Profile Photo')
                            ->image()
                            ->disk('public')
                            ->directory('brokers')
                            ->visibility('public')
                            ->required()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048) // 2MB
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                            ])
                            ->helperText('Upload a professional headshot. Recommended size: 400x400px or higher.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Professional Background')
                    ->description('Provide detailed information about the broker\'s background and expertise')
                    ->icon(Heroicon::OutlinedBriefcase)
                    ->schema([
                        RichEditor::make('about')
                            ->label('About the Broker')
                            ->placeholder('Write a compelling bio about the broker...')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->columnSpanFull(),
                        RichEditor::make('experience')
                            ->label('Professional Experience')
                            ->placeholder('Detail the broker\'s experience, achievements, and specializations...')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Contact Information')
                    ->description('Enter the broker\'s contact details and social media')
                    ->icon(Heroicon::OutlinedPhone)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->placeholder('(555) 123-4567')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->placeholder('broker@example.com')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('x')
                                    ->label('X (Twitter) Handle')
                                    ->placeholder('@username')
                                    ->prefix('@')
                                    ->columnSpan(1),
                                TextInput::make('linkedin')
                                    ->label('LinkedIn Profile')
                                    ->placeholder('linkedin.com/in/username')
                                    ->url()
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
