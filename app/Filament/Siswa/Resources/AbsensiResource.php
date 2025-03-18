<?php

namespace App\Filament\Siswa\Resources;

use App\Enums\StatusHadir;
use App\Filament\Siswa\Resources\AbsensiResource\Pages;
use App\Filament\Siswa\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('user_id', Auth::id()))

            ->columns([
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Nama Kelas'),
                Tables\Columns\TextColumn::make('pertemuan.pertemuan_ke')
                    ->label('Pertemuan Ke'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        StatusHadir::HADIR->value => 'success',
                        StatusHadir::IZIN->value => 'warning',
                        StatusHadir::ALPHA->value => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                //
            ]);
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            // 'create' => Pages\CreateAbsensi::route('/create'),
            // 'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
