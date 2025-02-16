<?php

namespace App\Filament\Resources\MataPembelajaranResource\Pages;

use App\Filament\Resources\MataPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMataPembelajaran extends EditRecord
{
    protected static string $resource = MataPembelajaranResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        foreach ($data['attachments'] as $file) {
            $record->attachments()->firstOrCreate(
                [
                    'path' => $file,
                ], [
                    'name' => 'File of '.$record->name.' '.time(),
                ]);

        }
        $record->attachments()->whereNotIn('path', $data['attachments'])->delete();

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
