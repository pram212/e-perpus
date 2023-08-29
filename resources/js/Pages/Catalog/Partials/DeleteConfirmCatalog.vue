<script setup>
import { Link, router } from "@inertiajs/vue3";
const props = defineProps({
    catalog_id : null,
})

function deleteCatalog() {
    router.delete('/catalog/' + props.catalog_id, {
        preserveState: false
    })
}

</script>

<template>
   
    <input type="checkbox" id="delete-confirm" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg"><i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i> Warning</h3>
            <p class="py-4">Apakah anda yakin ingin menghapusnya?</p>
            <div class="divider my-0"></div>
            <div class="modal-action">
                <button type="button" class="btn btn-sm btn-error" @click="deleteCatalog">Ya, hapus!</button>
                <label for="delete-confirm" class="btn btn-sm btn-secondary">Batal!</label>
            </div>
        </div>
    </div>
    
</template>