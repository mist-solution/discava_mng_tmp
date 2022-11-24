<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">404 Page Not Found</div>
                    <div class="card-body">ページが存在しません。</div>
                    <router-link v-bind:to="{ name: 'enduser.list' }">
                        <button class="btn btn-success ml-1">
                            戻る
                        </button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("example mounted.");
    },
};
</script>