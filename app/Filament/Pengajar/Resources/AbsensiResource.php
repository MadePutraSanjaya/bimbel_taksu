<?php

namespace App\Filament\Pengajar\Resources;

use App\Enums\Role;
use App\Enums\StatusHadir;
use App\Filament\Pengajar\Resources\AbsensiResource\Pages;
use App\Filament\Pengajar\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kelas_id')
                    ->label('Pilih Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $userIds = Siswa::where('kelas_id', $state)
                                ->pluck('user_id')
                                ->toArray();
                                
                            $siswaList = User::where('role', Role::SISWA->value)
                                ->whereIn('id', $userIds)
                                ->get();
                    
                            $siswadata = $siswaList->map(function ($siswa) {
                                return [
                                    'user_id' => $siswa->id,
                                    'nama_lengkap' => $siswa->nama_lengkap,
                                    'status' => StatusHadir::ALPHA->value
                                ];
                            })->toArray();
                    
                            $set('siswa_list', $siswadata);
                        }
                    }),

                Forms\Components\Select::make('pertemuan_id')
                    ->label('Pilih Pertemuan')
                    ->relationship('pertemuan', 'pertemuan_ke')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Repeater::make('siswa_list')
                    ->label('Daftar Siswa')
                    ->schema([
                        Forms\Components\Hidden::make('user_id'),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Siswa')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status Kehadiran')
                            ->options([
                                StatusHadir::HADIR->value => 'Hadir',
                                StatusHadir::IZIN->value => 'Izin',
                                StatusHadir::ALPHA->value => 'Alpha',
                            ])
                            ->default(StatusHadir::ALPHA->value)
                            ->required(),
                    ])
                    ->columns(2)
                    ->disabled(fn($get) => !$get('kelas_id'))
                    ->defaultItems(0)
                    ->addable(false)
                    ->deletable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Absensi::query()->whereHas('pertemuan')
            )
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
                Tables\Columns\TextColumn::make('pertemuan.pertemuan_ke')
                    ->label('Pertemuan Ke'),
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

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($data['siswa_list'] as $siswa) {
            Absensi::updateOrCreate(
                [
                    'user_id' => $siswa['user_id'],
                    'kelas_id' => $data['kelas_id'],
                    'pertemuan_id' => $data['pertemuan_id'],
                ],
                [
                    'status' => $siswa['status'],
                ]
            );
        }

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data, Model $record): array
    {
        foreach ($data['siswa_list'] as $siswa) {
            $record->where('user_id', $siswa['user_id'])
                ->where('pertemuan_id', $data['pertemuan_id'])
                ->update([
                    'status' => $siswa['status'],
                ]);
        }

        return $data;
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
