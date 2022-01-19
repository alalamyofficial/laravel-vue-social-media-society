/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

Vue.use(Toast);

// import  {routes} from './router'
// require('./router')


import moment from "moment";

Vue.filter("moment", function(date) {
    return moment().format('ddd, hA');
    // return moment()
    //     .startOf("hour")
    //     .fromNow();
});

import "viewerjs/dist/viewer.css";
import VueViewer from "v-viewer";
Vue.use(VueViewer);


import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

Vue.use(ViewUI);

import Vuex from 'vuex'
Vue.use(Vuex)

import storeVuex from './store/index'

const store = new Vuex.Store(storeVuex)

// import { ValidationProvider } from 'vee-validate';

// Vue.component('ValidationProvider', ValidationProvider);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component("friendship", require("./components/Friendship.vue").default);
Vue.component("profile-post", require("./components/ProfilePost.vue").default);
Vue.component("feed", require("./components/TimelinePost.vue").default);
Vue.component("like", require("./components/Like.vue").default);
Vue.component("comment", require("./components/Comment.vue").default);
Vue.component(
    "user-settings",
    require("./components/UserSettings.vue").default
);
Vue.component("about", require("./components/About.vue").default);
Vue.component("sidebar", require("./components/Sidebar.vue").default);
Vue.component("rand-friends", require("./components/RandFriends.vue").default);
Vue.component("quotes", require("./components/Quotes.vue").default);
Vue.component("media", require("./components/Media.vue").default);
Vue.component("profile-pic", require("./components/ProfilePic.vue").default);
Vue.component("game", require("./components/Game.vue").default);

// chat
Vue.component("chat-widget", require("./components/chat/Widget.vue").default);


Vue.component("notifications", require("./components/Notifications.vue").default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from "vue-router";
Vue.use(VueRouter);

import { EmojiPickerPlugin } from 'vue-emoji-picker'
Vue.use(EmojiPickerPlugin)


import VueSocialSharing from 'vue-social-sharing'
Vue.use(VueSocialSharing);


require('vue2-animate/dist/vue2-animate.min.css')



import Turbolinks from "turbolinks";

document.addEventListener("turbolinks:load", () => {
    const app = new Vue({
        el: "#app",
        store


        // render: h => h(app),
    });
});

Turbolinks.start();
