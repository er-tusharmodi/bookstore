<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('group')
                    ->maxLength(255),
                TextInput::make('description')
                    ->maxLength(255),
                Textarea::make('value')
                    ->helperText('Use plain text or JSON. Plain text is stored as {"text": "..."}.')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            if (array_key_exists('text', $state) && count($state) === 1) {
                                return $state['text'];
                            }

                            return json_encode($state, JSON_PRETTY_PRINT);
                        }

                        return $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if ($state === null) {
                            return null;
                        }

                        $state = trim((string) $state);

                        if ($state === '') {
                            return null;
                        }

                        $decoded = json_decode($state, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            return $decoded;
                        }

                        return ['text' => $state];
                    })
                    ->columnSpanFull(),
            ]);
    }
}
