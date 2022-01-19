<template>
    <div class="main">
        <h2 class="mb-3">Wallpapers</h2><hr>

        <div class="bg-gray-100 mb-3 border shadow text-lg p-6">
            <small class="mb-1 ml-1">This Person Does not Exist</small>
            <img class="border shadow" src="https://thispersondoesnotexist.com/image" />
        </div>
        <div class="bg-gray-100 border shadow text-lg p-6">
            <img class="border shadow" src="https://picsum.photos/200/300?random=2" />
        </div>
    </div>
</template>

<script>
export default {
    mounted() {},

    data() {
        return {
            wallpapers: []
        };
    },

    created() {}
};
</script>

<style lang="css" scoped>
.main {
    background-color: #ffffff;
}
</style>
