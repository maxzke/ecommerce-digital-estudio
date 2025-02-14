<template>
    <Head title="Producto" />
    <AuthenticatedLayout>
        <div class="row mx-0">
            <div class="col-12">
                <h1>Crear Producto y Servicios</h1>
                <form @submit.prevent="store">
                    <!-- Nombre y descripción del producto -->
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto</label>
                        <Input type="text" name="nombre" id="nombre" required />
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import { defineComponent } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
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
    },
    props: {},
    data() {
        return {};
    },
    methods: {},
    computed: {},
});
</script>
<style></style>
