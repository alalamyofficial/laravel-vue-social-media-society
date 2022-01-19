<template>
    <div>
        <h2>Media</h2>
        <br />
        <hr />
        <div class="images" v-viewer>
            <div v-for="post in posts" :key="post.id">
                <div class="bg-white mt-3 mb-5">
                    <div class="">
                        <div v-if="post.images !== 'NULL'">
                            <div class="row justify-content-center">
                                <img
                                    class="border rounded-t-lg mb-2"
                                    :src="'/' + post.images"
                                    width="500px"
                                />
                            </div>
                        </div>
                        <div
                            class="bg-white border shadow p-2 text-xl text-gray-700 font-semibold"
                        >
                            <i class="fa fa-user"></i>
                            <a
                                class="ml-1 mt-2"
                                :href="/profile/ + post.user.username"
                                >{{ post.user.name }}</a
                            >
                            <div style="margin-left: 995px; margin-top:-28px">
                                <div class="dropdown profile-action">
                                    <a
                                        href="#"
                                        class="action-icon dropdown-toggle"
                                        data-toggle="dropdown"
                                        aria-expanded="false"
                                    ></a>
                                    <div
                                        class="dropdown-menu dropdown-menu-right"
                                        x-placement="bottom-end"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(23px, 27px, 0px);"
                                    >
                                        <a
                                            class="dropdown-item"
                                            href="edit-doctor.html"
                                            ><i class="fa fa-pencil m-r-5"></i>
                                            Edit</a
                                        >
                                        <a
                                            class="dropdown-item"
                                            @click="deletePost(post.id)"
                                            href=""
                                            data-toggle="modal"
                                            data-target="#delete_doctor"
                                            ><i class="fa fa-trash-o m-r-5"></i>
                                            Delete</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="flex text-sm">
                                <span class="mr-2">
                                    <p v-if="post.status == 0">
                                        <i class="fa fa-globe mr-1"></i>Public
                                    </p>
                                    <p v-if="post.status == 1">
                                        <i class="fa fa-users mr-1"></i>Friends
                                    </p>
                                </span>
                                <p>
                                    <i class="fa fa-clock"></i>
                                    {{ post.created_at | moment }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white border shadow p-5 text-xl text-gray-700 font-semibold"
                    >
                        {{ post.body }}
                    </div>
                    <div
                        class="bg-white p-1 rounded-b-lg border shadow flex flex-row flex-wrap"
                    >
                        <like
                            :auth_user_id="user_id"
                            :post_id="post"
                            :check_like_status="check_like"
                        ></like>

                        <!-- <div
                        class="w-1/3 hover:bg-gray-200 border-l-4 border-r- text-center text-xl text-gray-700 font-semibold"
                    >
                        Share
                    </div> -->

                        <comment
                            :auth_user_id="user_id"
                            :post_id="post"
                        ></comment>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "user_id",
        "user",
        "post_id",
        "check_like",
        "like_count",
        "each_comments_count",
        "username",
        "me"
    ],

    data() {
        return {
            body: "",
            status: "",
            id: "",
            posts: [],
            not_working: true
        };
    },

    mounted() {
        this.showPosts();
    },
    methods: {
        showPosts() {
            axios.get("/show/media/" + this.user_id).then(res => {
                console.log(res.data);
                console.log(this.user_id);
                this.posts = res.data;
            });
        },
        deletePost(id) {
            axios.delete("/post/delete/" + id).then(res => {
                this.$toast.error("Post Deleted Successfully", {
                    timeout: 2000
                });
                console.log(res);
                this.showPosts();
            });
        }
    }
};
</script>
