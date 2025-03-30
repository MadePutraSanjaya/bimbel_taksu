<?php

namespace App\Filament\Pengajar\Resources\MataPembelajaranResource\Pages;

use App\Filament\Pengajar\Resources\MataPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMataPembelajarans extends ListRecords
{
    protected static string $resource = MataPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
