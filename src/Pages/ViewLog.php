<?php

namespace XaviCabot\FilamentLogViewer\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use XaviCabot\FilamentLogViewer\Models\Log;

class ViewLog extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-log-viewer::pages.view-log';

    protected static ?string $slug = 'logs';

    protected ?string $maxContentWidth = 'full';

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Log::query()
            )
            ->recordAction(ViewAction::class)
            ->columns([
                TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'emergency' => 'danger',
                        'error' => 'warning',
                        default => 'info',
                    })
                    ->size(TextColumn\TextColumnSize::Small),
                TextColumn::make('context')
                    ->size(TextColumn\TextColumnSize::Small),
                TextColumn::make('date')
                    ->size(TextColumn\TextColumnSize::Small)
                    ->wrap(),
                TextColumn::make('text')
                    ->size(TextColumn\TextColumnSize::Small)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->options([
                        'emergency' => 'Emergency',
                        'alert' => 'Alert',
                        'critical' => 'Critical',
                        'error' => 'Error',
                        'warning' => 'Warning',
                        'notice' => 'Notice',
                        'info' => 'Info',
                        'debug' => 'Debug',
                    ]),
            ])
            ->actions([
                ViewAction::make('view')
                    ->label(false)
                    ->infolist([
                        TextEntry::make('stack')
                            ->label(__('Details'))
                            ->formatStateUsing(fn ($state) => new HtmlString('<p style="white-space: pre-wrap">' . $state . '</p>')),
                    ])
                    ->slideOver(),
            ]);
    }
}
