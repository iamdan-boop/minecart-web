<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateTimeFilter;

class TransactionTable extends DataTableComponent
{
    protected $model = Item::class;

    public string $previousDate = '';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Buyer name", "buyer_name")
                ->sortable()
                ->searchable(),
            Column::make("Price", "price")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
            Column::make("Note", "note")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Drop date", "drop_date")
                ->sortable(),
            Column::make("Claimed date", "claimed_date")
                ->sortable(),
            Column::make("Display price", "display_price")
                ->sortable(),
            Column::make("Shelf location", "shelf_location")
                ->sortable(),
            Column::make("Handling fee", "handling_fee")
                ->sortable(),
            Column::make("Expiry date", "expiry_date")
                ->sortable(),
            Column::make("Display", "display")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }


    public function filters(): array
    {
        return [
            DateTimeFilter::make('Drop Date')
                ->filter(function (Builder $query, string $value) {
                    $query->whereDate('drop_date', Carbon::parse($value));
                    $this->previousDate = $value;
                }),
            DateFilter::make('Drop Date End')
                ->filter(function (Builder $query, string $value) {
                    $query->whereDate('drop_date', '<=', Carbon::parse($value));
                    if ($this->previousDate != '') {
                        $query->whereDate('drop_date', '>=', Carbon::parse($this->previousDate));
                    }
                })
        ];
    }
}
