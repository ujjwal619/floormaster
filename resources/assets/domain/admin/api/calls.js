export function getSites(params = {}) {
  return axios.get("/api/sites", {params: params})
}

export function isMySite(siteId) {
  return axios.get(`/api/sites/${siteId}/is-my-site`);
}

export function getSiteById(siteId) {
  return axios.get(`/api/sites/${siteId}`);
}

export function getStates() {
  return axios.get('/api/states');
}

export function getAustralianPostcodes(params = {}) {
  return axios.get('/api/australia/postcodes', {params: params});
}

export function getTermsBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/terms`)
}

export function getContractorsBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/contractors`)
}

export function getStockByColor(colorId) {
  return axios.get(`/api/color/${colorId}/stocks`)
}

export function getCurrentStockList(variant) {
  return axios.get(`/api/color/${variant}/current-stocks`);
}

export function getMyFirstAllowedSite() {
  return axios.get(`/api/my-first-allowed-site`);
}

export function getSuppliers(params = {}) {
  return axios.get(`/api/suppliers/list`, {params: params});
}

export function getProductCategories(params = {}) {
  return axios.get(`/api/categories`, {params: params});
}

export function getSupplierById(id) {
  return axios.get(`/api/suppliers/${id}`);
}

export function getSuppliersBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/suppliers`);
}

export function getAccountsBySite(siteId, params = {}) {
  return axios.get(`/api/sites/${siteId}/accounts`, {params: params});
}

export function getTransactionJournalsBySite(siteId, params = {}) {
  return axios.get(`/api/sites/${siteId}/transaction-journals`, {params: params});
}

export function getJobsBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/jobs`);
}

export function getJobs(params = {}) {
  return axios.get(`/api/jobs`, { params: params});
}

export function getNonAllocatedReceipts(jobId, params = {}) {
  return axios
    .get(`/jobs/${jobId}/non-allocated-receipts`, { params: params });
}

export function getProductsBySupplier(supplierId) {
  return axios.get(`/api/suppliers/${supplierId}/products`);
}

export function getColorsByProduct(productId) {
  return axios.get(`/api/products/${productId}/colors`);
}

export function getCashBooksBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/cash-books`);
}


export function getAvailableCashBooksBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/cash-books/available`);
}

export function postCashBook(payload={}) {
  return axios.post('/api/cash-books', payload);
}

export function bulkUpdateCashBook(payload={}) {
  return axios.put('/api/cash-books/bulk', payload);
} 

export function getCashBook(siteId, params = {}) {
  return axios.get(`/api/sites/${siteId}/cash-books`, { params: params});
}

export function putCashBook(id, payload = {}) {
  return axios.put(`/api/cash-books/${id}`, payload);
}

export function getAllocations(params = {}) {
  return axios.get(`/api/allocations`, {params: params});
}

export function putAllocation(id, payload = {}) {
  return axios.put(`/api/allocations/${id}`, payload);
}
export function dispatchAllocation(id, payload = {}) {
  return axios.patch(`/api/allocations/${id}/dispatch`, payload);
}

export function getBankReconcilicationsBySite(siteId, params = {}) {
  return axios.get(`/api/sites/${siteId}/bank-reconciliations`, { params: params});
}

// users apis
export function getUsers() {
  return axios.get("/api/users")
}

export function getUsersBySite(siteId) {
  return axios.get(`/api/sites/${siteId}/users`);
}

export function getMyProfile() {
  return axios.get("/api/users/me");
}

export function getUserById(userId) {
  return axios.get(`/api/users/${userId}`);
}

export function putUser(userId, payload={}) {
  return axios.put(`api/users/${userId}`, payload);
} 



// memos apis
export function getMemosByUser(userId) {
  return axios.get(`/api/users/${userId}/memos`);
}

//payables apis
export function indexPayable() {
  return axios.get(`/api/payables/index`);
}

export function getPayableById(id) {
  return axios.get(`/api/payables/${id}`);
}

export function deletePayable(id) {
  return axios.delete(`/api/payables/${id}`);
}

export function getPayables(params = {}) {
  return axios.get(`/api/payables`, { params: params});
}

//current orders apis
export function getCurrentOrders(params = {}) {
  return axios.get(`/api/current-orders`, { params: params});
}

export function postCurrentOrder(payload={}) {
  return axios.post('/api/current-orders', payload);
}

//delivery orders apis
export function getDeliveryOrders(params = {}) {
  return axios.get(`/api/delivery-orders`, { params: params});
}

//products apis
export function getProducts(params = {}) {
  return axios.get(`/api/products`, { params: params});
}

//colors apis
export function getColors(params = {}) {
  return axios.get(`/api/colors`, { params: params});
}

//reports apis
export function getProductReport(params = {}) {
  return axios.get(`/api/reports/products`, { params: params});
}

export function getColourwaysReport(params = {}) {
  return axios.get(`/api/reports/products/colourways`, { params: params});
}

export function getBillingReport(params = {}) {
  return axios.get(`/api/reports/job/billing`, { params: params});
}

export function getTakingReport(params = {}) {
  return axios.get(`/api/reports/job/taking`, { params: params});
}

export function getMITReport(params = {}) {
  return axios.get(`/api/reports/job/mit`, { params: params});
}

export function getSuppliersReport(params = {}) {
  return axios.get(`/api/suppliers/report`, {params: params});
}

export function getWipReport(params = {}) {
  return axios.get(`/api/reports/job/wip`, {params: params});
}

export function getCommissionReport(params = {}) {
  return axios.get(`/api/reports/job/commission`, {params: params});
}

export function getJobCostsReport(params = {}) {
  return axios.get(`/api/reports/job/job-costs`, {params: params});
}

export function getUnderInvoicedReport(params = {}) {
  return axios.get(`/api/reports/job/under-invoiced`, {params: params});
}

//clients apis
export function getClients(params = {}) {
  return axios.get(`/api/clients`, { params: params});
}

//remittance apis
export function putRemittanceItem(remittanceId, remittanceItemId, payload = {}) {
  return axios.put(`/api/remittances/${remittanceId}/items/${remittanceItemId}`, payload);
}

export function getRemittanceById(id) {
  return axios.get(`/api/remittances/${id}`);
}

//stock apis
export function getFutureStockById(id) {
  return axios.get(`/api/future-stocks/${id}`);
}

export function patchBackOrderToCurrentStock(backOrderId, currentStockId) {
  return axios.patch(`/api/back-orders/${backOrderId}/move/current-stocks/${currentStockId}`);
}
export function patchBackOrderToFutureStock(backOrderId, futureStockId) {
  return axios.patch(`/api/back-orders/${backOrderId}/move/future-stocks/${futureStockId}`);
}
export function patchAllocationToCurrentStock(allocationId, currentStockId) {
  return axios.patch(`/api/allocations/${allocationId}/move/current-stocks/${currentStockId}`);
}
export function patchAllocationToFutureStock(allocationId, futureStockId) {
  return axios.patch(`/api/allocations/${allocationId}/move/future-stocks/${futureStockId}`);
}

//bookings apis
export function getBookings(params = {}) {
  return axios.get(`/api/bookings/list`, {params: params});
}

export function getBookingTypes(params = {}) {
  return axios.get(`/api/booking-types/list`, {params: params});
}


//action required apis
export function getActionRequired(params = {}) {
  return axios.get(`/api/action-required`, {params: params});
}

//installation complaint apis
export function getInstallationComplaints(params = {}) {
  return axios.get(`/api/installation-complaints`, {params: params});
}
