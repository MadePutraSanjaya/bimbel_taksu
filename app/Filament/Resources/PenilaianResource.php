<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Models\Penilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nilai')
                    ->label('Nilai')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),
                Forms\Components\Select::make('mata_pembelajaran_id')
                    ->label('Mata Pembelajaran')
                    ->relationship('mataPembelajaran', 'nama_pembelajaran')
                    ->required(),
                Forms\Components\Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(
                        \App\Models\Siswa::with('user')->get()->pluck('user.nama_lengkap', 'id')
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mataPembelajaran.nama_pembelajaran')
                    ->label('Mata Pembelajaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa.user.nama_lengkap')
                    ->label('Siswa')
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa.kelas.nama_kelas')
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
            ])
            ->filters([
               
            ])
            
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // Tambahkan relation manager jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenilaians::route('/'),
            'create' => Pages\CreatePenilaian::route('/create'),
            'edit' => Pages\EditPenilaian::route('/{record}/edit'),
        ];
    }
}
