<template>
</template>

<script>
    import PortletContent from '../../../../common/components/Portlets/Content/PortletContent'
    import VueTable from '../../../../common/components/Datatable/DataTable'
    import Modal from '../../../../common/components/Modal/Modal'
    import Form from "../../../../common/utitlities/Form"
    import Axios from 'axios'

    export default {
        name: "Category",
        props: {
            url: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                form: new Form(),
                loaded: true,
                method: 'post',
                submitUrl: '',
                modals: {
                    'form': {
                        show: false,
                        disableSave: false,
                        values: {},
                    }
                }
            }
        },
        components: {
            PortletContent,
            VueTable,
            Modal
        },
        methods: {
            handleEditAction(urls) {
                Axios.get(urls.details)
                        .then(response => {
                            let {data} = response.data;
                            let formModal = this.modals['form'];
                            formModal.values = data;
                            formModal.show = true;
                            this.submitUrl = urls.update;
                            this.method = 'patch';
                        })
                        .catch(error => {
                            this.$toastr('error', 'Unable to fetch the data', 'Error!!');
                        });
            },
            /**
             * Show the modal.
             * @param  {string} modal
             * @returns {boolean}
             */
            showModal(modal) {
                this.submitUrl = this.url;
                return this.modals[modal].show = !this.modals[modal].show;
            },
            /**
             * @param {string} modal
             * */
            hideModal(modal) {
                this.modals[modal].show = false;
                this.method = 'post';
                this.modals[modal].values = {};
                this.form = new Form();
            },
            /**
             * Submit the form.
             */
            submitForm() {
                let values = this.modals['form'].values;
                this.form = new Form(values);
                this.form.onSubmit(this.method, this.submitUrl)
                        .then(response => {
                            this.$toastr('success', this.form.alertMessage, 'Success!!');
                            window.location.href = this.url;
                        })
                        .catch(errors => {
                            this.updateUrl = '';
                            this.$toastr('error', this.form.alertMessage, 'Error!!');
                        });
            }
        }
    }
</script>

<style scoped>

</style>