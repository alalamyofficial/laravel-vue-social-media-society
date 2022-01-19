<template>
  <div>
    <div
      class="w-1/2 hover:bg-gray-200 border-l-4 mr-1 ml-1 mb-5 pr-5 pl-5 text-center text-xl text-gray-700 font-semibold"
    >
      <a data-target="#comments" data-toggle="collapse">
        <div class="flex">
          <b class="mr-2">Comment</b>
          <p>({{comment_count}})</p>
        </div>
      </a>
    </div>

    <div class="collapse" id="comments">
      <div style=" width:720px">
        <form @submit.prevent="saveComments">
          <div class="input-group mb-3 col-12">
            <input
              name="comment"
              type="text"
              class="form-control"
              placeholder="Write a Comment"
              v-model="comment"
            />

            <div class="input-group-append flex">
              <button
                class="btn btn-outline-secondary"
                type="button"
                @click.prevent="saveComments"
                :disabled="!comment"
              >
                <!-- <i class="fa fa-paper-plane" aria-hidden="true"></i> -->
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </form>
        <!-- show comments -->
        <div v-if="comments.length">
          <div v-for="comment in comments" :key="comment.id">
            <div class="container mt-5 mb-2">
              <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                  <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="user d-flex flex-row align-items-center">
                        <div class="flex justify-content-between">
                          <div class="d-flex mr-16">
                            <a href>
                              <img
                                :src="
                                    comment.user.avatar
                                "
                                width="40"
                                class="user-img rounded-circle mr-3"
                              />
                            </a>
                            <a
                              :href="
                                    /profile/ + comment.user.username
                                "
                              class="font-weight-bold text-primary text-sm"
                              style="width: 145px;"
                            >
                              {{
                              comment.user
                              .name
                              }}
                            </a>
                          </div>

                          <div class="mx-6" v-if="comment.user.id == user_id">
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
                                  data-toggle="modal"
                                  data-target="#exampleModal2"
                                  @click="editComment(comment.id)"
                                >
                                  <i class="fa fa-pencil m-r-5"></i>
                                  Edit
                                </a>
                                <a
                                  class="dropdown-item"
                                  @click="deleteComment(comment.id)"
                                  href
                                  data-toggle="modal"
                                  data-target="#delete_doctor"
                                >
                                  <i class="fa fa-trash-o m-r-5"></i>
                                  Delete
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                      <small class="font-weight-bold">
                        {{
                        comment.comment
                        }}
                      </small>
                    </div>

                    <!-- form for edit comment -->
                    <div
                      class="modal fade"
                      id="exampleModal2"
                      tabindex="-1"
                      role="dialog"
                      aria-labelledby="exampleModalLabel"
                      aria-hidden="true"
                    >
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
                            <button
                              type="button"
                              class="close"
                              data-dismiss="modal"
                              aria-label="Close"
                            >
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form @submit.prevent="saveComments">
                              <div class="input-group mb-3 col-12">
                                <input
                                  name="comment"
                                  type="text"
                                  class="form-control"
                                  placeholder="Write a Comment"
                                  v-model="edit_comment"
                                />

                                <div class="input-group-append flex">
                                  <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    @click.prevent="updateComments"
                                    data-dismiss="modal"
                                  >
                                    <!-- <i class="fa fa-paper-plane" aria-hidden="true"></i> -->
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                  </button>
                                </div>
                              </div>
                              <pre class="ml-3">{{comment.comment}}</pre>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["post_id", "user_id"],

  data() {
    return {
      comment: "",
      edit_comment: "",
      status: "",
      id: "",
      comments: [],
      not_working: true,
      comment_count: ""
    };
  },

  mounted() {
    setTimeout(() => {
      this.showComments();
      this.commentsCount();
    }, 3000);
    setTimeout(() => {
      this.commentsCount();
    }, 1000);
  },

  methods: {
    saveComments() {
      axios
        .post("/comment/store/" + this.post_id.id, {
          user_id: this.user_id,
          comment: this.comment
        })
        .then(res => {
          this.comment = "";
          console.log(res.data);
          this.showComments();
          this.$toast.success("Comment Created Successfully", {
            timeout: 4000
          });
        })
        .then(err => {
          console.log(err);
        });
    },
    showComments() {
      axios
        .get("/getComments/" + this.post_id.id)
        .then(res => {
          console.log(res.data);
          this.comments = res.data;
        })
        .catch(errors => {
          console.log(errors);
        });
    },

    editComment(id) {
      axios.get("edit/comment/" + id).then(res => {
        console.log(res);
        this.id = res.data.id;
        this.edit_comment = res.data.edit_comment;
      });
    },

    updateComments() {
      axios
        .put("update/comment", {
          id: this.id,
          comment: this.edit_comment
        })
        .then(res => console.log(res))
        .then(res => {
          this.showComments();
          this.$toast.info("Comment Updated Successfully", {
            timeout: 4000
          });
        });
    },

    deleteComment(id) {
      axios.delete("/comment/" + id).then(res => {
        console.log(res);
        this.showComments();
        this.$toast.error("Comment Deleted Successfully", {
          timeout: 4000
        });
      });
    },
    commentsCount() {
      axios.get("/comments/count/" + this.post_id.id).then(response => {
        this.comment_count = response.data;
      });
    }
  }
};
</script>

<style scoped>
.mx-6 {
  margin-left: 26.5rem;
  margin-right: 1.5rem;
}
</style>