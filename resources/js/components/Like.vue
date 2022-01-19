<template>
  <div class="w-1/4 hover:bg-gray-200 text-center text-xl text-gray-700 font-semibold">
    <!-- <a href="" @click.prevent="likeIt">
            <small>{{ likeCount }}</small>
            <i class="fa fa-thumbs-up" v-if="likeCount == 0" aria-hidden="true"></i>
            <i class="fa fa-thumbs-up" style="color:red" v-else-if="likeCount > 0 " aria-hidden="true"></i>
    </a>-->

    <!-- <div v-if="isLiked">
      <button @click="like">
        <b class="mr-2">Like</b>
        <small>({{likeCount}})</small>
      </button>
    </div>

    <div v-if="!isLiked">
      <button @click="unlike">
        <b class="mr-2 text-blue-500">Unlike</b>
        <small>({{likeCount}})</small>
      </button>
    </div> -->

    <li class="list-inline-item g-mr-20">
        <a @click.prevent="like" class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover">
            <i class="fa fa-thumbs-up g-pos-rel g-top-1 g-mr-3" v-if="likeCount == 0"></i>
            <i class="fa fa-thumbs-up" style="color:red" 
            v-else aria-hidden="true"></i>

            {{likeCount}}
        </a>
    </li>


  </div>
</template>

<script>
export default {

  data(){

     return{
         likeCount:0
     } 

  }, 

  props:["one_post"],  

  methods: {
    like() {
      axios.get("/like/" + this.one_post.id).then(res => {
        console.log(res);
        if (res.data == "deleted") {
          this.likeCount -= 1;
        } else {
          this.likeCount += 1;
        }
      });
    }
  }
};

// let isLiked = false

// export default {
//     // like_classes() {
//     //     return ['.btn', this.isLiked ? "btn-info btn-sm mr-2" :  "btn-secondary btn-sm mr-2"];
//     // },

//     props: ["post_id", "auth_user_id", "id", "check_like_status"],

//     data() {
//         return {
//             // like:{},
//             posts: [],
//             isLiked: true,
//             status:["liked"],
//             likeCount : 0
//         };
//     },

//     methods: {
//         toggleLike() {
//             if(this.isLiked = true){
//                 this.like()
//                 this.isLiked = false
//             }else{
//                 this.unlike()
//                 this.isLiked = true
//             }
//             // this.isLiked ? this.unlike() : this.like();
//             // if (isLiked) {
//             //     this.like();
//             //     this.isLiked = false;
//             // } else {
//             //     this.unlike();
//             //     this.isLiked = true;
//             // }

//             // console.log(isLiked);

//         },

//         like() {
//             this.isLiked = true;
//             // this.status = 'liked'
//             axios.post("/like/" + this.post_id.id).then(res => {
//                 this.isLiked = false;
//                 this.likeCount++
//                 // this.status = 'unliked'
//                 console.log(res.data);
//             });
//         },
//         unlike() {
//             this.isLiked = false;
//             // this.status = 'unliked'
//             axios.delete("/unlike/" + this.post_id.id).then(res => {
//                 this.isLiked = true;
//                 this.likeCount--
//                 // this.status = 'liked'
//                 console.log(res.data);
//             });
//         },
//         likeIt(){
//             // if (this.login) {
//                 axios.post('/like/'+this.post_id.id,{
//                     // id : this.post_id.id
//                 })
//                     .then(response => {
//                     if (response.data == 'deleted') {
//                         this.likeCount -= 1;
//                         console.log(response.data)
//                     }else{
//                         this.likeCount += 1;
//                         console.log(response.data)

//                     }
//                     // this.blog = response.data.data
//                     // console.log(response);
//                     })
//                     .catch(function (error) {
//                         console.log(error);
//                     });
//             // }else{
//             //     window.location = 'login'
//             // }
//         }

//     },
//     // mounted() {
//     //     axios
//     //         .get("/status/" + this.post_id.id)
//     //         .then(response => {
//     //             console.log(response);
//     //             this.status = response.data.status;
//     //         });
//     // }
// };
</script>
