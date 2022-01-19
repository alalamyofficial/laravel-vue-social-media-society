<template>
    <div
        class="p-5 bg-white border shadow"
        style="position:fixed; width: 250px; right:40px"
    >
        <span>
            <b>
                <i class="fa fa-users ml-2 mr-1"></i>
                Suggest Friends
            </b>
        </span>

        <br /><br />

        <div v-for="friend in suggestFriends" :key="friend.id">
            <div class="flex bg-gray-100 mb-3 shadow-sm">
                <img
                    :src="friend.avatar"
                    alt=""
                    class="border rounded-full mr-3"
                    width="40px"
                />

                <a class="mt-1" :href="/profile/ + friend.username">
                    <strong >{{ friend.name }}</strong>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            suggestFriends: []
        };
    },

    mounted() {
        this.suggest_friends();
    },

    methods: {
        suggest_friends() {
            axios.get("suggest/friends").then(response => {
                this.suggestFriends = response.data;
            });
        }
    }
};
</script>
