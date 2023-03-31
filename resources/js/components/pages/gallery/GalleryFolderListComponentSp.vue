<template>
  <!-- タイトル/オープンボタン -->
  <div class="gallery-title-folder" @click="cardOpen = !cardOpen">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">フォルダ管理</p>
    <button
      :class="
        cardOpen ? 'gallery-folder-card-open' : 'gallery-folder-card-close'
      "
    ></button>
  </div>

  <!-- フォルダ管理カード内容表示 -->
  <div v-if="cardOpen">
    <!-- フォルダ検索エリア -->
    <div class="gallery-folder-search-area-sp">
      <div class="gallery-folder-search-container-sp">
        <button type="button" class="gallery-folder-search-icon-sp">
          <v-icon>mdi-magnify</v-icon>
        </button>
        <input
          class="gallery-folder-search-input-sp"
          type="search"
          maxlength="30"
          hide-details="false"
        />
      </div>
      <button class="btn white-btn gallery-folder-search-sort-sp" type="button">
        <span class="mdi mdi-sort-alphabetical-ascending"></span>
      </button>
      <button
        class="green-btn_noTransform px-2 py-1 gallery-folder-add-btn-sp"
        type="button"
      >
        追加
      </button>
    </div>

    <!-- 仕切り線 -->
    <div class="gallery-horizontal-divider"></div>

    <!-- フォルダ一覧表示 -->
    <div class="gallery-folder-show-area-sp">
      <div
        v-for="(item, index) in folder"
        :key="index"
        @click="toggleFolder(item)"
      >
        <!-- 親フォルダ -->
        <div
          v-if="item.isShow && item.parent_folder_id == 0"
          :class="[
            item.isOpen
              ? 'gallery-folder-show-active-sp'
              : 'gallery-folder-show-sp',
          ]"
          @click.stop="toggleFolder(item)"
        >
          <span
            :class="[
              item.isOpen
                ? 'mdi mdi-folder-open'
                : hasChildFolder(item.id)
                ? 'mdi mdi-folder-multiple' // 子フォルダ有り
                : 'mdi mdi-folder', // 子フォルダ無し
            ]"
          ></span>
          <p class="folder-name">{{ item.name }}</p>
          <p class="number">{{ item.fileValue }}</p>
        </div>
        <!-- 子フォルダ -->
        <div v-if="item.isOpen">
          <div
            v-for="(subitem, subindex) in folder"
            :key="subindex"
            :class="[
              subitem.isOpen
                ? 'gallery-sub-folder-show-active-sp'
                : 'gallery-sub-folder-show-sp',
            ]"
            @click.stop="toggleSubFolder(subitem)"
          >
            <!-- <span v-if="item.isShow && subitem.parent_folder_id == item.id">{{
          subitem.name
        }}</span> -->
            <span
              v-if="item.isShow && subitem.parent_folder_id == item.id"
              :class="[
                subitem.isShow && subitem.isOpen
                  ? 'mdi mdi-folder-open'
                  : 'mdi mdi-folder',
              ]"
            ></span>
            <p
              v-if="item.isShow && subitem.parent_folder_id == item.id"
              class="folder-name"
            >
              {{ subitem.name }}
            </p>
            <p
              v-if="item.isShow && subitem.parent_folder_id == item.id"
              class="number"
            >
              {{ subitem.fileValue }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- 名称変更・削除ボタン -->
    <div class="gallery-folder-edit-btn-area-sp">
      <!-- 仕切り線 -->
      <div class="gallery-horizontal-divider"></div>

      <!-- ボタン -->
      <div class="gallery-folder-edit-btn-container-sp">
        <button
          class="btn white-btn gallery-folder-name-edit-btn-sp"
          type="button"
        >
          名称変更
        </button>
        <button
          class="btn white-btn gallery-folder-name-delete-btn-sp"
          type="button"
        >
          削除
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      cardOpen: false,
      folder: [
        {
          id: 1,
          parent_folder_id: 0,
          name: "全てのファイル",
          isShow: false,
          isOpen: false,
          fileValue: 324,
        },
        {
          id: 2,
          parent_folder_id: 0,
          name: "未分類",
          isShow: false,
          isOpen: false,
          fileValue: 8,
        },
        {
          id: 3,
          parent_folder_id: 0,
          name: "ああああああ",
          isShow: false,
          isOpen: false,
          fileValue: 111,
        },
        {
          id: 4,
          parent_folder_id: 3,
          name: "いいい",
          isShow: false,
          isOpen: false,
          fileValue: 73,
        },
        {
          id: 5,
          parent_folder_id: 0,
          name: "おおお",
          isShow: false,
          isOpen: false,
          fileValue: 3,
        },
        {
          id: 6,
          parent_folder_id: 5,
          name: "ううう",
          isShow: false,
          isOpen: false,
          fileValue: 32,
        },
        {
          id: 7,
          parent_folder_id: 5,
          name: "えええ",
          isShow: false,
          isOpen: false,
          fileValue: 32,
        },
      ],
    };
  },
  methods: {
    // 親フォルダか判断
    isParentFolder() {
      this.folder.forEach((folderItem) => {
        if (folderItem.parent_folder_id === 0) {
          folderItem.isShow = true;
        } else {
          folderItem.isShow = false;
        }
      });
    },

    // 親フォルダクリック操作
    toggleFolder(item) {
      // 親フォルダを押下
      item.isOpen = !item.isOpen;

      // 押下されない場合，isOpen = false
      this.folder.forEach((folderItem) => {
        if (folderItem !== item) {
          folderItem.isOpen = false;
        } else if (folderItem.parent_folder_id === 0 && !item.isOpen) {
          folderItem.isOpen = false;
        }
      });

      // 子フォルダがある場合
      if (this.hasChildFolder(item.id)) {
        // 親フォルダが開く場合
        if (item.isOpen) {
          // 子フォルダを表示
          this.folder.forEach((subItem) => {
            if (
              subItem.parent_folder_id !== 0 &&
              subItem.parent_folder_id == item.id
            ) {
              subItem.isShow = true;
            }
          });
        } else if (!item.isOpen) {
          this.folder.forEach((subItem) => {
            if (
              subItem.parent_folder_id !== 0 &&
              subItem.parent_folder_id == item.id
            ) {
              subItem.isShow = false;
            }
          });
        }
      }
    },

    // 子フォルダクリック操作
    toggleSubFolder(subitem) {
      // 子フォルダを押下
      console.log(subitem);
      subitem.isOpen = !subitem.isOpen;
      // 押下されない場合，isOpen = false
      this.folder.forEach((subfolderItem) => {
        if (subfolderItem !== subitem && subfolderItem.parent_folder_id !== 0) {
          subfolderItem.isOpen = false;
        }
      });
    },

    // 子フォルダあるか判断
    hasChildFolder(id) {
      return this.folder.some((item) => item.parent_folder_id === id);
    },

    // フォルダ一覧取得
    getMediaFolder(){
      axios.get("api/mediafolder")
        .then((res) => {
          this.folder = res.data.mediaFolder;
          this.isParentFolder();
        });
    },
  },

  async mounted() {
    this.getMediaFolder();
  },
};
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
@media (max-width: 640px) {
  /* タイトル/オープンボタン */
  /* カードオープン */
  .gallery-folder-card-open,
  .gallery-folder-card-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    color: #fff;
    border-radius: 50%;
    background-color: #919191;
    cursor: pointer;
  }

  .gallery-folder-card-open::before {
    content: "－";
  }

  .gallery-folder-card-close::before {
    content: "＋";
  }

  /* フォルダ検索エリア */
  .gallery-folder-search-area-sp {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
  }
  .gallery-folder-search-container-sp {
    display: flex;
    align-items: center;
    width: 60%;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 4px;
    height: 2.5rem;
  }

  .gallery-folder-search-input-sp {
    font-size: 16px !important;
    height: 2rem;
    border: none;
    outline: none;
    width: 85%;
  }

  .gallery-folder-search-icon-sp {
    background-color: transparent;
    border: none;
    outline: none;
    margin-right: 5px;
    color: rgba(0, 0, 0, 0.2);
  }

  .gallery-folder-search-sort-sp {
    font-size: 22px;
    padding: 0px 5px;
    margin-left: -5%;
  }
  /* タイトルエリア（追加ボタン） */
  .gallery-folder-add-btn-sp {
    width: 20%;
  }

  /* 親フォルダ名初期表示スタイル */
  .gallery-folder-show-area-sp {
    overflow-x: hidden;
    overflow-y: auto !important;
    height: 20vh;
  }
  .gallery-folder-show-sp {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #9f9f9f;
    font-size: 16px;
    line-height: 2rem;
    margin: 5px 0;
  }
  .gallery-folder-show-sp span {
    color: #9f9f9f;
    font-size: 22px;
  }
  .gallery-folder-show-sp .folder-name {
    font-size: 16px;
    padding-left: 5px;
    width: -webkit-fill-available;
  }
  .gallery-folder-show-sp .number {
    text-align: right;
    background-color: #f0f0f0;
    border-radius: 5px;
    width: fit-content;
    padding: 5px;
    font-size: 12px;
    line-height: initial;
  }

  /* 選択された親フォルダスタイル */
  .gallery-folder-show-active-sp {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #69a4af;
    font-size: 16px;
    line-height: 2rem;
    margin: 5px -10px;
    background-color: #f5f9fa;
    border-right: 10px solid #f5f9fa;
    border-left: 10px solid #f5f9fa;
    border-radius: 5px;
  }
  .gallery-folder-show-active-sp span {
    color: #69a4af;
    font-size: 22px;
  }
  .gallery-folder-show-active-sp .folder-name {
    font-size: 16px;
    padding-left: 5px;
    width: -webkit-fill-available;
  }
  .gallery-folder-show-active-sp .number {
    text-align: right;
    background-color: #fff;
    color: #9f9f9f;
    border-radius: 5px;
    width: fit-content;
    padding: 5px;
    font-size: 12px;
    line-height: initial;
  }

  /* 子フォルダ名初期表示スタイル */
  .gallery-sub-folder-show-sp {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #9f9f9f;
    font-size: 16px;
    line-height: 2rem;
    margin: 5px 0;
    margin-left: 1.5rem;
    margin-top: -0.3rem;
  }
  .gallery-sub-folder-show-sp span {
    color: #9f9f9f;
    font-size: 22px;
  }
  .gallery-sub-folder-show-sp .folder-name {
    font-size: 16px;
    padding-left: 5px;
    width: -webkit-fill-available;
  }
  .gallery-sub-folder-show-sp .number {
    text-align: right;
    background-color: #f0f0f0;
    border-radius: 5px;
    width: fit-content;
    padding: 5px;
    font-size: 12px;
    line-height: initial;
  }

  /* 選択された親フォルダスタイル */
  .gallery-sub-folder-show-active-sp {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #69a4af;
    font-size: 16px;
    line-height: 2rem;
    margin: 5px -10px;
    background-color: #f5f9fa;
    border-right: 10px solid #f5f9fa;
    border-left: 10px solid #f5f9fa;
    border-radius: 5px;
    margin-left: 1rem;
    margin-top: -0.3rem;
  }
  .gallery-sub-folder-show-active-sp span {
    color: #69a4af;
    font-size: 22px;
  }
  .gallery-sub-folder-show-active-sp .folder-name {
    font-size: 16px;
    padding-left: 5px;
    width: -webkit-fill-available;
  }
  .gallery-sub-folder-show-active-sp .number {
    text-align: right;
    background-color: #fff;
    color: #9f9f9f;
    border-radius: 5px;
    width: fit-content;
    padding: 5px;
    font-size: 12px;
    line-height: initial;
  }

  /* フォルダ名初期表示スタイル */
  .gallery-folder-show-sp {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #9f9f9f;
    font-size: 16px;
    line-height: 2rem;
    margin: 5px 0;
  }
  .gallery-folder-show-sp span {
    color: #9f9f9f;
    font-size: 22px;
  }
  .gallery-folder-show-sp .folder-name {
    font-size: 16px;
    padding-left: 5px;
    width: -webkit-fill-available;
  }
  .gallery-folder-show-sp .number {
    text-align: right;
    background-color: #f0f0f0;
    border-radius: 5px;
    width: fit-content;
    padding: 5px;
    font-size: 12px;
    line-height: initial;
  }

  /* 名称変更・削除バタン */
  .gallery-folder-edit-btn-area-sp {
    position: initial;
  }
  .gallery-folder-edit-btn-container-sp {
    display: flex;
    justify-content: space-between;
  }
  .gallery-folder-name-edit-btn-sp {
    margin-left: 0.5rem;
    width: 63%;
  }
  .gallery-folder-name-delete-btn-sp {
    width: 33%;
    margin-right: 0.5rem;
    margin-left: 0.5rem;
  }
}
</style>