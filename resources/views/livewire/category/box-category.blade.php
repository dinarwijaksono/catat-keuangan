<section class="box">
    <div class="box-header mb-4">
        <h3 class="title">List Kategori</h3>
    </div>

    <div class="box-body">

        <table class="table-simple w-full" aria-describedby="my-table">
            <tr class="bg-green-300 text-slate-600">
                <th style="width: 10">No</th>
                <th>Nama</th>
                <th>Type</th>
                <th>Dibuat</th>
                <th>Diedit</th>
                <th></th>
            </tr>

            <tbody>
                @foreach ($categories as $key)
                    <tr>
                        <td class="p-1 text-center w-1/12">{{ $loop->iteration }}</td>
                        <td class="p-1 w-3/12">{{ $key->name }}</td>
                        <td class="p-1 text-center w-2/12">
                            <span @class([
                                'bg-danger' => $key->type == 'spending',
                                'bg-success' => $key->type == 'income',
                                'px-2',
                                'text-[12px]',
                                'rounded',
                                'text-white',
                            ])>
                                {{ $key->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td class="p-1 w-2/12 text-center">{{ date('H:i - j F Y', $key->created_at / 1000) }}</td>
                        <td class="p-1 w-2/12 text-center">{{ date('H:i - j F Y', $key->updated_at / 1000) }}</td>
                        <td class="p-1 w-2/12">
                            <x-zara.link-button-success
                                href="/edit-category/{{ $key->code }}">Edit</x-zara.link-button-success>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</section>
