<template>
    <div v-if="user">
        <form
            @submit.prevent="upload"
            method="POST"
            enctype="multipart/form-data"
        >
            <img
                class="border border-indigo-100 shadow-lg round mb-3"
                :src="avatar"
            />

            <input v-if="user.id == auth.id"
                type="file"
                name="avatar"
                id=""
                @change="GetImage"
                accept="image/*"
            />
            <br />
            <!-- <img :src="avatar" alt="" width="200px" /> -->
            <br />
            <a
                href="#"
                v-if="loaded"
                class="btn btn-success"
                @click.prevent="upload"
                >Upload</a
            >
            <a
                href="#"
                v-if="loaded"
                class="btn btn-danger"
                @click.cancel="cancel"
                >Cancel</a
            >
        </form>
    </div>
</template>

<script>
export default {
    props: ["user","auth"],

    data() {
        return {
            avatar: this.user.avatar,
            loaded: false,
            file: null
        };
    },

    methods: {
        GetImage(e) {
            // console.log(e.target.files)
            let image = e.target.files[0];

            let form = new FormData();
            form.append("avatar", image);
            this.read(image);
            this.file = form;
        },

        read(image) {
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                // console.log(e)
                this.avatar = e.target.result;
            };
            this.loaded = true;
        },
        upload() {
            let config = {
                headers: { "Content-Type": "multipart/form-data" }
            };

            axios
                .post("/update/user/image/" + this.user.id, this.file, config)
                .then(res => {
                    this.loaded = false;
                    console.log(res);
                    this.$toast.success("Avatar Created Successfully", {
                        timeout: 3000
                    });
                });
        },
        cancel() {
            this.avatar = this.user.avatar;
            this.loaded = false;
        }
    }
};
</script>
