<script>
import { defineComponent } from "vue";
import { Input } from "@/Components/ui/input";
import { vueDebounce } from "vue-debounce";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";

import { Label } from "@/Components/ui/label";
export default defineComponent({
    components: {
        Input,
        Card,
        Button,
        Label,
    },
    directives: {
        debounce: vueDebounce({ lock: true }),
    },
    emits: ["customer"],
    props: {},
    data() {
        return {
            modalOpen: false,
            modalOpenBuscar: false,
            modalOpenUpdate: false,
            form: this.$inertia.form({
                _method: "post",
                id: null,
                nombre: null,
                email: null,
                ciudad: null,
                telefono: null,
                direccion: null,
                rfc: null,
                razon_social: null,
            }),
            params: {
                search: null,
            },
            listCustomers: Object,
            customerSelected: null,
        };
    },
    mounted() {},
    methods: {
        editUser() {
            this.modalOpenUpdate = true;
        },
        setCustomer(customer) {
            this.setEditForm(customer);
            this.customerSelected = customer;
            this.$emit("customer", customer.id);
        },
        setEditForm(customer) {
            this.form.id = customer.id;
            this.form.nombre = customer.nombre;
            this.form.direccion = customer.direccion;
            this.form.ciudad = customer.ciudad;
            this.form.email = customer.email;
            this.form.empresa = customer.empresa;
            this.form.telefono = customer.telefono;
            this.form.razon_social = customer.razon_social;
            this.form.rfc = customer.rfc;
        },
        unSelectCustomer() {
            this.customerSelected = null;
            this.listCustomers = null;
            this.params.search = null;
            this.$emit("customer", null);
        },
        getCustomers(val) {
            this.params.search = val;
            this.$inertia.get(this.route("customer.index"), this.params, {
                replace: true,
                preserveState: true,
                onSuccess: (response) => [
                    (this.listCustomers = response.props.customers),
                ],
            });
        },
        openModal() {
            this.form.reset;
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
            // this.resetForm();
        },
        store() {
            this.form.post(this.route("customer.store"), {
                onSuccess: () => [
                    this.closeModal(),
                    alertify.success("Registrado!"),
                ],
            });
        },
        update() {
            this.form._method = "put";
            this.form.post(this.route("customer.update", this.form.id), {
                preserveState: true,
                onSuccess: () => [
                    //this.closeModal(),
                    alertify.success("Actualizado"),
                ],
            });
        },
        resetForm() {
            this.form.nombre = null;
            this.form.email = null;
            this.form.ciudad = null;
            this.form.telefono = null;
            this.form.direccion = null;
            this.form.rfc = null;
            this.form.razon_social = null;
        },
        searCustomer() {},
    },
    watch: {
        params: {
            handler() {
                //busqueda
            },
        },
    },
});
</script>
<template>
    <div class="row">
        <div class="col-12">
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Cliente
                </p>
                <Input
                    :value="this.customerSelected?.nombre"
                    readonly
                    class="border-none capitalize"
                ></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Dirección
                </p>
                <Input
                    readonly
                    class="border-none capitalize"
                    :value="this.customerSelected?.direccion"
                ></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Ciudad
                </p>
                <Input
                    readonly
                    class="border-none capitalize"
                    :value="this.customerSelected?.ciudad"
                ></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Telefono
                </p>
                <Input
                    readonly
                    class="border-none"
                    :value="this.customerSelected?.telefono"
                ></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Correo
                </p>
                <Input
                    readonly
                    class="border-none"
                    :value="this.customerSelected?.email"
                ></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    RFC
                </p>
                <Input value="" readonly class="border-none"></Input>
            </div>
            <div>
                <p class="text-sm font-medium leading-none text-gray-500">
                    Razón Social
                </p>
                <Input value="" readonly class="border-none"></Input>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-3 text-center">
            <!-- buscar cliente -->
            <Button variant="outline" @click="this.modalOpenBuscar = true">
                <i class="fa-solid fa-magnifying-glass"></i>
            </Button>
        </div>
        <div class="col-3 text-center">
            <!-- agregar cliente -->
            <Button variant="outline" @click="openModal()">
                <i class="fa-solid fa-user-plus"></i>
            </Button>
        </div>
        <div class="col-3 text-center">
            <!-- agregar cliente -->
            <Button
                variant="outline"
                @click="editUser()"
                :disabled="this.customerSelected == null"
            >
                <i class="fa-solid fa-pen"></i>
            </Button>
        </div>
        <div class="col-3 text-center">
            <!-- agregar cliente -->
            <Button
                variant="outline"
                @click="unSelectCustomer()"
                :disabled="this.customerSelected == null"
            >
                <i class="fa-regular fa-xmark fa-xl"></i>
            </Button>
        </div>
    </div>
    <!-- Modal buscar cliente -->
    <div
        class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"
        v-if="modalOpenBuscar"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-600 opacity-25"></div>
            </div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
            ></span
            >​
            <div
                class="inline-block align-bottom -lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
            >
                <Card class="p-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <Label for="buscarcliente"
                                ><i class="fa-solid fa-magnifying-glass"></i>
                                Buscar Cliente</Label
                            >
                            <Input
                                id="buscarcliente"
                                type="text"
                                v-debounce:600ms="getCustomers"
                                placeholder="Nombre del cliente ..."
                            />
                        </div>
                    </div>
                    <div class="grid mt-2">
                        <div
                            class="col-span-11 dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700"
                            v-for="customer in listCustomers"
                            :key="customer.id"
                        >
                            <div
                                class="pl-1 cursor-pointer capitalize text-sm py-1"
                                @click="setCustomer(customer)"
                            >
                                {{ customer.nombre }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-end">
                            <Button
                                variant="outline"
                                @click="modalOpenBuscar = false"
                            >
                                Cerrar
                            </Button>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal agregar cliente -->
    <div
        class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"
        v-if="modalOpen"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
            ></span
            >​
            <div
                class="inline-block align-bottom -lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
            >
                <Card>
                    <form @submit.prevent="store">
                        <h2
                            class="text-lg uppercase text-center pt-2 text-stone-500"
                        >
                            registrar nuevo cliente
                        </h2>
                        <div class="w-full px-3 pt-2">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="nombre"
                            >
                                <span class="text-red-500">*</span> Nombre
                                completo
                            </label>
                            <Input
                                type="text"
                                id="nombre"
                                autocomplete="off"
                                v-model="this.form.nombre"
                                required
                            />
                            <span
                                class="text-red-500 text-xs"
                                v-if="this.form.errors.nombre"
                                >{{ this.form.errors.nombre }}</span
                            >
                        </div>

                        <div class="flex flex-wrap -mx-3 mt-3 px-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="email"
                                >
                                    Correo
                                </label>
                                <Input
                                    id="email"
                                    type="email"
                                    autocomplete="off"
                                    v-model="this.form.email"
                                />
                                <!-- <p class="text-red-500 text-xs italic">Please fill out this field.</p> -->
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="telefono"
                                >
                                    Telefono
                                </label>
                                <Input
                                    id="telefono"
                                    type="text"
                                    autocomplete="off"
                                    v-model="this.form.telefono"
                                />
                            </div>
                        </div>

                        <div class="w-full px-3 mt-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="ciudad"
                            >
                                Ciudad
                            </label>
                            <Input
                                type="text"
                                id="ciudad"
                                v-model="this.form.ciudad"
                            />
                        </div>

                        <div class="w-full px-3 mt-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="direccion"
                            >
                                Dirección
                            </label>
                            <Input
                                type="text"
                                id="direccion"
                                autocomplete="off"
                                v-model="this.form.direccion"
                            />
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6 mt-3 px-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="rfc"
                                >
                                    RFC
                                </label>
                                <Input
                                    id="rfc"
                                    type="text"
                                    autocomplete="off"
                                    v-model="this.form.rfc"
                                />
                                <!-- <p class="text-red-500 text-xs italic">{{ Input.errors.nombre }}</p> 
                                <span class="form-text text-danger">{{ Input.errors.level }}</span>-->
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="razon_social"
                                >
                                    Razón Social
                                </label>
                                <Input
                                    id="razon_social"
                                    type="text"
                                    autocomplete="off"
                                    v-model="this.form.razon_social"
                                />
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-12 text-center">
                                <Button variant="outline" @click="closeModal()">
                                    Cancelar
                                </Button>
                                <Button type="submit"> Guardar </Button>
                            </div>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Modal Update Customer -->
    <div
        class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"
        v-if="modalOpenUpdate"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-700 opacity-75"></div>
            </div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
            ></span
            >​
            <div
                class="inline-block align-bottom bg-card -lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-headline"
            >
                <form @submit.prevent="update">
                    <h2
                        class="text-lg uppercase text-center pt-2 text-stone-500"
                    >
                        DATOS DEL CLIENTE
                    </h2>
                    <div class="w-full px-3 pt-5">
                        <label
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="nombre"
                        >
                            <span class="text-red-500">*</span> Nombre completo
                        </label>
                        <Input
                            type="text"
                            id="nombre"
                            autocomplete="off"
                            v-model="this.form.nombre"
                            required
                        />
                        <span
                            class="text-red-500 text-xs"
                            v-if="this.form.errors.nombre"
                            >{{ this.form.errors.nombre }}</span
                        >
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-3 px-3">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="email"
                            >
                                Correo
                            </label>
                            <Input
                                id="email"
                                type="email"
                                autocomplete="off"
                                v-model="this.form.email"
                            />
                            <!-- <p class="text-red-500 text-xs italic">Please fill out this field.</p> -->
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="telefono"
                            >
                                Telefono
                            </label>
                            <Input
                                id="telefono"
                                type="text"
                                autocomplete="off"
                                v-model="this.form.telefono"
                            />
                        </div>
                    </div>

                    <div class="w-full px-3 mt-3">
                        <label
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="ciudad"
                        >
                            Ciudad
                        </label>
                        <Input
                            type="text"
                            id="ciudad"
                            v-model="this.form.ciudad"
                        />
                    </div>

                    <div class="w-full px-3 mt-3">
                        <label
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="direccion"
                        >
                            Dirección
                        </label>
                        <Input
                            type="text"
                            id="direccion"
                            autocomplete="off"
                            v-model="this.form.direccion"
                        />
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6 mt-3 px-3">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="rfc"
                            >
                                RFC
                            </label>
                            <Input
                                id="rfc"
                                type="text"
                                autocomplete="off"
                                v-model="this.form.rfc"
                            />
                            <!-- <p class="text-red-500 text-xs italic">{{ Input.errors.nombre }}</p> 
                                <span class="form-text text-danger">{{ Input.errors.level }}</span>-->
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="razon_social"
                            >
                                Razón Social
                            </label>
                            <Input
                                id="razon_social"
                                type="text"
                                autocomplete="off"
                                v-model="this.form.razon_social"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <Button
                                variant="outline"
                                @click="modalOpenUpdate = false"
                            >
                                Cerrar
                            </Button>
                            <Button
                                type="submit"
                                :disabled="this.form.processing"
                            >
                                Actualizar
                            </Button>
                        </div>
                    </div>

                    <div
                        class="bg-card px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                    >
                        <span
                            class="flex w-full -md shadow-sm sm:ml-3 sm:w-auto"
                        >
                        </span>
                        <span
                            class="mt-3 flex w-full -md shadow-sm sm:mt-0 sm:w-auto"
                        >
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</template>
<style></style>
