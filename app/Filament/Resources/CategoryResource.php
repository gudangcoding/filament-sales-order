<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Actions\Action;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel  = 'Kategori';
    protected static ?string $recordTitleAttribute = 'name'; //untuk global search
    protected static ?string $navigationGroup = 'Master Data';
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        $userId = $user->id;
        return Category::where('user_id', $userId)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'danger' : 'primary';
    }
    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $userId = $user->id;

        return $form
            ->schema([
                Section::make('Form Category')
                    ->schema([
                        Card::make('Category')
                            ->schema([
                                TextInput::make('name')->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (Set $set, ?string $state) =>
                                        $set('slug', str::slug($state))
                                    ),

                                TextInput::make('slug')->required()
                                    ->readOnly()
                                    ->live(),
                                Hidden::make('user_id')->default($userId),

                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $userId = $user->id;
        return $table
            // menampilkan data berdasarkan id yang login
            ->modifyQueryUsing(function (Builder $query) use ($userId) {
                // filter jika bukan super_admin
                if (!auth()->user()->hasAnyRole(['admin', 'super_admin'])) {
                    $query->where('user_id', $userId);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-circle')
                    ->action(function (Model $record) {

                        $pdfContent = Pdf::loadHTML(
                            Blade::render('print', ['record' => $record])
                        )->output();


                        //  //download pdf
                        return response()->streamDownload(function () use ($pdfContent) {
                            echo $pdfContent;
                        }, "INVOICE-" . $record->id . '.pdf', [
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="' . $record->id . '.pdf"',
                        ]);

                        //  //view browser
                        // return response($pdfContent)
                        //     ->header('Content-Type', 'application/pdf')
                        //     ->header('Content-Disposition', 'inline; filename="' . $record->number . '.pdf"');
                        // dd($record->number);
                    }),
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->color('primary')
                    ->icon('heroicon-o-printer')
                    // ->url(fn (Model $record) => route('invoices.print'))
                    ->url(fn (Model $record) => route('invoices.print', $record->id))
                    ->openUrlInNewTab()



            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->headerActions([
            //     CreateAction::make('category')
            //         ->label('Tambah Kategori')
            //         ->form([
            //             TextInput::make('title')
            //                 ->required()
            //                 ->maxLength(255),
            //             // ...
            //         ]),
            // ])
        ;
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }


    // public static function getEloquentQuery(): Builder
    // {
    //     $query = parent::getEloquentQuery();

    //     if (!auth()->user()->hasAnyRole(['admin', 'super_admin'])) {
    //         $query->where('user_id', auth()->id());
    //     }

    //     return $query;
    // }
}
