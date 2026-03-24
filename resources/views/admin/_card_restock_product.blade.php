<!-- Modal body -->
             <form x-on:submit.prevent="sendDataProduct">
            <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                <div class="col-span-2 sm:col-span-1">
                    <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Nama</label>
                    <input type="text" x-model="editProduct.name" readonly name="name" id="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Tulis Nama Barang" >
                    <template x-if="error.name">
                        <p class="mt-2.5 text-sm text-red-400 text-bold"><span class="font-medium" x-text="error.name">r</span></p>
                    </template>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="quantity" class="block mb-2.5 text-sm font-medium text-heading">Jumlah</label>
                    <template x-if="editProduct.stock">
                        <select id="quantity" x-model="editProduct.quantity"class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body" >
                        <option value="">Pilih Jumlah</option>
                            <template x-for="index in 10" :key="index">
                        <option :value="index" x-text="index"></option>
                            </templat>
                        </select>
                    </template>
                    <template x-if="error.quantity">
                        <p class="mt-2.5 text-sm text-red-400 text-bold"><span class="font-medium" x-text="error.quantity">r</span></p>
                    </template>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="size" class="block mb-2.5 text-sm font-medium text-heading">Ukuran</label>
                    <select id="size" readonly x-model="product.size" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body" >
                    <option :value="editProduct.size" x-text="editProduct.size"></option>
                    <!-- <template x-for="size in listSize" :key="size">
                        <option :value="size" x-text="size"></option>
                    </templat> -->
                        <!-- <option value="sm">Kecil</option>
                        <option value="md">Sedang</option>
                        <option value="xl">Besar</option> -->

                    </select>
                    <template x-if="error.size">
                        <p class="mt-2.5 text-sm text-red-400 text-bold"><span class="font-medium" x-text="error.size">r</span></p>
                    </template>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="price" class="block mb-2.5 text-sm font-medium text-heading">Harga</label>
                    <input type="number" readonly x-model="editProduct.price" name="price" id="price" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Isi Harga Barang" >
                    <template x-if="error.price">
                        <p class="mt-2.5 text-sm text-red-400 text-bold"><span class="font-medium" x-text="error.price">r</span></p>
                    </template>
                </div>
                <div class="col-span-2">
                    <label for="description" class="block mb-2.5 text-sm font-medium text-heading">Keterangan</label>
                    <textarea id="description" readonly x-model="editProduct.description" rows="4" class="block bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body" placeholder="Tulis Deskripsi Barang"></textarea>
                    <template x-if="error.description">
                        <p class="mt-2.5 text-sm text-red-400 text-bold"><span class="font-medium" x-text="error.description">r</span></p>
                    </template>
                </div>
            </div>
            <div class="flex items-center space-x-4 pt-2 md:pt-4">
                <button type="submit" class="inline-flex items-center  text-blue bg-blue-400 hover:bg-blue-500 rounded-lg box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                    Kirim
                </button>
                <button x-on:click="btnCancel" type="button" class="text-body bg-grey-400 box-border rounded-lg border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Batal</button>
            </div>
        </form>