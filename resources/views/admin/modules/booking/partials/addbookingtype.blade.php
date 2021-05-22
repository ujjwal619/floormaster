<modal :title="bookingTypeModalAction" :is-large="false" v-if="modals.newBookingType.show"
       @close="closeBookingTypeModal">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <div class="form-group">
          <label class="control-label">Booking Type Name: </label>
          <input type="text" class="form-control" v-model="modals.newBookingType.values.name"/>
          <span class="form-error"
                v-if="form.errors.has('name')"
                v-text="form.errors.get('name')"></span>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group">
          <table class="table">
            <tbody>
            <tr>
              <td></td>
              <td style="font-size: small">Column 1</td>
              <td style="font-size: small">Column 2</td>
              <td style="font-size: small">Column 3</td>
              <td style="font-size: small">Column 4</td>
            </tr>
            <tr>
              <td style="font-size: small">Numeric Column Headings:</td>
              <td><input type="text" class="form-control" v-model="modals.newBookingType.values.numeric_column_headings[0]"/></td>
              <td><input type="text" class="form-control" v-model="modals.newBookingType.values.numeric_column_headings[1]"/></td>
              <td><input type="text" class="form-control" v-model="modals.newBookingType.values.numeric_column_headings[2]"/></td>
              <td><input type="text" class="form-control" v-model="modals.newBookingType.values.numeric_column_headings[3]"/></td>
            </tr>
            </tbody>
          </table>
          <span class="form-error"
                v-if="form.errors.has('numeric_column_headings')"
                v-text="form.errors.get('numeric_column_headings')"></span>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group">
          <label class="control-label">Default Day Limit: </label>
          <input type="number" class="form-control" v-model="modals.newBookingType.values.default_day_limit"/>
          <span class="form-error"
          v-if="form.errors.has('default_day_limit')"
          v-text="form.errors.get('default_day_limit')"></span>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group">
          <label class="control-label">Text Column Heading: </label>
          <input type="text" class="form-control" v-model="modals.newBookingType.values.text_column_heading"/>
          <span class="form-error"
          v-if="form.errors.has('text_column_heading')"
          v-text="form.errors.get('text_column_heading')"></span>
        </div>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            v-if="modals.newBookingType.isEdit"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="removeBookingType()"
    >Remove
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="closeBookingTypeModal">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="saveBookingType"
    >Proceed
    </button>
  </template>
</modal>
