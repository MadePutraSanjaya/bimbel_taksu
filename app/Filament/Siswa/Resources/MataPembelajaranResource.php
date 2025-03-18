<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\MataPembelajaranResource\Pages;
use App\Filament\Siswa\Resources\MataPembelajaranResource\RelationManagers;
use App\Models\MataPembelajaran;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MataPembelajaranResource extends Resource
{
    protected static ?string $model = MataPembelajaran::class;

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
            ->columns([
                Tables\Columns\TextColumn::make('nama_pembelajaran'),
                Tables\Columns\TextColumn::make('kelas.nama_kelas'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('Download')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(MataPembelajaran $record) => route('download.mata-pembelajaran-template', ['id' => $record->id]))
                    ->openUrlInNewTab(),


            ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user) {
            $siswa = Siswa::where('user_id', $user->id)->first();

            if ($siswa) {
                $query->where('kelas_id', $siswa->kelas_id);
            }
        }

        return $query;
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
            // 'create' => Pages\CreateMataPembelajaran::route('/create'),
            // 'edit' => Pages\EditMataPembelajaran::route('/{record}/edit'),
        ];
    }
}
