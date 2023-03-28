<template>
  <!-- タイトル -->
  <div class="gallery-title-folder">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">フォルダ管理</p>
    <button class="green-btn_noTransform px-2 py-1" type="button">追加</button>
  </div>

  <!-- フォルダ検索 -->
  <div class="gallery-folder-search-container">
    <button type="button" class="gallery-folder-search-icon">
      <v-icon>mdi-magnify</v-icon>
    </button>
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

  <div class="gallery_horizontal_divider"></div>

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
        v-else-if="item.parent_folder_id !== 0 && item.isOpen"
        v-for="(subitem, subindex) in folder"
        :key="subindex"
        :class="[
          subitem.parent_folder_id === item.id
            ? 'gallery-folder-show-active gallery-sub-folder-show-active'
            : 'gallery-folder-show gallery-sub-folder-show',
        ]"
        @click.stop="toggleFolder(subitem)"
      >
        <span
          v-if="subitem.isOpen && subitem.parent_folder_id"
          :class="[subitem.isOpen ? 'mdi mdi-folder-open' : 'mdi mdi-folder']"
        ></span>
        <p
          v-if="subitem.isOpen && subitem.parent_folder_id"
          class="folder-name"
        >
          {{ subitem.name }}
        </p>
        <p v-if="subitem.isOpen && subitem.parent_folder_id" class="number">
          {{ subitem.fileValue }}
        </p>
      </div>
    </div>
  </div>

  <div class="gallery_horizontal_divider"></div>

  <!-- 名称変更・削除ボタン -->
  <div class="d-flex">
    <button class="btn white-btn gallery-folder-name-edit-btn" type="button">
      名称変更
    </button>
    <button class="btn white-btn gallery-folder-name-delete-btn" type="button">
      削除
    </button>
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
      ],
    };
  },
  methods: {
    toggleFolder(item) {
      // 親フォルダを押下
      this.folder.forEach((folderItem) => {
        // 押下されない場合，クローズ
        if (folderItem !== item && folderItem.parent_folder_id == 0) {
          folderItem.isOpen = false;
          console.log("NOT CLICK:: " + folderItem.name);
        } else if (folderItem !== item && !item.isOpen) {
          folderItem.isOpen = false;
        }
      });
      // 子フォルダがある場合
      if (this.hasChildFolder(item.id)) {
        // 子フォルダを表示
        this.folder.forEach((subItem) => {
          console.log(subItem.parent_folder_id == item.id);
          if (subItem.parent_folder_id == item.id) {
            subItem.isOpen = !subItem.isOpen;
          } else if (subItem.parent_folder_id != item.id) {
            subItem.isOpen = false;
          }
        });
      }
      item.isOpen = !item.isOpen;
    },

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

.gallery_horizontal_divider {
  border-top: 1px solid #ccc;
  margin: 20px 0;
}

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
  flex: 1;
  border: none;
  outline: none;
  width: 8.6vw;
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
  margin-left: 5px;
}

/* フォルダ名初期表示スタイル */
.gallery-folder-show-container {
  height: 55vh;
}
.gallery-folder-show {
  display: flex;
  align-items: center;
  cursor: pointer;
  color: #9f9f9f;
  font-size: 16px;
  line-height: 2.5rem;
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
  line-height: 2.5rem;
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

/* 子フォルダ */
.gallery-sub-folder-show {
  margin-left: 1.5rem;
  margin-top: -0.3rem;
}

/* 名称変更・削除バタン */
.gallery-folder-name-edit-btn {
  width: 60%;
}
.gallery-folder-name-delete-btn {
  width: 35%;
  margin-left: 0.5rem;
}
</style>