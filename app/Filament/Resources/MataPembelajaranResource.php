<?php

namespace App\Filament\Resources;

use App\Enums\StatusMengajar;
use App\Filament\Resources\MataPembelajaranResource\Pages;
use App\Filament\Resources\MataPembelajaranResource\RelationManagers;
use App\Models\MataPembelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MataPembelajaranResource extends Resource
{
    protected static ?string $model = MataPembelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pembelajaran')
                    ->required(),
                Forms\Components\Select::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->required(),
                Forms\Components\FileUpload::make('attachments')
                    ->directory('attachments')
                    ->formatStateUsing(fn($record) => $record?->attachments ? $record->attachments->map(fn($attachment) => $attachment->path)->toArray() : [])
                    ->label('Attachment')
                    ->multiple()
                    ->downloadable()
                    ->previewable()
                    ->uploadingMessage('Uploading attachment...')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pembelajaran'),
                Tables\Columns\TextColumn::make('kelas.nama_kelas'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        StatusMengajar::SUDAH_MENGAJAR->value => 'success',
                        StatusMengajar::BELUM_MENGAJAR->value => 'warning',
                        default => 'warning',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([

                    Action::make('approve')
                        ->label('Sudah Mengajar')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === StatusMengajar::BELUM_MENGAJAR->value)
                        ->action(function ($record) {
                            $record->update(['status' => StatusMengajar::SUDAH_MENGAJAR->value]);
                            
                        }),

                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPembelajarans::route('/'),
            'create' => Pages\CreateMataPembelajaran::route('/create'),
            'edit' => Pages\EditMataPembelajaran::route('/{record}/edit'),
        ];
    }
}
