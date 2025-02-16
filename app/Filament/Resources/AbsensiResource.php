<?php

namespace App\Filament\Resources;

use App\Enums\StatusHadir;
use App\Filament\Resources\AbsensiResource\Pages;
use App\Filament\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.nama_lengkap')
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        StatusHadir::HADIR->value => 'success',
                        StatusHadir::IZIN->value => 'warning',
                        StatusHadir::ALPHA->value => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Nama Kelas'),
            ])
            ->filters([
                SelectFilter::make('kelas')
                    ->label('Filter Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([

                    Action::make('Hadir')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($record) {
                            $record->update(['status' => StatusHadir::HADIR->value]);
                        }),

                    Action::make('Izin')
                        ->icon('heroicon-o-check')
                        ->color('warning')
                        ->action(function ($record) {
                            $record->update(['status' => StatusHadir::IZIN->value]);
                        }),

                    Action::make('Alpha')
                        ->icon('heroicon-o-check')
                        ->color('danger')
                        ->action(function ($record) {
                            $record->update(['status' => StatusHadir::ALPHA->value]);
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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
