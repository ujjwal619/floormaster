<template>
    <a :class="atagclassname" href="javascript:" @click="deleteAfterConfirmation">
        <button v-if="showbutton"
                class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                :title="title"
                data-toggle="tooltip">
            <i :class="itagclassname"></i>
        </button>
        <i v-else :class="itagclassname"></i>
        <span :class="spanclassname">{{ spantext }}</span>
    </a>
</template>

<style lang="scss" scoped>
</style>

<script type="text/babel">
    import swal from 'sweetalert2'

    export default {
        name: 'delete-button',
        props: {
            "method": {
                type: String,
                default: 'delete'
            },
            "showbutton": {
                default: true,
                type: Boolean,
                required: false
            },
            "redirecturl": {
                default: "",
                type: String,
                required: false
            },
            "submiturl": {
                default: "",
                type: String,
                required: true
            },
            "title": {
                default: "Delete item",
                type: String,
                required: false
            },
            "atagclassname": {
                default: "",
                type: String,
                required: false
            },
            "itagclassname": {
                default: "fa fa-trash",
                type: String,
                required: false
            },
            "spanclassname": {
                default: "",
                type: String,
                required: false
            },
            "spantext": {
                default: "",
                type: String,
                required: false
            },
            "swaltitle": {
                default: "Are you sure to delete selected item?",
                type: String,
                required: false
            },
            "swalsuccesstitle": {
                default: "Item has been deleted successfully.",
                type: String,
                required: false
            },
        },
        data() {
            return {}
        },
        methods: {
            /**
             * delete resource
             */
            deleteAfterConfirmation() {
                var self = this;
                swal({
                    title: self.swaltitle,
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel!",
                    showLoaderOnConfirm: !0,
                    reverseButtons: !0,
                    preConfirm: () => {
                        return axios[self.method](self.submiturl)
                                .then(response => {
                                })
                                .catch(error => {
                                    if (error.response && error.response.data) {
                                        error = error.response.data.message;
                                    }
                                    swal.showValidationError(
                                            `Request failed: ${error}`
                                    )
                                })
                    },
                    allowOutsideClick: () => !swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        swal({
                            title: self.swalsuccesstitle
                        });

                        location.href = self.redirectTo;
                    }
                });
            }
        },
        computed: {
            redirectTo() {
                if (this.redirecturl) {
                    return this.redirecturl;
                }

                return this.submiturl.substr(0, this.submiturl.lastIndexOf('/'));
            }
        },
        mounted() {
        },
        destroyed() {
        }
    }
</script>
