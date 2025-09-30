<?php

namespace App\Filament\Resources\Brokers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class BrokersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(url('/images/placeholder-avatar.jpg')),
                TextColumn::make('name')
                    ->label('Broker Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary'),
                TextColumn::make('role')
                    ->label('Professional Role')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('residence')
                    ->label('Location')
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::OutlinedMapPin)
                    ->iconColor('gray')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->icon(Heroicon::OutlinedPhone)
                    ->iconColor('green')
                    ->copyable()
                    ->copyMessage('Phone number copied!')
                    ->copyMessageDuration(1500),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->iconColor('blue')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->copyMessageDuration(1500)
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('social_media')
                    ->label('Social Media')
                    ->formatStateUsing(function ($record): string {
                        $links = [];
                        if ($record->x) {
                            $links[] = 'X';
                        }
                        if ($record->linkedin) {
                            $links[] = 'LinkedIn';
                        }
                        return !empty($links) ? implode(', ', $links) : 'None';
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === 'None' ? 'gray' : 'success')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Joined Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('has_social_media')
                    ->label('Social Media Presence')
                    ->options([
                        'with_x' => 'Has X (Twitter)',
                        'with_linkedin' => 'Has LinkedIn',
                        'with_both' => 'Has Both',
                        'without' => 'No Social Media',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'with_x' => $query->whereNotNull('x')->where('x', '!=', ''),
                            'with_linkedin' => $query->whereNotNull('linkedin')->where('linkedin', '!=', ''),
                            'with_both' => $query->whereNotNull('x')->where('x', '!=', '')
                                                 ->whereNotNull('linkedin')->where('linkedin', '!=', ''),
                            'without' => $query->where(function ($q) {
                                $q->whereNull('x')->orWhere('x', '')
                                  ->whereNull('linkedin')->orWhere('linkedin', '');
                            }),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteBulkAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
