<script>
import { defineComponent } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Label } from "@/Components/ui/label";
import { Head } from "@inertiajs/vue3";
import AddCustomer from "@/Pages/Clientes/Add.vue";

export default defineComponent({
    components: {
        AuthenticatedLayout,
        Head,
        Input,
        Button,
        Label,
        Card,
        CardContent,
        CardDescription,
        CardFooter,
        CardHeader,
        CardTitle,
        ConfirmationModal,
        AddCustomer,
    },
    props: {
        payment_methods: Object,
    },
    data() {
        return {
            cart: [],
            condiciones: [],
            condicion: null,
            openModal: false,
            itemProduct: {
                id: null,
                product_name: "",
                quantity: "",
                price: "",
                discount: 0,
                total: "",
            },
            //en la BD el metodo de pago efectivo debe ser el registro id=1
            payment_methods_selected: 1,
            paid: 0,
            sale_total: 0,
            sale_subtotal: 0,
            sale_iva: 0,
            customer: null,
            facturar: false,
            //modal
            removerProductoModal: false,
            productoARemover: null,
            modalGuardarVenta: false,
        };
    },
    methods: {
        addCondition() {
            const obj = {};
            obj["condicion"] = this.condicion;
            this.condiciones.push(obj);
            this.condicion = null;
        },
        validaImportePago() {
            if (this.paid > this.sale_total) {
                alertify.set("notifier", "position", "bottom-center");
                alertify.error("Abono no puede ser mayor al total");
                this.paid = 0;
            }
        },
        getCustomer(id) {
            this.customer = id;
        },
        saveSale(tipo) {
            let _this = this;
            alertify.confirm(
                "Confirmación",
                "Guardar " + tipo,
                function () {
                    _this.storeSale(tipo);
                },
                function () {
                    //alertify.error('Cancel')
                }
            );
        },
        storeSale(tipo) {
            let _this = this;
            this.$inertia.post(
                route("ventas.store"),
                {
                    customer: _this.customer,
                    payment_method: _this.payment_methods_selected,
                    sale_details: _this.cart,
                    facturar: _this.facturar,
                    paid: _this.paid,
                    type: tipo,
                    terminos: this.condiciones,
                },
                {
                    onError: (errors) => [
                        alertify.error(errors.error),
                        console.log(errors.error),
                    ],
                    onSuccess: () => [
                        this.resetOnSuccessSale(),
                        alertify.success(tipo + " guardada !"),
                    ],
                }
            );
        },
        randomId() {
            return "_" + Math.random().toString(36).substr(2, 9);
        },
        addItemToCart() {
            const obj = {};
            obj["id"] = this.itemProduct.id;
            obj["product_name"] = this.itemProduct.product_name.toLowerCase();
            obj["quantity"] = this.itemProduct.quantity;
            obj["price"] = this.itemProduct.price;
            obj["discount"] = this.itemProduct.discount;
            obj["total"] = this.itemProduct.total;
            this.cart.push(obj);
        },
        addItemProductToCart() {
            if (this.itemProduct.id === null) {
                this.itemProduct.id = this.randomId();
            }
            this.addItemToCart();
            this.resetItemProduct();
        },
        editItemProduct(product) {
            this.itemProduct.id = product.id;
            this.itemProduct.product_name = product.product_name;
            this.itemProduct.quantity = product.quantity;
            this.itemProduct.price = product.price;
            this.itemProduct.discount = product.discount;
            this.itemProduct.total = product.total;
            this.delItemCart(product.id);
        },
        deleteItemProductFromCart(product) {
            this.removerProductoModal = true;
            this.productoARemover = product;
        },
        delItemCart(product_id) {
            let selected_product_index = this.cart.findIndex(
                (item) => item.id === product_id
            );
            this.cart.splice(selected_product_index, 1);
            this.productoARemover = null;
            this.removerProductoModal = false;
        },
        resetItemProduct() {
            this.itemProduct.id = null;
            this.itemProduct.product_name = "";
            this.itemProduct.quantity = "";
            this.itemProduct.price = "";
            this.itemProduct.discount = 0;
            this.itemProduct.total = "";
        },
        resetOnSuccessSale() {
            this.resetItemProduct();
            this.cart = [];
            this.payment_methods_selected = 1;
            this.paid = 0;
            this.sale_total = 0;
            this.sale_subtotal = 0;
            this.sale_iva = 0;
            this.customer = null;
            this.facturar = false;
        },
        formateadoMoneda(importe) {
            return this.formatNumber(importe, 1, ".", ",");
        },
        formatNumber(n, c, d, t) {
            var c = isNaN((c = Math.abs(c))) ? 2 : c,
                d = d === undefined ? "." : d,
                t = t === undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt((n = Math.abs(Number(n) || 0).toFixed(c)))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return (
                s +
                (j ? i.substr(0, j) + t : "") +
                i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
                (c
                    ? d +
                      Math.abs(n - i)
                          .toFixed(c)
                          .slice(2)
                    : "")
            );
        },
    },
    computed: {
        totalItem: function () {
            if (
                this.itemProduct.quantity != null &&
                this.itemProduct.price != null &&
                this.itemProduct.discount != null
            ) {
                const divisor = 100;
                let descuento = this.itemProduct.discount;
                let x = descuento / divisor;
                let y =
                    x * (this.itemProduct.quantity * this.itemProduct.price);
                this.itemProduct.total =
                    this.itemProduct.quantity * this.itemProduct.price - y;
                //return this.formateadoMoneda((this.itemProduct.quantity*this.itemProduct.price)-(y));
                return this.itemProduct.total;
            }
        },
        isEnnableBtnAddToCart() {
            return (
                this.itemProduct.quantity === "" ||
                this.itemProduct.price === "" ||
                this.itemProduct.product_name === ""
            );
        },
        isEnnableBtnAddSaveSale() {
            return this.sale_total <= 0;
        },
        totalCart() {
            let total = 0;
            if (this.cart != null) {
                this.cart.forEach((item) => {
                    total += parseFloat(item.total);
                });
            }
            this.sale_total = total;
            this.sale_subtotal = this.sale_total / 1.16;
            this.sale_iva = this.sale_total - this.sale_subtotal;
            return total;
        },
        calculaTotalVenta() {
            return parseFloat(this.sale_total);
        },
    },
});
</script>

