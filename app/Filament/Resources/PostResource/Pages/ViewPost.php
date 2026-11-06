<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('view')
                ->label('View Post')
                ->icon('heroicon-o-eye')
                ->url(fn (): string => route('posts.show', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => $this->record->isPublished()),
        ];
    }
}