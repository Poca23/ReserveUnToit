<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Propriétés';

    protected static ?string $breadcrumb = 'Propriétés';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la propriété')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom de la propriété')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull()
                            ->placeholder('Exemple:
Villa magnifique avec vue sur mer.

Équipements inclus:
- Piscine privée
- 4 chambres
- Terrasse ensoleillée

Parfait pour des vacances en famille!')
                            ->helperText('Utilisez des retours à la ligne pour structurer votre texte. Le HTML n\'est pas autorisé.'),


                        Forms\Components\TextInput::make('price_per_night')
                            ->label('Prix par nuit')
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(1)
                            ->step(0.01),

                        Forms\Components\TextInput::make('image')
                            ->label('URL de l\'image')
                            ->url()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('uploaded_image')
                            ->label('Ou télécharger une image')
                            ->image()
                            ->directory('properties')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->helperText('Téléchargez une image pour la propriété (max: 5MB)')
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('image', $state);
                                }
                            })
                            ->dehydrated(false),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->square()
                    ->defaultImageUrl('https://placehold.co/600x400?text=No+Image')
                    ->extraAttributes(['class' => 'object-cover h-16 w-16']),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Prix / nuit')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Réservations')
                    ->counts('bookings')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Mis à jour le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('price')
                    ->form([
                        Forms\Components\TextInput::make('min_price')
                            ->label('Prix minimum')
                            ->numeric(),
                        Forms\Components\TextInput::make('max_price')
                            ->label('Prix maximum')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_price'],
                                fn(Builder $query, $price): Builder => $query->where('price_per_night', '>=', $price),
                            )
                            ->when(
                                $data['max_price'],
                                fn(Builder $query, $price): Builder => $query->where('price_per_night', '<=', $price),
                            );
                    })
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
            RelationManagers\BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
