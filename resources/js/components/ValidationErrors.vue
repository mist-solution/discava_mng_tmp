<template>
    <div v-if="validationErrors" class="errorMsg col-sm-10 col-md-10 col-11">
        <ul class="alert alert-danger list-unstyled">
            <li v-for="(value, index) in validationErrors" :key="index">{{ value }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: Object
    }, 
    computed: {
        validationErrors() {
            let errors = Object.values(this.errors)
            errors = errors.flat()
            return errors;
        }
    }
}
</script>

<style scoped>
.errorMsg>ul {
    --bs-alert-bg: #f7f7f7;
    --bs-alert-border: 1px solid #c60100 !important;
    border-radius: 10px;
    padding: 1rem 0.4rem;
    color: #c60100;
    font-weight: bolder;
}

.errorMsg>ul>li {
    padding-left: 0.4rem;
}

</style>
