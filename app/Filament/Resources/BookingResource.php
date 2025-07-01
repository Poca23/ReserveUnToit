<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Réservations';

    protected static ?string $breadcrumb = 'Réservations';


    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Client')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('property_id')
                            ->label('Propriété')
                            ->relationship('property', 'name')
                            ->required()
                            ->searchable()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    // On pourrait ajouter un hook pour afficher le prix
                                }
                            }),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Date d\'arrivée')
                            ->required()
                            ->minDate(now())
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('Date de départ')
                            ->required()
                            ->minDate(function (callable $get) {
                                $startDate = $get('start_date');
                                return $startDate ? $startDate : now();
                            })
                            ->afterOrEqual('start_date')
                            ->displayFormat('d/m/Y'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('property.name')
                    ->label('Propriété')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Arrivée')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Départ')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durée')
                    ->getStateUsing(function (Booking $record): string {
                        $nights = \Carbon\Carbon::parse($record->start_date)->diffInDays($record->end_date);
                        return $nights . ' nuit' . ($nights > 1 ? 's' : '');
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Prix total')
                    ->getStateUsing(function (Booking $record): string {
                        $nights = \Carbon\Carbon::parse($record->start_date)->diffInDays($record->end_date);
                        $total = $nights * $record->property->price_per_night;
                        return number_format($total, 2) . ' €';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('upcoming')
                    ->label('Réservations à venir')
                    ->query(fn(Builder $query): Builder => $query->where('start_date', '>=', now()))
                    ->toggle(),

                Tables\Filters\Filter::make('past')
                    ->label('Réservations passées')
                    ->query(fn(Builder $query): Builder => $query->where('end_date', '<', now()))
                    ->toggle(),

                Tables\Filters\SelectFilter::make('property_id')
                    ->label('Propriété')
                    ->relationship('property', 'name')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
