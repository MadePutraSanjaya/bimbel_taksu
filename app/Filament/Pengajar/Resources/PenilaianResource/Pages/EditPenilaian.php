<?php

namespace App\Filament\Pengajar\Resources\PenilaianResource\Pages;

use App\Filament\Pengajar\Resources\PenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaian extends EditRecord
{
    protected static string $resource = PenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
