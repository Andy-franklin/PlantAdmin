<template>
    <div class="loading-container">
        <img class="loader" src="images/chilli.svg">
    </div>
</template>

<script>
export default {
    name: "Loader"
}
</script>

<style scoped>
    .loading-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loader {
        width: 200px;
        height: 200px;

        opacity: 1;
        animation: fade 2s infinite ;
    }

    @keyframes fade {
        0% { opacity: 0; }
        50% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
