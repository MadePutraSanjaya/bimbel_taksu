<?php

namespace App\Filament\Pengajar\Resources\PenilaianResource\Pages;

use App\Filament\Pengajar\Resources\PenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenilaians extends ListRecords
{
    protected static string $resource = PenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
