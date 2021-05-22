<template>
  <modal title="Add Sales Staff" @close="handleClose" :is-large="true">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-12">
          <div class="row">
            <label class="required col-3 text-right pr-2">Name:</label>
            <div class="col-6 row">
              <input
                type="text"
                class="col-12 form-control"
                v-model="model.name"
                name="name"
                v-validate="'required'"
                autocomplete="off"
              />
              <label class="error">{{ errors.first('name') }}</label>
            </div>
            <label class="col-3 pl-3 d-flex align-items-center">
              <input type="checkbox" class="mt-1" v-model="model.is_active" />
              <span class="ml-2">Active</span>
            </label>
          </div>
          <div class="row pt-4">
            <div class="col-6 row">
              <fieldset>
                <legend>Commission Calculation</legend>
                <label class="w-50">
                  <input
                    type="radio"
                    v-model="model.commission_calculation"
                    value="1"
                    name="commission calculation"
                    v-validate="'required|included:1,2,3,4'"
                  />
                  <span class="pl-1">Gross Profit on Actual</span>
                </label>
                <label class="w-50">
                  <input
                    type="radio"
                    v-model="model.commission_calculation"
                    value="2"
                    name="commission calculation"
                  />
                  <span class="pl-1">Sell Price</span>
                </label>
                <label class="w-50">
                  <input
                    type="radio"
                    v-model="model.commission_calculation"
                    value="3"
                    name="commission calculation"
                  />
                  <span class="pl-1">Gross Profit on Estimate</span>
                </label>
                <label class="w-50">
                  <input
                    type="radio"
                    v-model="model.commission_calculation"
                    value="4"
                    name="commission calculation"
                  />
                  <span class="pl-1">As Costed</span>
                </label>
              </fieldset>
              <label class="error">{{ errors.first('commission calculation') }}</label>
              <fieldset>
                <legend>First Tier (Commission Starts at:)</legend>
                <label>
                  <span class="pl-1">Dollar Value $:</span>
                  <input
                    v-model="model.first_tier.dollar_value"
                    type="number"
                    class="form-control"
                  />
                </label>
                <label>
                  <span class="pl-1">Pay Rate %</span>
                  <input
                    v-model="model.first_tier.pay_rate"
                    type="number"
                    class="form-control"
                  />
                </label>
              </fieldset>
              <fieldset>
                <legend>Second Tier</legend>
                <label>
                  <span class="pl-1">Dollar Value $:</span>
                  <input
                    v-model="model.second_tier.dollar_value"
                    type="number"
                    class="form-control"
                  />
                </label>
                <label>
                  <span class="pl-1">Pay Rate %</span>
                  <input
                    v-model="model.second_tier.pay_rate"
                    type="number"
                    class="form-control"
                  />
                </label>
              </fieldset>
              <fieldset>
                <legend>Third Tier</legend>
                <label>
                  <span class="pl-1">Dollar Value $:</span>
                  <input
                    v-model="model.third_tier.dollar_value"
                    type="number"
                    class="form-control"
                  />
                </label>
                <label>
                  <span class="pl-1">Pay Rate %</span>
                  <input
                    v-model="model.third_tier.pay_rate"
                    type="number"
                    class="form-control"
                  />
                </label>
              </fieldset>
            </div>
            <span class="h6 col-6 info-text pl-3 m-auto">
              Determine how you want commission paid.
              <br />
              <br />Gross Profit on Actual uses the jobs accumulated
              costs vs invoiced. If you use the entire FM system
              this is the most accurate but will only include
              jobs that are completed with all costs in. You
              should ensure that Cost Deeming is a practice.
              <br />Gross Profit on Estimate Calculates commission on
              the estimated figures against invoice. Actual
              costs are ignored
              <br />Sell price calculates on the invoiced value only.
              <br />As Costed uses the value in the commission field
              of the job.
              <br />Commissions can be escalated over three levels.
              <br />
              <br />E.g. Commission starts at $20,000 pm. 5% is paid
              on GP between $20,000 and $25,000. 7.5% is paid
              on $25,000 to $30,000. 10% is paid on GP of
              $30,000 amd above.
              <br />
              <br />1st Tier... Dollar Value = $20,000. Pay Rate = 5%.
              <br />2nd Tier... Dollar Value = $25,000. Pay Rate = 7.5%.
              <br />3rd Tier... Dollar Value = $30,000. Pay Rate = 10%.
            </span>
          </div>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleSave">Finished</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../../common/mixins';

export default {
  name: "SalesStaff",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    site: {
      type: Number,
      required: true
    },
    salesStaff: {
      type: Object,
      default: () => ({})
    }
  },
  data: () => ({
    model: {
      name: "",
      is_active: true,
      commission_calculation: "",
      first_tier: {
        dollar_value: "",
        pay_rate: ""
      },
      second_tier: {
        dollar_value: "",
        pay_rate: ""
      },
      third_tier: {
        dollar_value: "",
        pay_rate: ""
      }
    }
  }),
  watch: {
    salesStaff: {
      immediate: true,
      handler(staffData) {
        if (this.salesStaff.id) {
          this.model = this.salesStaff;
          this.model.first_tier = {...this.salesStaff.first_tier} || {}
          this.model.second_tier = {...this.salesStaff.second_tier} || {}
          this.model.third_tier = {...this.salesStaff.third_tier} || {}
        }
      }
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    validate() {
      return this.$validator.validate();
    },
    handleSave() {
      this.validate().then(valid => {
        if (valid) {
          this.saveSalesStaff();
        }
      });
    },
    saveSalesStaff() {
      const method = this.salesStaff.id ? "put" : "post";
      const url = this.salesStaff.id
        ? `api/sales_staff/${this.salesStaff.id}`
        : `api/sites/${this.site}/sales_staff`;

      const message = this.salesStaff.id ? "edit" : "add";

      this.enableLoading();
      axios[method](url, { ...this.model })
        .then(data => {
          this.$toastr(
            "success",
            `Successfully ${message}ed Sales Staff`,
            "Success!!"
          );
          this.$emit("saved");
          this.handleClose();
        })
        .catch(error => {
          this.$toastr(
            "error",
            `Error in ${message}ing Sales Staff`,
            "Error!!"
          );
        })
        .finally(this.disableLoading);
    }
  }
};
</script>

<style scoped>
fieldset {
  min-width: auto;
  padding: 5px 15px;
  margin: auto;
  width: 100%;
  border: 2px solid rgb(192, 192, 192);
}

legend {
  width: auto;
  padding: unset;
  margin: unset;
  font-size: unset;
}

label {
  display: inline-block;
}

.info-text {
  text-align: justify;
}
</style>
