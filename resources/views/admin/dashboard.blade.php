<x-app-layout>
    <!-- {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}} -->

    <div class="py-12" x-data="stateProduct">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- start alert message -->
                     <template x-if="listProduct.length === 0 && showCard =='table' ">  
                        <div class="p-4 mb-2 text-sm text-white rounded-lg bg-blue-400" role="alert">
                            <!-- menggunakan operator tenari -->
                            <span class="font-medium" x-text="listProduct.length === 0 ? 'Data belum tersedia': '' "></span>  
                        </div>
                     </template>
                     <!-- end alert message -->
                      <template x-if="messages.success != ''">
                        <div class="p-4 mb-4 text-sm text-white rounded-lg bg-green-400" role="alert">
                            {{-- menggunakan operator tenari --}}
                            <span class="font-medium" x-text="messages.success"></span>
                        </div>
                    </template>

                    {{-- Start Button --}}
                    <button x-show="showCard == 'table'" x-on:click="btnCreateProduct" type="button" class="inline-flex items-center  text-white bg-blue-400 hover:bg-blue-500 mb-2 rounded-lg box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
                        Product
                    </button>
                    {{-- End Button --}}

                    {{-- Start create component --}}
                    <div x-show="showCard =='create'">
                        @include('admin._card_create_product')
                    </div>
                    {{-- end create component --}}

                    {{-- Start restock component --}}
                    <div x-show="showCard =='restock'">
                        @include('admin._card_restock_product')
                    </div>
                    {{-- end restock component --}}

                    {{-- start table --}}
                    <div x-show="showCard == 'table'" class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-lg border border-default">
                            @include('admin._card_table_product')
                    </div>

                    {{-- end table --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('stateProduct', () => ({
                showCard: 'table',

                // membuat array kosong untuk tempat list product
                listProduct: [],

                // membuat objek product
                product: { name:'', price: '', size: '', quantity: '', description: '' },

                // menampung data original dari BE
                originalproduct: { name:'', price: '', size: '', stock:{} , description: '' },

                // menampung edit original dri be
                editproduct: { name:'', price: '', size: '', stock:{} , description: '' },

                // membuat objek error
                error: { name:'', price: '', size: '', quantity: '', description: '' },

                listSize: {kecil:'kecil', sedang:'sedang', besar:'sedang'},

                // membuat object messages untuk menampung pesan
                messages:{ info:'', success:''},
        

                // menggunakan fungsi bawaan alpine untuk inisasi komponen
                init() { 
                    this.getlistProduct()
                },

                btnCreateProduct() {
                    this.messages.info = ''
                    this.showCard = 'create'
                },
                // tombol cancel
                btnCancel() {
                    // mengambil seluruh data field product kedalam objek
                    let someData = Object.values(this.product).some(value=> value !== '')

                    if(someData){
                        let confirmation = confirm('yakin batal?')
                        if(confirmation) {
                            this.resetField()
                            this.resetErrors()
                            this.showCard = 'table'
                        }
                    }

                    // jika tidak ada sama sekali data akan tutup form create
                    if(!someData){
                        this.resetErrors()
                        this.showCard = 'table'

                    }

                },
                // fungsi reset seluruh field
                resetField(){
                    Object.assign(this.product, {
                        name:'',
                        price: '',
                        size: '',
                        quantity: '',
                        description: ''})
                },
                // fungsi reset seluruh error
                resetErrors(){
                    Object.assign(this.error, {
                        name:'',
                        price: '',
                        size: '',
                        quantity: '',
                        description: ''})
                },

                // tombol kirim data ke BE
                async sendDataProduct() {
                    try {
                        this.resetErrors()
                    //    mengumpulkan seluruh data objek product
                        let newDataProduct = {
                            name: this.product.name,
                            price: this.product.price,
                            size: this.product.size,
                            quantity: this.product.quantity,
                            description: this.product.description,
                        }   

                        // mengirim data product baru ke BE dengan jalur store-product
                       let result = await axios.post('store-product', newDataProduct)

                    // panggil kembali fungsi resetfield untuk resetfield
                        this.resetField()

                    // panggil kembali fungsi getListProduct untuk relasi data
                        this.getlistProduct()

                    // kembalikan ixShowCard menjadi table
                        this.showCard = 'table'

                    // memasukkan isi message dari Back End
                        this.messages.success = result.data.message
                        
                        // melakukan reset message success menggunakan setTimeout
                        setTimeout(() => { this.messages.success = ''}, 5000);

                    } catch (error) {
                        if (error.response && error.response.status == 422) {
                            // mengambil response data message
                            let responseBE = error.response.data.message

                            // menghapus error sebelumnya
                            for(let field in this.error) {
                                this.error[field] = ''
                            }
                            // this.resetErrors()

                            // melakukan pembongkaran array errors
                            for(let field in responseBE) {
                                this.error[field] = responseBE[field][0]
                                console.log('error 422', this.error[field])
                            }

                            // console.log ('error 422', error.response.data.message)
                        } else {
                            console.log ('error selain 422', error.response)
                        }
                        // console.log(error.response.status)
                    }
                },

                // fungsi untuk memanggil listproduct
                async getlistProduct(){ 
                    try {
                        let result = await axios.get('list-product')
                        this.listProduct = result.data.response

                        // mengecek kondisi data array listProduct

                    } catch (error) {
                        console.log(error)
                    }
                 },

                 async btnDelete(productId) {
                    try {
                        let confirmation = confirm('yakin dihapus?')
                        if(!confirmation) return

                        // mengirimkan data product id ke url product/productId
                        console.log('anda pilih oke, berarti mau dihapus')
                    } catch (error) {
                        console.log('error', error)
                    }  
                },

                async btnDelete(productId){
                    try {
                        let confirmation = confirm ('yakin menghapus?')
                        if(!confirmation) return
                        // mengirimkan productid melalui url
                        let result = await axios.delete('product-by/' +productId)

                        console.log(result)
                        // mengambil pesan dari BE dan memasukan ke this.messages
                        this.messages.success = result.data.message
                        // setting waktu mereset message
                        setTimeout(() => {this.messages.success = ''}, 3000)
                        // reload data table
                        this.getlistProduct()
                    } catch (error) {
                        console.log(error)
                    }
                },

                async btnEdit(productId){
                    try {
                       
                        // mengirimkan productid melalui url
                        let result = await axios.get('product-by/' +productId+'/edit')

                        // masukan data response kedalam variable baru
                        let dataProduct = result.data.response

                        let clone = structuredClone(dataProduct)

                        // casting tipe data stock
                        clone.stock.quantity = Number(clone.stock.quantity)
                        
                        // casting data ke editProduct
                        this.editProduct = clone


                        // cloning data ke originalProduct
                        this.originalproduct = JSON.parse(JSON.stringify(clone))
                        console.log('data', this.originalproduct)

                        // menampilkan ke card_edit
                        this.showCard = 'restock'

                        // // mengambil pesan dari BE dan memasukan ke this.messages
                        // this.messages.success = result.data.message
                        // // setting waktu mereset message
                        // setTimeout(() => {this.messages.success = ''}, 3000)
                        // // reload data table
                        // this.getlistProduct()
                    } catch (error) {
                        console.log(error)
                    }
                },
            }))
                
        })  
    </script>
</x-app-layout>