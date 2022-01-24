<template>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Shop schedule</div>

                    <div class="card-body">
                        <p class="alert alert-success">We're opened !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
          let date = new Date()
            console.log(date.getDay())
        }
    }
</script>
