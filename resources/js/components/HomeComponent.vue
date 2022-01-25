<template>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Shop schedule</div>

          <div class="card-body">
            <p v-if="isOpened" class="alert alert-success">We're opened !</p>
            <p v-else-if="isOpened != null" class="alert alert-danger">We're closed !</p>
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
          // timezone: '111'
        },
        isOpened: null
      }
    },
    created() {
      axios.get('/api/is-opened', {
        params: this.params
      })
        .then(response => {
          this.isOpened = response.data.is_opened
        })
        .catch(error => {
          alert(error.response.data.message)
        })
    }
  }
</script>
