<template>
    <div v-if="photoUrl" class="photo-detail bookimage">
      <figure class="photo-detail__pane photo-detail__image">
        <img :src="photoUrl" alt="">
      </figure>
    </div>
</template>

<script>
    export default {
        data () {
        return {
            photoUrl: null
        }
        },
        methods: {
        // URLから特定のパラメータを取得
        getParam(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        // isbnコードから画像URLを取得
        async fetchPhoto () {
            const isbn =this.getParam('isbn');
            const response = await axios.get('https://api.openbd.jp/v1/get?isbn='+isbn)

            if(response.data[0] == null){
            this.photoUrl = null
            } else {
            this.photoUrl = response.data[0].summary.cover;
            }
        }
        },
        watch: {
        $route: {
            async handler () {
            await this.fetchPhoto()
            },
            immediate: true
        }
        }
    }
</script>
