<div>
    <div class="mb-4">
        <label for="item_id">Pilih Barang:</label>
        <select wire:model.lazy="item_id" id="item_id" class="rounded border-gray-300">
            @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="filament-tables-container">
        <table class="filament-tables-table w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Barang Masuk</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($report_data as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $data['tanggal'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $data['barang_masuk'] ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $data['barang_keluar'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-sm text-gray-500 text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
