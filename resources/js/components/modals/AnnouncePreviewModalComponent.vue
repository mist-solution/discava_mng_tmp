<template>
    <v-dialog v-show="display" persistent fullscreen>
        <v-card class="p-3">
            <v-card-header class="modal-header" style="background-color:black">
                <div class="preview_header_logo sp_disable" style="color: white;"> 
                    DISCaVa MATE 
                </div>
                <div class="preview_closeaction" @click="closeAction()">
                    <a class="nav-link active" aria-current="page"><v-icon color="white">mdi-pencil</v-icon></a>
                    <div class="close_button sp_disable">
                    プレビュー画面を閉じる
                    </div>
                    <div class="pc_disable" style="color:white;" v-if="flg">
                    編集画面に戻る
                    </div>
                    <div class="pc_disable" style="color:white;" v-if="!flg">
                    一覧画面に戻る
                    </div>
                </div>
                <div class="preview_publication_period sp_disable" style="color: white;">
                    <a class="nav-link active" aria-current="page"><v-icon color="white">mdi-calendar-month</v-icon></a>
                    掲載期間
                    {{ start_date }} ～ {{ end_date }}
                </div>
                <div class="preview_publication_period_sp pc_disable">
                    <div class=preview_period_toggle_button @click="openPeriod()">
                        <a class="nav-link active" aria-current="page"><v-icon color="white">mdi-calendar-month</v-icon></a>
                        <div style="color:white;">
                            掲載期間
                        </div>
                        <a class="nav-link active" :class="{'period_disable' :open_flg}" aria-current="page"><v-icon color="white">mdi-chevron-right</v-icon></a>
                        <a class="nav-link active" :class="{'period_disable' :!open_flg}" aria-current="page"><v-icon color="white">mdi-chevron-down</v-icon></a>
                    </div>
                    <div class="preview_period" :class="{'period_disable' :!open_flg}">
                    <div style="color:white;">{{ start_date }}<br></div>
                    <div style="color:white;">｜<br></div>
                    <div style="color:white;">{{ end_date }}</div>
                    </div>
                </div>
                <div class="preview_userInfo">
                    <div class="preview_username sp_disable">
                    カテゴリー：
                    </div>
                    <div class="preview_username">
                        {{category}}
                    </div>
                </div>
            </v-card-header>
            <v-card-text>
                <div>
                    {{ title }}
                </div>
                <br>
                <div v-html="contents">
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
  
<script>
    
    export default {
    props: ["display","closeAction","contents","start_date","end_date","title","category","flg"],
    data() {
        return {
            open_flg: false,
        };
    },
    methods: {
        openPeriod(){
            this.open_flg = !this.open_flg;
        }
    },
    };
</script>

<style lang="scss">

.v-dialog--fullscreen .v-overlay__content{
    width: 100% !important;
}

.v-dialog--fullscreen .v-overlay__content .v-card{
    padding: 0px !important;
}

@media(min-width:901px){
    .modal-header{
    align-items: center;
    height: 50px;
    }
}

@media (max-width: 900px){
    .modal-header{
    align-items: flex-start;
    }
}

.preview_publication_period{
    display: flex;
    align-items: center;
}

.preview_closeaction{
    display: flex;
    align-items: center;
    vertical-align:top;
    cursor: pointer;
}

.preview_userInfo{
    display: flex;
    vertical-align:top;
}

.close_button{
    color: white;
}

.preview_username{
    color: white;
}

.preview_period{
    display: flex;
    flex-direction: column;
    align-items: center;
}

.preview_period_toggle_button{
    color: white;
    display: flex;
    cursor: pointer;
}

.period_disable{
    display: none;
}

@media (max-width: 900px){
    .sp_disable{
        display: none;
    }
}

@media (min-width: 901px){
    .pc_disable{
        display: none;
    }
}


</style>

