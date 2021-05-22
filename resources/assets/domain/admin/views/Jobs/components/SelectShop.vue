<template>
  <modal title="Select B.U." @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row pt-2">
        <label>Select B.U.</label>
        <drop-down
          placeholder="Search B.U"
          v-model="shop_id"
          :options="shops"
          name="b.u."
          v-validate="'required'"
        />
        <label class="error">{{ errors.first('b.u.') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Save</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import DropDown from "../../../../common/components/DropDown/DropDown";
import Modal from  "../../../../common/components/Modal/Modal"
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "SelectShop",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    siteId: {
      type: Number,
      required: true
    },
    jobId: {
      type: Number,
      required: true,
    }
  },
  data: () => ({
    shops: [],
    shop_id: '',
  }),
  created() {
    axios.get(`/api/sites/${this.siteId}/shops`)
      .then(({ data }) => {
        this.shops = data.data;
      })
      .catch(() => {
        console.log('could not get shops');
      })
  },
  methods: {
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          axios.patch(`/api/jobs/${this.jobId}/save-shop`, {shop_id: this.shop_id})
            .then(() => {
              window.location.href = `/jobs/${this.jobId}/edit`;
            })
            .catch(() => {
              console.log('could not save shop');
            })
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  },
};
</script>

