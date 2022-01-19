<template>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2>User Settings</h2>
            <hr />

            <div v-for="user in users" :key="user.id">
                <form>
                    <div class="mb-2">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            name="name"
                            id=""
                            class="form-control border shadow"
                            v-model="name"
                        />
                        <pre>{{ user.name }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            name="username"
                            id=""
                            class="form-control border shadow"
                            v-model="username"
                        />
                        <pre>{{ user.username }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id=""
                            class="form-control border shadow"
                            v-model="email"
                        />
                        <pre>{{ user.email }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="phone">Phone Number</label>
                        <input
                            type="number"
                            name="phone"
                            id=""
                            class="form-control border shadow"
                            v-model="phone"
                        />
                        <pre>0{{ user.phone }}</pre>
                    </div>
                    <div class="mb-2">
                        <label for="gender">Gender</label>
                        <select
                            v-model="gender"
                            name="gender"
                            id=""
                            class="form-control border shadow"
                        >
                            <option :value="0">Male</option>
                            <option :value="1">Female</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <div class="flex">
                            <!-- <div>
                                <label for="avatar">Avatar</label>
                                <input
                                    type="file"
                                    name="avatar"
                                    id=""
                                    class="form-control border shadow pt-1 pb-4"
                                    style="width:600px"
                                />
                            </div> -->
                        <Vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></Vue-dropzone>

                            <div style="margin-left:10px">
                                <img
                                    :src="user.avatar"
                                    alt=""
                                    class="mt-6"
                                    width="60px"
                                    name="avatar"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id=""
                            class="form-control border shadow"
                            v-model="password"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="password">Confirmed Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id=""
                            class="form-control border shadow"
                            v-model="password_confirmation"
                        />
                    </div>

                    <div class="form-group">
                        <div class="">
                            <button
                                @click.prevent="updateUser(user.id)"
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
import Vue2Dropzone from 'Vue2-dropzone'  
import 'Vue2-dropzone/dist/Vue2Dropzone.min.css'  

var url = "{{ route('product.createnew') }}";

export default {
    props: ["users", "id"],

    components: {
        VueDropzone: Vue2Dropzone
    },

    data() {
        return {
            name: "",
            username: "",
            email: "",
            gender: "",
            phone: "",
            avatar: "",
            password: "",
            password_confirmation: "",
            dropzoneOptions: {  
              url: '/settings/update/',  
              headers: {  
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')  
               }  
            }  
            
        };
    },

    mounted() {
        console.log(this.users);
    },

    methods: {
        updateUser(id) {
            axios
                .post("/settings/update/" + id, {
                    name: this.name,
                    username: this.username,
                    email: this.email,
                    gender: this.gender,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(res => {
                    (this.name = ""),
                        (this.username = ""),
                        (this.email = ""),
                        (this.gender = ""),
                        (this.phone = ""),
                        (this.password = ""),
                        (this.password_confirmation = "");

                    this.$toast.info("User Updated Successfully", {
                        timeout: 2000
                    });
                    console.log(res);
                });
        }
    }
};

//    <!-- <router-link to="settings/{username}"></router-link>  -->
</script>
