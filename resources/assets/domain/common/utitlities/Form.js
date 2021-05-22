import Errors from './Errors';

class Form {
    constructor(data) {
        this.originalData = data;
        for (let field in data) {
            this[field] = data[field];
        }
        this.errors = new Errors();
    }

    reset() {
        this.errors.clear();
        for (let field in this.originalData) {
            this[field] = (field == 'errors') ? new Errors() : '';
        }
        location.reload();
    }

    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    onSubmit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                    .then(response => {
                        this.onSuccess(response.data);

                        resolve(response.data);
                    })
                    .catch(error => {
                        this.onFailure(error.response);
                        reject(error.response.data.errors);
                    });
        });
    }

    onSuccess(data) {
        this.reset();
        this.alertLevel   = data.type;
        this.alertMessage = data.message;
    }

    onFailure(response) {
        this.alertLevel   = "failure";
        this.alertMessage = response.data.message;
        this.alertMessage = (response.status == 422) ? "There are some validation errors." : this.alertMessage;
        this.errors.record(response.data.errors);
    }
}

export default Form;
