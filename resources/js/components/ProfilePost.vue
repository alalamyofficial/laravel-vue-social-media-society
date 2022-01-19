<template>
    <div>
        <form @submit.prevent="savePosts" v-if="me == user_id">
            <div id="app" class="bg-white w-full shadow rounded-lg p-5 mb-2">
                <textarea
                    class="bg-gray-200 w-full rounded-lg shadow border p-2 mb-1"
                    name="body"
                    v-model="body"
                    rows="5"
                    placeholder="Speak your mind"
                    id="myTextArea"
                    data-emoji-picker="true"
                ></textarea>

                <emoji-picker @emoji="insert" :search="search">
                    <div
                        class="emoji-invoker"
                        slot="emoji-invoker"
                        slot-scope="{ events: { click: clickEvent } }"
                        @click.stop="clickEvent"
                    >
                        <svg
                            height="24"
                            viewBox="0 0 24 24"
                            width="24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"
                            />
                        </svg>
                    </div>
                    <div
                        slot="emoji-picker"
                        slot-scope="{ emojis, insert, display }"
                    >
                        <div
                            class="emoji-picker"
                            :style="{
                                top: display.y + 'px',
                                left: display.x + 'px'
                            }"
                        >
                            <div class="emoji-picker__search">
                                <input type="text" v-model="search" />
                            </div>
                            <div>
                                <div
                                    v-for="(emojiGroup, category) in emojis"
                                    :key="category"
                                >
                                    <h5>{{ category }}</h5>
                                    <div class="emojis">
                                        <span
                                            v-for="(emoji,
                                            emojiName) in emojiGroup"
                                            :key="emojiName"
                                            @click="insert(emoji)"
                                            :title="emojiName"
                                            >{{ emoji }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </emoji-picker>

                <div class="form-group mt-3 mb-2">
                    <div class="form-group">
                        <div v-if="images" class="mt-3">
                            <img
                                :src="images"
                                class="figure-img img-fluid rounded shadow-lg"
                                style="max-height:100px;"
                            />
                        </div>
                        <label for="images"></label>
                        <input
                            type="file"
                            id="images"
                            @change="imageSelected"
                        />
                        <br />
                    </div>
                </div>

                <div class="w-full flex flex-row flex-wrap mt-3">
                    <div class="w-1/3">
                        <select
                            v-model="status"
                            class="w-full p-2 rounded-lg bg-gray-200 shadow border float-left"
                            name="status"
                        >
                            <option :value="0"
                                ><i class="fa fa-globe"></i>Public</option
                            >
                            <option :value="1"
                                ><i class="fa fa-user-friends"></i
                                >Friends</option
                            >
                        </select>
                    </div>
                    <div class="w-2/3">
                        <button
                            type="button"
                            class="float-right bg-indigo-400 hover:bg-indigo-300 text-white p-2 rounded-lg"
                            @click.prevent="savePosts"
                        >
                            <!-- :disabled="not_working" -->
                            Submit
                        </button>
                    </div>
                </div>
            </div>
            <br />
            <hr />
        </form>

        <div v-else>
            <h2 class="mb-3">Timeline</h2>
            <hr />
        </div>

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
                                <div class="dropdown profile-action" style="right: 20px;">
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

                        <div
                            class="w-1/3 hover:bg-gray-200 border-l-4 border-r- text-center text-xl text-gray-700 font-semibold"
                        >
                            <!-- Share -->
                            <ShareNetwork
                                network="twitter"
                                :url="'127.0.0.1:8000/' + post.images"
                                :title="post.body"
                                :description="post.images"
                            >
                                Share on Twitter
                            </ShareNetwork>
                        </div>

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
import { VEmojiPicker } from "v-emoji-picker";

import "emoji-picker-element";

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
            not_working: true,
            likeCount: 0,
            success: "",
            image: "",
            images: "",
            imagepreview: "",
            post_images: "",
            search: ""
        };
    },

    mounted() {
        this.showPosts();
    },

    methods: {
        insert(emoji) {
            this.body += emoji;
        },

        imageSelected(e) {
            this.image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.image);
            reader.onload = e => {
                this.images = e.target.result;
            };
        },

        savePosts() {
            let config = {
                headers: { "Content-Type": "multipart/form-data" }
            };
            let formData = new FormData();

            var imagefile = document.querySelector("#images");
            formData.append("images", imagefile.files[0]);

            formData.append("user_id", this.user_id);
            formData.append("body", this.body);
            formData.append("status", this.status);

            axios.post("/save/posts", formData, config).then(res => {
                this.images = "";
                this.body = "";
                this.showPosts();
                this.$toast.success("Post Created Successfully", {
                    timeout: 3000
                });
            });
        },

        showPosts() {
            axios.get("/posts/" + this.user_id).then(res => {
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
    },
    watch: {
        content() {
            if (this.body.length > 0) this.not_working = false;
            else this.not_working = true;
        }
    }
};
</script>

<style>
.wrapper {
    position: relative;
    display: inline-block;
}

.regular-input {
    padding: 0.5rem 1rem;
    border-radius: 3px;
    border: 1px solid #ccc;
    width: 20rem;
    height: 12rem;
    outline: none;
}

.regular-input:focus {
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
}

.emoji-invoker {
    position: relative;
    top: 0.5rem;
    right: 0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
    left: 880px;
    top: -120px;
}
.emoji-invoker:hover {
    transform: scale(1.1);
}
.emoji-invoker > svg {
    fill: #b1c6d0;
}

.emoji-picker {
    /* position: relative; */
    z-index: 1;
    font-family: Montserrat;
    border: 1px solid #ccc;
    width: 15rem;
    height: 20rem;
    overflow: scroll;
    padding: 1rem;
    box-sizing: border-box;
    border-radius: 0.5rem;
    background: #fff;
    box-shadow: 1px 1px 8px #c7dbe6;
    left: 910px;
}
.emoji-picker__search {
    display: flex;
}
.emoji-picker__search > input {
    flex: 1;
    border-radius: 10rem;
    border: 1px solid #ccc;
    padding: 0.5rem 1rem;
    outline: none;
}
.emoji-picker h5 {
    margin-bottom: 0;
    color: #b1b1b1;
    text-transform: uppercase;
    font-size: 0.8rem;
    cursor: default;
}
.emoji-picker .emojis {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.emoji-picker .emojis:after {
    content: "";
    flex: auto;
}
.emoji-picker .emojis span {
    padding: 0.2rem;
    cursor: pointer;
    border-radius: 5px;
}
.emoji-picker .emojis span:hover {
    background: #ececec;
    cursor: pointer;
}
</style>
