<template>
  <!-- タイトル -->
  <div class="gallery-title-folder">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">フォルダ管理</p>
    <button
      class="green-btn_noTransform px-2 py-1 gallery-folder-add-btn"
      type="button"
      @click="registerbtn()"
    >
      追加
    </button>
  </div>

  <!-- フォルダ検索エリア -->
  <div class="gallery-folder-search-area">
    <div class="gallery-folder-search-container">
      <button type="button" class="gallery-folder-search-icon">
        <v-icon>mdi-magnify</v-icon>
      </button>
      <input
        class="gallery-folder-search-input"
        type="search"
        maxlength="30"
        hide-details="false"
      />
    </div>
    <button class="btn white-btn gallery-folder-search-sort" type="button">
      <span class="mdi mdi-sort-alphabetical-ascending"></span>
    </button>
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- フォルダ一覧表示 -->
  <div class="gallery-folder-show-area">
    <div
      v-for="(item, index) in folder"
      :key="index"
      @click="toggleFolder(item)"
    >
      <!-- 親フォルダ -->
      <div
        v-if="item.isShow && item.parent_folder_id == 0"
        :class="[
          item.isOpen ? 'gallery-folder-show-active' : 'gallery-folder-show',
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
              ? 'gallery-sub-folder-show-active'
              : 'gallery-sub-folder-show',
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
        <div
          v-if="
            item.isShow &&
            regist_flg &&
            item.parent_folder_id == 0 &&
            index !== 1 &&
            index !== 0
          "
          class="gallery-sub-folder-show"
        >
          <span class="mdi mdi-folder"></span>
          <input
            class="gallery-folder-search-input"
            type="search"
            maxlength="30"
            hide-details="false"
          />
        </div>
      </div>
    </div>
    <div v-if="parent_folder_regist_flg" class="gallery-folder-show">
      <span class="mdi mdi-folder"></span>
      <input
        class="gallery-folder-search-input"
        type="search"
        maxlength="30"
        hide-details="false"
      />
    </div>
  </div>

  <!-- 名称変更・削除ボタン -->
  <div class="gallery-folder-edit-btn-area">
    <!-- 仕切り線 -->
    <div class="gallery-horizontal-divider"></div>

    <!-- ボタン -->
    <div class="gallery-folder-edit-btn-container">
      <button class="btn white-btn gallery-folder-name-edit-btn" type="button">
        名称変更
      </button>
      <button
        class="btn white-btn gallery-folder-name-delete-btn"
        type="button"
      >
        削除
      </button>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      folder: [],
      regist_flg: false,
      parent_folder_regist_flg: false,
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
    getMediaFolder() {
      axios.get("api/mediafolder").then((res) => {
        this.folder = res.data.mediaFolder;
        this.isParentFolder();
      });
    },

    //追加ボタン押下
    registerbtn() {
      let count = 0;
      for (let i = 0; i < this.folder.lenght; i++) {
        if (this.folder[i].parent_folder_id == 0 && this.folder[i].isOpen) {
          count = count + 1;
        }
      }
      if (count != 0) {
        this.regist_flg = true;
      } else {
        this.parent_folder_regist_flg = true;
      }
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
@media (max-width: 900px) {
  .sp_disable {
    display: none;
  }
}

@media (min-width: 901px) {
  .pc_disable {
    display: none;
  }
}
/* タイトルエリア（追加ボタン） */
.gallery-folder-add-btn {
  margin-left: calc(73% - 6rem);
}

/* フォルダ検索エリア */
.gallery-folder-search-area {
  display: flex;
  justify-content: space-around;
}
.gallery-folder-search-container {
  display: flex;
  align-items: center;
  width: 72%;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 4px;
  height: 2.5rem;
}

.gallery-folder-search-input {
  font-size: 16px !important;
  height: 2rem;
  border: none;
  outline: none;
  width: 80%;
}
@media (min-width: 1450px) {
  .gallery-folder-search-input {
    width: 90%;
  }
}

.gallery-folder-search-icon {
  background-color: transparent;
  border: none;
  outline: none;
  margin-right: 5px;
  color: rgba(0, 0, 0, 0.2);
}

.gallery-folder-search-sort {
  font-size: 22px;
  padding: 0px 5px;
}

/* 親フォルダ名初期表示スタイル */
.gallery-folder-show-area {
  overflow-x: hidden;
  overflow-y: auto !important;
  height: 48vh;
  padding: 0 7px;
  margin-top: -5px;
}

@media (min-width: 1450px) {
  .gallery-folder-show-area {
    height: 53vh;
  }
}
.gallery-folder-show {
  display: flex;
  align-items: center;
  cursor: pointer;
  color: #9f9f9f;
  font-size: 16px;
  line-height: 2rem;
  margin: 5px 0;
}
.gallery-folder-show span {
  color: #9f9f9f;
  font-size: 22px;
}
.gallery-folder-show .folder-name {
  font-size: 16px;
  padding-left: 5px;
  width: -webkit-fill-available;
}
.gallery-folder-show .number {
  text-align: right;
  background-color: #f0f0f0;
  border-radius: 5px;
  width: fit-content;
  padding: 5px;
  font-size: 12px;
  line-height: initial;
}

/* 選択された親フォルダスタイル */
.gallery-folder-show-active {
  display: flex;
  align-items: center;
  cursor: pointer;
  color: #69a4af;
  font-size: 16px;
  line-height: 2rem;
  margin: 5px -7px;
  background-color: #f5f9fa;
  border-right: 7px solid #f5f9fa;
  border-left: 7px solid #f5f9fa;
  border-radius: 5px;
}
.gallery-folder-show-active span {
  color: #69a4af;
  font-size: 22px;
}
.gallery-folder-show-active .folder-name {
  font-size: 16px;
  padding-left: 5px;
  width: -webkit-fill-available;
}
.gallery-folder-show-active .number {
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
.gallery-sub-folder-show {
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
.gallery-sub-folder-show span {
  color: #9f9f9f;
  font-size: 22px;
}
.gallery-sub-folder-show .folder-name {
  font-size: 16px;
  padding-left: 5px;
  width: -webkit-fill-available;
}
.gallery-sub-folder-show .number {
  text-align: right;
  background-color: #f0f0f0;
  border-radius: 5px;
  width: fit-content;
  padding: 5px;
  font-size: 12px;
  line-height: initial;
}

/* 選択された親フォルダスタイル */
.gallery-sub-folder-show-active {
  display: flex;
  align-items: center;
  cursor: pointer;
  color: #69a4af;
  font-size: 16px;
  line-height: 2rem;
  margin: 5px -7px;
  background-color: #f5f9fa;
  border-right: 7px solid #f5f9fa;
  border-left: 7px solid #f5f9fa;
  border-radius: 5px;
  margin-left: 1rem;
  margin-top: -0.3rem;
}
.gallery-sub-folder-show-active span {
  color: #69a4af;
  font-size: 22px;
}
.gallery-sub-folder-show-active .folder-name {
  font-size: 16px;
  padding-left: 5px;
  width: -webkit-fill-available;
}
.gallery-sub-folder-show-active .number {
  text-align: right;
  background-color: #fff;
  color: #9f9f9f;
  border-radius: 5px;
  width: fit-content;
  padding: 5px;
  font-size: 12px;
  line-height: initial;
}

/* 名称変更・削除バタン */
.gallery-folder-edit-btn-area {
  position: initial;
}
@media (max-width: 900px) {
  .gallery-folder-edit-btn-area {
    left: 10px;
    right: 10px;
  }
}
.gallery-folder-edit-btn-container {
  display: flex;
  justify-content: space-between;
}
.gallery-folder-name-edit-btn {
  margin-left: 0.5rem;
  width: 65%;
}
.gallery-folder-name-delete-btn {
  width: 35%;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
}
</style>