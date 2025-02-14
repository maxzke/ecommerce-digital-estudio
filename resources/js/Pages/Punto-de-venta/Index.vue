<template>
    <Head title="Tienda" />
    <AuthenticatedLayout>
        <div class="row mx-0">
            <div class="col-2">
                <Input
                    type="text"
                    class="mt-3"
                    id="buscar_producto"
                    placeholder="Buscar"
                />
            </div>
            <div class="col-9 border-start">hola2</div>
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
