<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Shop settings</div>

          <div class="card-body">
            <h5>Working days</h5>
            <div class="d-flex justify-content-between">
              <div v-for="(day, dayNumber) in settings.working_days">
                <label :for="'day-' + dayNumber">{{weekday[dayNumber]}}</label>
                <input v-model="settings.working_days[dayNumber]" type="checkbox" :value="day"  :id="'day-' + dayNumber">
              </div>
            </div>
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
        settings: {}
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
    }
  }
</script>
