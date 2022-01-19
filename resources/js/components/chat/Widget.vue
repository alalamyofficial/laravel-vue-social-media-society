<template>
  <div>
    <div class="container">
      <h3
        class="text-center mb-3 mt-5 mx-auto p-2 shadow-sm"
        style="width:200px; text-align:center; border-radius:50px; 
        background-color: aliceblue; font-family: cursive;"
      >Chaty</h3>
      <div class="messaging shadow-lg">
        <div class="inbox_msg">
          <div class="inbox_people">
            <div class="headind_srch">
              <div class="recent_heading">
                <h4>Recent ({{users_count}})</h4>
              </div>
              <div class="srch_bar">
                <div class="stylish-input-group">
                  <input
                    type="text"
                    class="search-bar form-control"
                    v-model="search"
                    placeholder="Search"
                  />
                  <span class="input-group-addon"></span>
                </div>
              </div>
            </div>
            <div class="inbox_chat">
              <div class="chat_list shadow-sm" v-for="user in getfilteredData" :key="user.id">
                <div @click="selectUser(user.id)">
                  <div class="chat_people">
                    <div class="chat_img">
                      <img :src="user.avatar" class="rounded-circle" alt="sunil" />
                    </div>
                    <div class="chat_ib">
                      <h5 class="mt-2">
                        {{user.name}}
                        <span
                          v-if="onlineUser(user.id) || online.id==user.id"
                          class="chat_date badge bg-success"
                        >online</span>
                        <span v-else class="chat_date badge bg-danger">offline</span>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
              <!-- </div>   -->
            </div>
          </div>
          <div class="mesgs">
            <div class="msg_history">
              <div class="d-flex">
                <img
                  v-if="userMessage.user"
                  :src="userMessage.user.avatar"
                  width="30px"
                  alt="sunil"
                  class="rounded-circle mr-3 ml-2"
                />
                <h6 class="mt-2 ml-5" v-if="userMessage.user">{{userMessage.user.name}}</h6>
              </div>
              <br />
              <hr />

              <div class="outgoing_msg" v-for="msg in userMessage.messages" :key="msg.id">
                <div class="sent_msg">
                  <div class="flex">
                    <div class="incoming_msg_img"></div>
                    <div class="row">
                      <div class="justify-content-around">
                        <p
                          :class="`${msg.user.id == userMessage.user.id ? 'bg-black shadow' : 'bg-gray shadow' }`"
                        >
                          {{msg.message}}
                          <a
                            v-if="msg.user.id != userMessage.user.id"
                            @click="deleteMessage(msg.id)"
                            title="Msg Will Delete From Only U"
                          >
                            <i class="fa fa-trash ml-3 mr-3"></i>
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <span class="time_date">{{msg.created_at | moment}} | {{msg.user.name}}</span>
                </div>
              </div>
            </div>
            <div class="type_msg">
              <div class="input_msg_write">
                <input
                  type="text"
                  v-if="userMessage.user"
                  class="write_msg form-control"
                  @keydown.enter="sendMessage"
                  v-model="message"
                  placeholder="Type a message"
                />
                <button v-if="userMessage.user" class="msg_send_btn" type="button">
                  <i  @click="sendMessage" class="fas fa-paper-plane fa-1x"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <p class="text-center top_spac">
          Back To
          <a href="/home">Home</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  props: ["users", "users_count", "one_user", "friend"],
  data() {
    return {
      message: "",
      messages: [],
      search: "",
      online: "",
      liveusers: []
    };
  },
  mounted() {
    Echo.private(`chat.${authuser.id}`).listen("MessageSend", e => {
      this.selectUser(e.message.from);
      // console.log(e.message.message);
    });
    console.log(this.messages);
    this.$store.dispatch("userList");

    Echo.join("liveuser")
      .here(users => {
        this.liveusers = users;
      })
      .joining(user => {
        this.online = user;
        console.log(user.name);
      })
      .leaving(user => {
        console.log(user.name);
      });
  },
  computed: {
    userList() {
      return this.$store.getters.userList;
    },
    userMessage() {
      return this.$store.getters.userMessage;
    },
    getfilteredData() {
      return this.users.filter(user =>
        user.name.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  },
  methods: {
    selectUser(userId) {
      this.$store.dispatch("userMessage", userId);
      console.log(userId);
    },
    sendMessage(e) {
      e.preventDefault();

      if (this.message != "") {
        axios
          .post("/sendMessage", {
            message: this.message,
            user_id: this.userMessage.user.id
          })
          .then(response => {
            this.selectUser(this.userMessage.user.id);
            console.log(response.data);
          });
        this.message = "";
      }
    },
    deleteMessage(msgId) {
      axios.get(`/delete/message/${msgId}`).then(response => {
        this.selectUser(this.userMessage.user.id);
      });
    },
    onlineUser(userId) {
      return _.find(this.liveusers, { id: userId });
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 1170px;
  margin: auto;
}
img {
  max-width: 100%;
}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%;
  border-right: 1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac {
  margin: 20px 0 0;
}

.recent_heading {
  float: left;
  width: 40%;
}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch {
  padding: 10px 29px 10px 20px;
  overflow: hidden;
  border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input {
  border: 1px solid #cdcdcd;
  border-width: 0 0 1px 0;
  width: 80%;
  padding: 2px 0 4px 6px;
  background: none;
}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon {
  margin: 0 0 0 -27px;
}

.chat_ib h5 {
  font-size: 15px;
  color: #464646;
  margin: 0 0 8px 0;
}
.chat_ib h5 span {
  font-size: 13px;
  float: right;
}
.chat_ib p {
  font-size: 14px;
  color: #989898;
  margin: auto;
}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people {
  overflow: hidden;
  clear: both;
}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat {
  height: 550px;
  overflow-y: scroll;
}

.active_chat {
  background: #ebebeb;
}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
}
.received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg {
  width: 57%;
}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

.sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0;
  color: #fff;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.outgoing_msg {
  overflow: hidden;
  margin: 26px 0 26px;
}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {
  border-top: 1px solid #c4c4c4;
  position: relative;
}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging {
  padding: 0 0 50px 0;
}
.msg_history {
  height: 516px;
  overflow-y: auto;
}

.chat_selected {
  background-color: aliceblue;
}
</style>