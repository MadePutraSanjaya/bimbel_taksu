<?php

namespace App\Filament\Resources\MataPembelajaranResource\Pages;

use App\Filament\Resources\MataPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMataPembelajaran extends CreateRecord
{
    protected static string $resource = MataPembelajaranResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        $model = parent::handleRecordCreation($data);
        foreach ($data['attachments'] as $file) {
            $model->attachments()->create([
                'path' => $file,
                'name' => 'File of '.$model->name.' '.time(),
            ]);
        }

        return $model;
    }
}
