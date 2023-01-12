<template>
    <v-dialog v-show="display" persistent fullscreen>
        <v-card class="p-3">
            <v-card-header class="modal-header" style="background-color:black">
                <div class="preview_header_logo"> 
                    DISCaVa MATE 
                </div>
                <div class="preview_closeaction" @click="closeAction()" v-if="close_flg">
                    <a class="nav-link active" aria-current="page" @click="setting"><v-icon>mdi-pencil</v-icon></a>
                    編集画面に戻る
                </div>
                <div class="preview_closeaction" @click="closeAction()" v-if="!close_flg">
                    <a class="nav-link active" aria-current="page" @click="setting"><v-icon>mdi-pencil</v-icon></a>
                    記事一覧画面に戻る
                </div>
                <div class="preview_publication_period">
                    <a class="nav-link active" aria-current="page" @click="setting"><v-icon>mdi-calendar-month</v-icon></a>
                    掲載期間
                    {{ start_date }} ～ {{ end_date }}
                </div>
                <div class="userInfo">
                    {{ username }}
                    
                </div>
            </v-card-header>
            <v-card-text>
                <div v-html="contents">
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
  
<script>
    
    export default {
    props: ["display","closeAction","close_flg","contents","start_date","end_date","username"],
    data() {
        return {
        };
    },
    methods: {
    },
    };
</script>