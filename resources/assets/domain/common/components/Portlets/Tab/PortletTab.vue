<template>
    <div class="tab-pane" :class="{ 'active' : isActive }" role="tabpanel" v-show="isActive">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "PortletTab",
        data() {
            return {
                isActive: false
            }
        },
        props: {
            title: {
                type: String,
                required: true
            },
            active: {
                type: [Boolean, String],
                default: false
            },
            name: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>