<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Shop schedule</div>

          <div class="card-body">
            <div v-if="isOpened">
              <p class="alert alert-success">We're opened !</p>
            </div>
            <div v-else-if="isOpened != null">
              <p class="alert alert-danger">We're closed !</p>
              <p class="alert alert-warning">We will open in {{willOpen}}!</p>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">Check when we are open</div>

          <div class="card-body">
            <div class="d-flex mb-2">
              <input v-model="selectedDate" type="date" class="form-control form-control-sm date-input mx-2">
              <input v-model="selectedTime" type="time" class="form-control form-control-sm time-input mx-2">
            </div>
            <div v-if="isOpenedByDateTime">
              <p class="alert alert-success">We're opened !</p>
            </div>
            <div v-else-if="isOpenedByDateTime != null">
              <p class="alert alert-danger">We're closed !</p>
            </div>
          </div>

          <div class="card-footer">
            <button :disabled="!selectedDate || !selectedTime" class="btn btn-sm btn-primary"
                    @click="checkIsOpened()"
            >
              Check
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        params: {
          date_to_check_timestamp: parseInt(Date.now() / 1000),
          timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
        },
        isOpened: null,
        isOpenedByDateTime: null,
        selectedDate: null,
        selectedTime: null,
        willOpen: null,
      }
    },
    created() {
      this.isOpenedRequest(this.params)
        .then(response => {
          this.isOpened = response.data.is_opened

          if (!this.isOpened) {
            this.willOpen = response.data.will_open
          }
        })
        .catch(error => {
          alert(error.response.data.message)
        })
    },
    methods: {
      isOpenedRequest(params) {
        return axios.get('/api/is-opened', {
          params: params
        })
      },
      checkIsOpened() {
        let date = new Date(this.selectedDate + ' ' + this.selectedTime)
        let params = {
          date_to_check_timestamp: parseInt(date.getTime() / 1000),
          timezone: this.params.timezone
        }

        this.isOpenedRequest(params)
          .then(response => {
            this.isOpenedByDateTime = response.data.is_opened
          })
          .catch(error => {
            alert(error.response.data.message)
          })
      }
    }
  }
</script>

<style scoped>
  .date-input {
    max-width: 200px;
  }

  .time-input {
    max-width: 100px;
  }
</style>