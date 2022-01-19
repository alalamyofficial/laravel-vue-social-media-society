<template>
        <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2>Profile Settings</h2><hr>

            <div v-for="profile in profiles" :key="profile.id">
                <form>
                    <div class="mb-2">
                        <label for="location_from">Location From</label>
                        <input
                            type="text"
                            name="location_from"
                            id=""
                            class="form-control border shadow"
                            v-model="location_from"
                        />
                        <pre>{{ profile.location_from }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="location_to">Location To</label>
                        <input
                            type="text"
                            name="location_to"
                            id=""
                            class="form-control border shadow"
                            v-model="location_to"
                        />
                        <pre>{{ profile.location_to }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="bio">Bio</label>
                        <input
                            type="text"
                            name="bio"
                            id=""
                            class="form-control border shadow"
                            v-model="bio"
                        />
                        <pre>{{ profile.bio }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="status">Relationship</label>
                        <input
                            type="text"
                            name="status"
                            id=""
                            class="form-control border shadow"
                            v-model="status"
                        />
                        <pre>{{ profile.status }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="date_of_birth">Date Of Birth</label>
                        <input
                            type="date"
                            name="date_of_birth"
                            id=""
                            class="form-control border shadow"
                            v-model="date_of_birth"
                        />
                        <pre>{{ profile.date_of_birth }}</pre>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <button
                               
                                @click.prevent="updateProfile(profile.user_id)"
                                type="button"
                                class="bg-green-400 p-2 px-3 hover:bg-green-300 
                                                        text-white rounded-full"
                            >

                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
    props: ["users", "id","profiles","user_id","old"],

    data(){

        return {

            location_from:"",
            location_to:"",
            bio:"",
            status:"",
            date_of_birth:""
        }

    },

    mounted(){

        console.log(this.users);

    },

    methods:{

        updateProfile(){

            axios
                .put("/profile/update/" + this.user_id, {
                    location_from: this.location_from,
                    location_to: this.location_to,
                    bio: this.bio,
                    status: this.status,
                    date_of_birth: this.date_of_birth,
                })
                .then(res => {

                    this.location_from ="",
                    this.location_to ="",
                    this.bio ="",
                    this.status ="",
                    this.date_of_birth ="",

                    this.$toast.info("Profile Updated Successfully", {
                        timeout: 2000
                    });
                    console.log(res);
                });
        }

    }

}
</script>