<template>
    <div class="table-component">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="m-input-icon m-input-icon--left">
                            <input type="text" class="form-control m-input" placeholder="Search..."
                                   v-model="searchQuery"
                                   @keyup="filterData">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                      <span><i class="fa fa-search"></i></span>
                    </span>
                        </div>
                    </div>
                    <div class="col-md-9 m--align-right m--align-push" v-if="pagination && tableData.length > 0">
                        <span>Show &nbsp;</span>
                        <select v-model="perPage" @change="changePerPage()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entries</span>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="table-wrapper">
            <div class="wrapper" :class="{ loading: dataLoading }">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="table-head">#</th>
                            <th v-for="column in columns" :key="column" @click="sortByColumn(column)"
                                class="table-head">{{ column | columnHead }}
                                <span v-if="column === sortedColumn">
                            <i v-if="order === 'asc' " class="fa fa-arrow-up arrows"></i>
                            <i v-else class="fa fa-arrow-down arrows"></i>
                        </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody data-scrollbar-shown="true">
                        <tr class="" v-if="tableData.length === 0">
                            <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
                        </tr>
                        <tr v-for="(data, key1) in tableData" :key="data.id" class="m-datatable__row" v-else>
                            <td>{{ serialNumber(key1) }}</td>
                            <td v-for="(value, key) in data" v-if="key !== 'action'">{{ value }}</td>
                            <td>
                        <span v-for="(value, key) in data.action" class="m-demo__preview m-demo__preview--btn">
                            <a v-if="key === 'view'"
                               class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only btn-sm m-btn--custom m-btn--pill"
                               data-toggle='tooltip' title='View details' :href="value"><i
                                    class="fa fa-eye"></i></a>
                            <a v-if="key === 'edit'" @click.prevent="handleEdit(value)"
                               class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only btn-sm m-btn--custom m-btn--pill"
                               data-toggle='tooltip' title='Edit details'><i class="fa fa-pencil"></i></a>
                            <a v-if="key === 'delete'"
                               class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only btn-sm m-btn--custom m-btn--pill"
                               data-toggle='tooltip' :title='value.title' @click="deleteAfterConfirmation(value)"><i
                                    :class="value.icon"></i></a>
                             <a v-if="key === 'other'"
                                class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only btn-sm m-btn--custom m-btn--pill"
                                data-toggle='tooltip' :title='value.title' :href="value.url"><i
                                     :class="value.icon"></i></a>

                        </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <nav v-if="pagination && tableData.length > 0">
                <ul class="pagination">
                    <li class="page-item" :class="{'disabled' : currentPage === 1}">
                        <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
                    </li>
                    <li v-for="page in pagesNumber" class="page-item"
                        :class="{'active': page == pagination.meta.current_page}">
                        <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{'disabled': currentPage === pagination.meta.last_page }">
                        <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                    </li>
                    <span style="margin-top: 8px;"> &nbsp; <i>Displaying {{ pagination.data.length }} of {{ pagination.meta.total }} entries.</i></span>
                </ul>
            </nav>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
import axios from "axios";
import swal from "sweetalert2";

export default {
  name: "data-table",
  props: {
    source: {
      type: String,
      required: true
    },
    columns: {
      type: Array,
      required: true
    },
    innercontent: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      tableData: [],
      pagination: {
        meta: {
          to: 1,
          from: 1
        }
      },
      offset: 4,
      currentPage: 1,
      searchQuery: "",
      sortedColumn: "created_at",
      perPage: this.innercontent ? 5 : 10,
      order: "desc",
      dataLoading: true
    };
  },
  mounted() {
    this.fetchData();
  },
  filters: {
    columnHead(value) {
      return value
        .split("_")
        .join(" ")
        .toUpperCase();
    }
  },
  computed: {
    /**
     * Get the pages number array for displaying in the pagination.
     * */
    pagesNumber() {
      if (!this.pagination.meta.to) {
        return [];
      }
      let from = this.pagination.meta.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.meta.last_page) {
        to = this.pagination.meta.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    },
    /**
     * Get the total data displayed in the current page.
     * */
    totalData() {
      return this.pagination.meta.to - this.pagination.meta.from + 1;
    }
  },
  methods: {
    /**
     * Fetches the data from the source provided.
     * */
    fetchData() {
      this.dataLoading = true;

      let fetchUrl = `${this.source}?page=${this.currentPage}&search=${
        this.searchQuery
      }&column=${this.sortedColumn}&order=${this.order}&per_page=${
        this.perPage
      }`;

      axios
        .get(fetchUrl)
        .then(response => {
          this.dataLoading = false;
          this.pagination = response.data;
          this.tableData = response.data.data;
          setTimeout(() => {
            $('[data-toggle="tooltip"]').tooltip();
          }, 100);
        })
        .catch(error => {
          alert("Data fetch failed.");
          this.dataLoading = false;
        });
    },
    /**
     * Get the serial number.
     * @param key
     * */
    serialNumber(key) {
      return (this.currentPage - 1) * this.perPage + 1 + key;
    },
    /**
     * Filters the data.
     * */
    filterData() {
      this.fetchData();
    },
    /**
     * Change the page.
     * @param pageNumber
     */
    changePage(pageNumber) {
      this.currentPage = pageNumber;
      this.fetchData();
    },
    changePerPage() {
      this.currentPage = 1;
      this.fetchData();
    },
    /**
     * Sort the data by column.
     * */
    sortByColumn(column) {
      if (column !== "action") {
        if (column === this.sortedColumn) {
          this.order = this.order === "asc" ? "desc" : "asc";
        } else {
          this.sortedColumn = column;
          this.order = "asc";
        }
        this.fetchData();
      }
    },
    /**
     * delete resource
     */
    deleteAfterConfirmation(context) {
      var self = this;
      swal({
        title: context.title,
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes!",
        cancelButtonText: "No, cancel!",
        showLoaderOnConfirm: !0,
        reverseButtons: !0,
        preConfirm: () => {
          const method = context.method;
          return axios[method](context.url)
            .then(response => {})
            .catch(error => {
              swal.showValidationError(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then(result => {
        if (result.value) {
          swal({
            title: context.success_message
          });
          this.$toastr("success", context.success_message, "Success!!");
        }

        self.fetchData();
      });
    },
    /**
     * Handle the edit click.
     * @param  {object} editData
     */
    handleEdit(editData) {
      if (editData.hasOwnProperty("custom_edit")) {
        this.$emit("edit-pressed", editData.urls);
      } else {
        location.href = editData;
      }
    }
  }
};

$().ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
<style scoped>
.wrapper {
  position: relative;
}

.loading:before {
  content: "";
  display: block;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: 100;
  background: rgba(0, 0, 0, 0.125) center center no-repeat
    url("http://samherbert.net/svg-loaders/svg-loaders/oval.svg");
}

.arrows {
  font-size: 14px;
  color: white;
}

.table-head {
  background: #767fcc;
  color: white;
}

.page-item.active .page-link {
  background-color: #767fcc;
  border-color: #767fcc;
}

.table-wrapper {
  overflow: auto;
}
</style>
