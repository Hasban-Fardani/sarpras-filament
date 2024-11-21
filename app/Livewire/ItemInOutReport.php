<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\IncomingItemDetail;
use App\Models\OutgoingItemDetail;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ItemInOutReport extends Component
{
    public $item_id;
    public Collection $items;
    public $report_data = [];

    public function mount()
    {
        $this->items = Item::all() ?? new Collection();
        $this->item_id = $this->items->first()->id ?? null;
        $this->loadReportData();
    }

    public function updatedItemId()
    {
        $this->loadReportData();
    }

    public function loadReportData()
    {
        $incoming_items = IncomingItemDetail::where('item_id', $this->item_id)
            ->get(['created_at', 'qty'])
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->created_at)->toDateString(),
                    'barang_masuk' => $item->qty,
                    'barang_keluar' => null,
                ];
            });

        $outgoing_items = OutgoingItemDetail::where('item_id', $this->item_id)
            ->get(['created_at', 'qty'])
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->created_at)->toDateString(),
                    'barang_masuk' => null,
                    'barang_keluar' => $item->qty,
                ];
            });

        // Gabungkan dan kelompokkan data berdasarkan tanggal
        $merged_data = $incoming_items->merge($outgoing_items)
            ->groupBy('tanggal')
            ->map(function ($items, $date) {
                return [
                    'tanggal' => $date,
                    'barang_masuk' => $items->sum('barang_masuk'),
                    'barang_keluar' => $items->sum('barang_keluar'),
                ];
            });

        $this->report_data = $merged_data->values()->toArray();
    }

    public function render()
    {
        return view('livewire.item-in-out-report');
    }
}
