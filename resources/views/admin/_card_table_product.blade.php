<table class="w-full text-sm text-left rtl:text-right text-body">
<thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
    <tr>
        <th scope="col" class="px-6 py-3 font-medium">
            #
        </th>
        <th scope="col" class="px-6 py-3 font-medium">
            Nama
        </th>
        <th scope="col" class="px-6 py-3 font-medium">
            Stok
        </th>
        <th scope="col" class="px-6 py-3 font-medium">
            Harga
        </th>
        <th scope="col" class="px-6 py-3 font-medium">
            Ukuran
        </th>
        <th scope="col" class="px-6 py-3 font-medium">
            <span class="sr-only">Edit</span>
        </th>
    </tr>
</thead>
<tbody>
    <template x-if="listProduct.length > 0">
        <template x-for="(product,index) in listProduct" :key="product.id">
            <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                <td class="px-6 py-4" x-text="index + 1"></td>
                <th scope="row" x-text="product.name" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                </th>
                <td class ="px-6 py-4">
                    <button type="button" x-on:click="btnEdit(product.id)" x-text="product.stock?.quantity ? product.stock.quantity : 'tidak ada stok' " class="px-6 py-4"> </button>
                </td>
                <td x-text="product.price" class="px-6 py-4">
                </td>
                <td x-text="product.size" class="px-6 py-4">
                </td>
                <td class="px-6 py-4 text-right">
                    <button x-on:click="btnDelete(product.id)" class="font-medium text-red-400 hover:underline" type="button">Delete</button>
                    {{-- <a href="#" x-on:click="btnDelete(product.id)" class="font-medium text-red-400 hover:underline">delete</a> --}}
                </td>
            </tr>
        </template>
    </template>
</tbody>
</table>