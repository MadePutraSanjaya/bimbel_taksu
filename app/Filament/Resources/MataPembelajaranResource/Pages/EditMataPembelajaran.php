<?php

namespace App\Filament\Resources\MataPembelajaranResource\Pages;

use App\Filament\Resources\MataPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMataPembelajaran extends EditRecord
{
    protected static string $resource = MataPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
