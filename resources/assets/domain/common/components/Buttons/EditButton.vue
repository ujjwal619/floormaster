<template>
    <a :href="url">
        <button
                class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                :title="title"
                data-toggle="tooltip">
            <i class="fa fa-pencil"></i>
        </button>
    </a>
</template>

<script type="text/ecmascript-6">
    export default {
        name: 'edit-button',
        props: {
            "url": {
                default: "",
                type: String,
                required: true
            },
            "title": {
                default: "Edit item",
                type: String,
            },
        }
    }
</script>
