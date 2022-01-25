<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Shop settings</div>

          <div class="card-body">
            <h5>Working days</h5>
            <div class="d-flex justify-content-between mb-3">
              <div v-for="(day, dayNumber) in settings.working_days">
                <label :for="'day-' + dayNumber">{{weekday[dayNumber]}}</label>
                <input v-model="settings.working_days[dayNumber]" type="checkbox" :value="day" :id="'day-' + dayNumber">
              </div>
            </div>

            <h5>Working hours</h5>
            <div class="d-flex mb-3">
              <div class="mx-2">
                <label for="working-time-from">From</label>
                <input v-model="settings.working_hours.from" type="time"
                       class="form-control form-control-sm input-time bg-success"
                       id="working-time-from">
              </div>
              <div class="mx-2">
                <label for="working-time-to">To</label>
                <input v-model="settings.working_hours.to" type="time"
                       class="form-control form-control-sm input-time bg-success" id="working-time-to">
              </div>
            </div>

            <h5>Non-working hours</h5>
            <div class="d-flex mb-3">
              <div class="mx-2">
                <label for="non-working-time-from">From</label>
                <input v-model="settings.non_working_hours.from" type="time"
                       class="form-control form-control-sm input-time bg-danger"
                       id="non-working-time-from">
              </div>
              <div class="mx-2">
                <label for="non-working-time-to">To</label>
                <input v-model="settings.non_working_hours.to" type="time"
                       class="form-control form-control-sm input-time bg-danger" id="non-working-time-to">
              </div>
            </div>

            <button class="btn btn-sm btn-primary mt-5" @click="saveSettings">Save</button>
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
        weekday: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        settings: {
          working_days: {},
          working_hours: {},
          non_working_hours: {},
        },
      }
    }
    ,
    created() {
      axios.get('/api/settings')
        .then(response => {
          this.settings = response.data
        })
        .catch(error => {
          alert(error.response.data.message)
        })
    },
    methods: {
      saveSettings() {
        axios.post('/api/settings', this.settings)
          .then(() => {
            alert('Settings saved')
          })
          .catch(error => {
            alert(error.response.data.message)
          })
      },
    },
  }
</script>

<style scoped>
  .input-time {
    max-width: 100px;
  }
</style>