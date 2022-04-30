<template>
  <v-row v-for="item in news" :key="item.id" dense>
    <v-col>
      <v-card>
        <v-row>
          <v-col :cols="1">
            <v-img
              :src=item.imageUrl
              height="125"
              width="175"
              class="bg-grey-lighten-2"
            ></v-img>
          </v-col>
          <v-col :cols="11">
            <v-row>
              <v-col class="mt-3">
                <v-card-subtitle class="ml-2">{{
                  item.publishStatus
                }}</v-card-subtitle>
                <v-card-title class="ml-2">{{ item.title }}</v-card-title>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-card-text>登録日：{{ item.createdAt }}</v-card-text>
              </v-col>
              <v-col>
                <v-card-text>更新日：{{ item.updatedAt }}</v-card-text>
              </v-col>
              <v-col>
                <v-card-text>更新者：{{ item.author }}</v-card-text>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      news: [
        {
          id: 1,
          publishStatus: "公開中",
          title: "新商品入荷のお知らせ",
          category: "お知らせ",
          createdAt: "2022/01/01 12:00",
          updatedAt: "2022/01/01 12:00",
          author: "名無しの権兵衛",
          imageUrl: "https://3.bp.blogspot.com/-uc9Tkzpk73E/XGjzEs6LazI/AAAAAAABRlw/LJgreYChlFEL6iKTRfu7w09P2jIw0TUHQCLcBGAs/s800/party_highball_man.png",
        },
        {
          id: 2,
          publishStatus: "公開期間 20XX/XX/XX ～ 20YY/YY/YY",
          title: "新商品入荷のお知らせ",
          category: "お知らせ",
          createdAt: "2022/01/01 12:00",
          updatedAt: "2022/01/01 12:00",
          author: "名無しの権兵衛",
          imageUrl: "https://4.bp.blogspot.com/-kUIhHrSkCv0/VwIdUtMJO_I/AAAAAAAA5Xc/Rq6W0mU3X38JzC6Yruts5mv5wlJ2JeP4w/s800/yopparai_businessman.png",
        },
      ],
    };
  },
};
</script>