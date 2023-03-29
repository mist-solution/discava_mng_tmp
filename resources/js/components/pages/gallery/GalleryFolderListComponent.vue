<template>
  <!-- タイトル -->
  <div class="gallery-title-folder">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">フォルダ管理</p>
    <button class="green-btn_noTransform px-2 py-1" type="button">追加</button>
  </div>

  <!-- フォルダ検索エリア -->
  <div class="gallery-folder-search-container">
    <button type="button" class="gallery-folder-search-icon">
      <v-icon>mdi-magnify</v-icon>
    </button>
    <div class="d-flex">
      <input
        class="gallery-folder-search-input"
        type="search"
        aria-label="Search"
        maxlength="30"
        hide-details="false"
      />
      <button class="btn white-btn gallery-folder-search-sort" type="button">
        <span class="mdi mdi-sort-alphabetical-ascending"></span>
      </button>
    </div>
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- フォルダ一覧表示 -->
  <div class="gallery-folder-show-container">
    <div
      v-for="(item, index) in folder"
      :key="index"
      @click="toggleFolder(item)"
    >
      <!-- 親フォルダ -->
      <div
        v-if="item.parent_folder_id === 0"
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
      <div
        :class="[
          item.isOpen
            ? 'gallery-folder-show-active gallery-sub-folder-show-active'
            : 'gallery-folder-show gallery-sub-folder-show',
        ]"
        @click.stop="toggleFolder(item)"
      >
        <span
          v-if="item.isOpen && item.parent_folder_id != 0"
          :class="[item.isOpen ? 'mdi mdi-folder-open' : 'mdi mdi-folder']"
        ></span>
        <p v-if="item.isOpen && item.parent_folder_id != 0" class="folder-name">
          {{ item.name }}
        </p>
        <p v-if="item.isOpen && item.parent_folder_id != 0" class="number">
          {{ item.fileValue }}
        </p>
      </div>
    </div>
  </div>

  <!-- 名称変更・削除ボタン -->
  <div class="gallery-folder-edit-btn-container">
    <!-- 仕切り線 -->
    <div class="gallery-horizontal-divider"></div>

    <!-- ボタン -->
    <div class="d-flex">
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
    // フォルダクリック操作
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
              subItem.isOpen = true;
            } else if (!item.isOpen) {
              subItem.isOpen = false;
            }
          });
        }
      }
    },

    // 子フォルダあるか判断
    hasChildFolder(id) {
      return this.folder.some((item) => item.parent_folder_id === id);
    },
  },

  async mounted() {},
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

/* 仕切り線 */
.gallery-horizontal-divider {
  border-top: 1px solid #ccc;
  margin: 15px 0;
}

/* フォルダ検索エリア */
.gallery-folder-search-container {
  display: flex;
  align-items: center;
  width: 72%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 4px;
  margin-left: 5%;
  height: 2.5rem;
}

.gallery-folder-search-input {
  font-size: 16px !important;
  height: 2rem;
  border: solid 1px rgba(0, 0, 0, 0.2);
  border-radius: 0.375rem;
  border: none;
  outline: none;
  flex: 1;
  width: 100%;
}

.gallery-folder-search-icon {
  background-color: transparent;
  border: none;
  outline: none;
  margin-right: 4px;
}

.gallery-folder-search-sort {
  font-size: 22px;
  padding: 0px 5px;
  margin-left: calc(100% + 10px);
}

/* フォルダ名初期表示スタイル */
.gallery-folder-show-container {
  overflow: auto;
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

/* 選択されたフォルダスタイル */
.gallery-folder-show-active {
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

/* 子フォルダマージン */
.gallery-sub-folder-show {
  margin-left: 1.5rem;
  margin-top: -0.3rem;
}
.gallery-sub-folder-show-active {
  margin-left: 1.5rem;
  margin-top: -0.3rem;
}

/* 名称変更・削除バタン */
.gallery-folder-edit-btn-container {
  position: absolute;
  bottom: 15px;
  left: 20px;
  right: 20px;
}
.gallery-folder-name-edit-btn {
  width: 65%;
}
.gallery-folder-name-delete-btn {
  width: 35%;
  margin-left: 0.5rem;
}
</style>