<template>
    <Head title="Punto de venta" />

    <AuthenticatedLayout>
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-2">
            <div class="bg-transparent overflow-hidden">
                <div class="row px-1 pt-1">
                    <div class="col-9">
                        <Card class="p-2">
                            <div class="row">
                                <div class="col-12">
                                    <Label for="producto">Producto</Label>
                                    <Input
                                        id="producto"
                                        type="text"
                                        v-model="this.itemProduct.product_name"
                                        autocomplete="off"
                                        placeholder="Descripción"
                                        required
                                    />
                                </div>
                                <div class="col-2 offset-1">
                                    <Label for="cantidad">Cantidad</Label>
                                    <Input
                                        id="cantidad"
                                        type="number"
                                        v-model="this.itemProduct.quantity"
                                        min="1"
                                        autocomplete="off"
                                        required
                                    />
                                </div>
                                <div class="col-2">
                                    <Label for="precio">Precio</Label>
                                    <Input
                                        id="precio"
                                        type="number"
                                        v-model="this.itemProduct.price"
                                        min="0"
                                        step="0.1"
                                        autocomplete="off"
                                        required
                                    />
                                </div>
                                <div class="col-2">
                                    <Label for="descuento">Desc %</Label>
                                    <Input
                                        id="descuento"
                                        type="number"
                                        v-model="this.itemProduct.discount"
                                        min="0"
                                        step="1"
                                        autocomplete="off"
                                        required
                                    />
                                </div>
                                <div class="col-2">
                                    <Label for="total">Total</Label>
                                    <Input
                                        id="total"
                                        type="text"
                                        :value="
                                            this.formateadoMoneda(
                                                this.totalItem
                                            )
                                        "
                                        value="200"
                                        readonly
                                    />
                                </div>
                                <div class="col-2">
                                    <Button
                                        variant="outline"
                                        class="w-full h-7 mt-4"
                                        @click="this.addItemProductToCart()"
                                        :disabled="this.isEnnableBtnAddToCart"
                                    >
                                        <i
                                            class="fa-solid fa-cart-shopping pr-2"
                                        ></i>
                                        Agregar
                                    </Button>
                                </div>
                            </div>
                            <!-- tabla-carrito -->
                            <div
                                class="overflow-hidden carrito shadow mt-2 border"
                            >
                                <div>
                                    <table class="table">
                                        <thead
                                            class="text-gray-700 dark:text-gray-200"
                                        >
                                            <tr>
                                                <th
                                                    class="w-5/6 px-2 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900 text-start py-1"
                                                >
                                                    Producto
                                                </th>
                                                <th
                                                    class="w-1/8 px-2 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900"
                                                >
                                                    Cant
                                                </th>
                                                <th
                                                    class="w-1/8 px-2 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900"
                                                >
                                                    Precio
                                                </th>
                                                <th
                                                    class="w-1/8 px-2 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900"
                                                >
                                                    Desc%
                                                </th>
                                                <th
                                                    class="w-1/8 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900"
                                                >
                                                    Total
                                                </th>
                                                <th
                                                    class="w-1/8 px-2 text-sm sticky top-0 bg-slate-200 dark:bg-slate-900"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800"
                                                v-for="product in this.cart"
                                                :key="product.id"
                                            >
                                                <td
                                                    class="px-2 py-2"
                                                    v-text="
                                                        product.product_name
                                                    "
                                                ></td>
                                                <td
                                                    class="text-center"
                                                    v-text="product.quantity"
                                                ></td>
                                                <td
                                                    class="text-center"
                                                    v-text="
                                                        this.formateadoMoneda(
                                                            product.price
                                                        )
                                                    "
                                                ></td>
                                                <td
                                                    class="text-right pr-2"
                                                    v-text="
                                                        product.discount + '%'
                                                    "
                                                ></td>
                                                <td
                                                    class="text-right pr-2 px-2"
                                                    v-text="
                                                        this.formateadoMoneda(
                                                            product.total
                                                        )
                                                    "
                                                ></td>
                                                <td>
                                                    <div
                                                        class="flex justify-center"
                                                    >
                                                        <div
                                                            @click="
                                                                this.editItemProduct(
                                                                    product
                                                                )
                                                            "
                                                        >
                                                            <!-- edit product -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-3 text-amber-500 cursor-pointer"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                                                                />
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </div>
                                                        <div
                                                            @click="
                                                                this.deleteItemProductFromCart(
                                                                    product
                                                                )
                                                            "
                                                        >
                                                            <!-- cancel propduct -->
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-red-500 cursor-pointer"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- tabla-carrito -->
                            <div class="row pt-1">
                                <!-- subtotal -->
                                <div class="col-1 text-end offset-9">
                                    <label
                                        class="text-gray-500 dark:text-gray-600 text-sm font-bold"
                                    >
                                        Subtotal
                                    </label>
                                </div>
                                <div class="col-1 text-end">
                                    <label
                                        class="text-gray-700 dark:text-gray-400 text-lg font-bold"
                                    >
                                        {{
                                            this.formateadoMoneda(
                                                this.sale_subtotal
                                            )
                                        }}
                                    </label>
                                </div>
                                <!-- iva -->
                                <div class="col-1 text-end offset-9">
                                    <label
                                        class="text-gray-500 dark:text-gray-600 text-sm font-bold"
                                    >
                                        Iva
                                    </label>
                                </div>
                                <div class="col-1 text-end">
                                    <label
                                        class="text-gray-700 dark:text-gray-400 text-lg font-bold"
                                    >
                                        {{
                                            this.formateadoMoneda(this.sale_iva)
                                        }}
                                    </label>
                                </div>

                                <div class="col-1 text-end offset-9">
                                    <label
                                        class="text-gray-500 dark:text-gray-600 text-sm font-bold"
                                    >
                                        Total
                                    </label>
                                </div>
                                <div class="col-1 text-end">
                                    <label
                                        class="text-gray-700 dark:text-gray-100 text-lg font-bold"
                                    >
                                        {{
                                            this.formateadoMoneda(
                                                this.totalCart
                                            )
                                        }}
                                    </label>
                                </div>
                            </div>
                        </Card>
                    </div>
                    <div class="col-3">
                        <Card class="p-2">
                            <AddCustomer @customer="getCustomer" />
                        </Card>
                        <select
                            id="countries"
                            class="mt-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm block w-full p-1.5 dark:bg-card dark:border-gray-800 dark:placeholder-gray-400 dark:text-white"
                        >
                            <option selected disabled>Método de pago</option>
                            <option value="1">Efectivo</option>
                            <option value="2">Transferencia - COPPEL</option>
                            <option value="3">Tarjeta - BANAMEX</option>
                        </select>
                        <div class="row mt-2">
                            <div class="col-5">
                                <Label for="importe_pagado"
                                    >Importe pagado</Label
                                >
                            </div>
                            <div class="col-7">
                                <Input
                                    type="number"
                                    name="importe_pagado"
                                    id="importe_pagado"
                                    min="0"
                                    v-model="this.paid"
                                    @keyup="this.validaImportePago()"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <Button
                                    class="mt-3 w-full"
                                    @click="this.modalGuardarVenta = true"
                                    :disabled="this.isEnnableBtnAddSaveSale"
                                >
                                    Guardar venta
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmationModal
            :show="removerProductoModal"
            @close="removerProductoModal = false"
        >
            <template #title> ¿Desea remover el artículo? </template>

            <template #content>
                <span v-text="this.productoARemover.product_name"></span>
            </template>

            <template #footer>
                <Button
                    variant="outline"
                    @click="this.removerProductoModal = false"
                >
                    Cancelar
                </Button>

                <Button
                    variant="destructive"
                    class="ml-2"
                    @click="this.delItemCart(this.productoARemover.id)"
                >
                    Sí, Remover
                </Button>
            </template>
        </ConfirmationModal>
        <!-- confirmar guardar venta -->
        <ConfirmationModal
            :show="modalGuardarVenta"
            @close="modalGuardarVenta = false"
        >
            <template #title> ¿Desea Guardar la Nota de Venta? </template>

            <template #content> contenido </template>

            <template #footer>
                <Button
                    variant="outline"
                    @click="this.modalGuardarVenta = false"
                >
                    Cancelar
                </Button>

                <Button class="ml-2" @click="this.saveSale('venta')">
                    Sí, Guardar
                </Button>
            </template>
        </ConfirmationModal>
    </AuthenticatedLayout>
</template>
<style>
.carrito {
    height: 45vh;
    overflow-y: scroll;
}
</style>
