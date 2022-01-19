<template>
    <div>
        <p class="text-center">
            <button
                type="button"
                @click="add_friend"
                v-if="status == 0"
                class="float-right bg-blue-400 hover:bg-blue-300 mt-3 mb-4 mr-8
                text-white pt-2 pb-2 pr-4 pl-4 rounded-lg"
            >
                Add Friend
            </button>

            <button
                type="button"
                @click="cancel_add_request"
                v-if="status == 'waiting'"
                class="float-right bg-gray-400 hover:bg-gray-300 mt-3 mb-4 mr-4
                    text-white pt-2 pb-2 pr-4 pl-4 rounded-lg text-sm"
            >
                Cancel Request
            </button>

            <span class="flex">
                <button
                    type="button"
                    @click="accept_friend"
                    v-if="status == 'pending'"
                    class="float-right bg-blue-400 hover:bg-blue-300 mt-3 mb-4 mr-2
                    text-white pt-2 pb-2 pr-4 pl-4 rounded-lg"
                >
                    Accept
                </button>

                <button
                    type="button"
                    @click="cancel_request"
                    v-if="status == 'pending'"
                    class="float-right bg-red-300 hover:bg-red-200 mt-3 mb-4 mr-2
                    text-white pt-2 pb-2 pr-4 pl-4 rounded-lg text-sm"
                >
                    Cancel
                </button>
            </span>

            <!-- <span class="text-success" v-if="status == 'waiting'"
                >Waiting for response</span
            > -->
            <span class="text-success" v-if="status == 'friends'">Friends</span>
        </p>
    </div>
</template>

<script>
export default {
    props: ["profile_user_id"],

    mounted() {
        axios
            .get("/check_relationship_status/" + this.profile_user_id)
            .then(response => {
                console.log(response);
                this.status = response.data.status;
                this.loading = 0;
            });
    },

    data() {
        return {
            status: ""
        };
    },

    methods: {
        add_friend() {
            this.status = "0";
            axios.get("/add/" + this.profile_user_id).then(response => {
                console.log(response);
                this.status = "waiting";
                this.$toast.success("Friend request sent .", {
                    timeout: 3000
                });
            });
        },
        cancel_add_request() {
            this.status = "waiting";
            axios.get("/cancel/add/" + this.profile_user_id).then(res => {
                console.log(res);
                this.status = "0";
            });
        },

        accept_friend() {
            axios.get("/accept/" + this.profile_user_id).then(response => {
                if (response.data == 1) {
                    console.log(response);
                    this.status = "friends";
                }
            });
        },

        cancel_request() {
            axios.get("/cancel/" + this.profile_user_id).then(res => {
                console.log(res);
                this.status = "0";
            });
        }
    }
};
</script>
