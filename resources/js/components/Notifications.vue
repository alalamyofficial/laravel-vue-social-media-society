<template>
    <li class="nav-item dropdown" style="right: 18px;">
        <a
            id="navbarDropdown"
            class="nav-link"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <div class="flex">
                
                <i class="fa fa-bell mt-1" style="color:#468adf"></i> 

                <span id="notify_num" v-show="unreadnotifications.length > 0">
                    <sup
                        ><big>
                            <span class="badge bg-danger">
                                <b style="color:white">{{ unreadnotifications.length }}</b>
                            </span>
                            
                        </big
                        >
                    </sup
                    >
                </span>
            </div>
        </a>

        <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="navbarDropdown"
        >
            <a
                class="dropdown-item"
                v-show="unreadnotifications.length > 0"
                @click="markAsRead"
                >Mark all as read!</a
            >
            <!-- <hr /> -->
            <a
                class="dropdown-item"
                v-for="(unread, index) in unreadnotifications"
                :key="index"
                @click="showNotifications()"
                ><hr />
                <a><b>{{ unread.data.username }}</b> {{ unread.data.message }}</a>
            </a>
            <a class="dropdown-item" v-show="unreadnotifications.length == 0"
                >No new notifications</a
            >
        </div>
    </li>
</template>

<script>
export default {
    mounted() {
        this.getNotifications();
        this.interval = setInterval(
            function() {
                this.getNotifications();
            }.bind(this),
            500
        );
    },
    props: ['user'],
    data() {
        return {
            unreadnotifications: {},
            // user:''
        };
    },
    methods: {
        getNotifications() {
            axios
                .get("/unreadNotifications",{
                    params: {
                        user: this.user
                    }
                })
                .then(response => {
                    this.unreadnotifications = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        markAsRead() {
            axios
                .get("/markAsRead",{
                    params: {
                        user: this.user
                    }
                })
                .then(response => {
                    location.reload();
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        showNotifications() {
            this.markAsRead();
            location.href = "/";
        }
    }
};
</script>