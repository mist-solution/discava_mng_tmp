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
          <p v-if="!parent_namechange_flg || !item.isOpen" class="folder-name">{{ item.name }}</p>
          <input
            v-if="item.isOpen && parent_namechange_flg"
            class="gallery-folder-search-input"
            type="search"
            maxlength="30"
            hide-details="false"
            v-model="parentfolderTitlechange"
            @change="nameChange(item.id)"
          />
          <p class="number">{{ item.fileValue }}</p>
        </div>
        <!-- 子フォルダ -->
        <div v-if="item.isOpen && item.id != 0">
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
              v-if="subitem.parent_folder_id == item.id && (!namechange_flg || !subitem.isOpen)"
              class="folder-name"
            >
              {{ subitem.name }}
            </p>
            <input
              v-if="subitem.parent_folder_id == item.id && !(!namechange_flg || !subitem.isOpen)"
              class="gallery-folder-search-input"
              type="search"
              maxlength="30"
              hide-details="false"
              v-model="folderTitlechange"
              @change="nameChange(subitem.id)"
            />
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
            @click="openkeepFolder(item.id)"
          >
            <span class="mdi mdi-folder"></span>
            <input
              class="gallery-folder-search-input"
              type="search"
              maxlength="30"
              hide-details="false"
              v-model="folderTitle"
              @change="createFolder(item.id)"
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
          v-model="folderTitle"
          @change="createFolder(0)"
        />
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
          @click="changeNameBtn()"
        >
          名称変更
        </button>
        <button
          class="btn white-btn gallery-folder-name-delete-btn-sp"
          type="button"
          @click="deleteFolder()"
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
      prefolder:[
        {
          id: -1,
          parent_folder_id: 0,
          name: "全てのファイル",
          isShow: false,
          isOpen: false,
          fileValue: 0,
        },
        {
          id: 0,
          parent_folder_id: 0,
          name: "未分類",
          isShow: false,
          isOpen: false,
          fileValue: 0,
        },
      ],
      cardOpen: false,
      folder: [],
      regist_flg: false,
      parent_folder_regist_flg: false,
      folderTitle: "",
      parent_namechange_flg: false,
      namechange_flg: false,
      folderTitlechange:"",
      parentfolderTitlechange:"",
    };
  },
  methods: {
    // 親フォルダか判断
    isParentFolder() {
      this.folder.forEach((folderItem) => {
        if (folderItem.parent_folder_id === 0) {
          folderItem.isShow = true;
          for(let i = 0; i < this.folder.length; i++){
            if(this.folder[i].parent_folder_id == folderItem.id){
              folderItem.fileValue = folderItem.fileValue + this.folder[i].fileValue;
            }
          }
        } else {
          folderItem.isShow = false;
        }
      });
    },

    // 親フォルダクリック操作
    toggleFolder(item) {
      this.namechange_flg = false;
      // 親フォルダを押下
      if(this.parent_namechange_flg && item.isOpen){
      }else{
        item.isOpen = !item.isOpen;
        this.parent_namechange_flg = false;
      }
      this.regist_flg = false;
      this.parent_folder_regist_flg = false;


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
      if(this.namechange_flg && subitem.isOpen){
      }else{
        // 子フォルダを押下
        subitem.isOpen = !subitem.isOpen;
        this.namechange_flg = false;
      }
      this.parent_namechange_flg = false;
      // 押下されない場合，isOpen = false
      this.folder.forEach((subfolderItem) => {
        if (subfolderItem !== subitem && subfolderItem.parent_folder_id !== 0) {
          subfolderItem.isOpen = false;
        }
      });
    },

   // 子フォルダあるか判断
    hasChildFolder(id) {
      if(id != 0){
        return this.folder.some((item) => item.parent_folder_id === id);
      }else if(id == 0){
        return false;
      }
    },

    // フォルダ一覧取得
    getMediaFolder() {
      axios.get("api/mediafolder").then((res) => {
        this.folder = res.data.mediaFolder;
        this.folder = this.prefolder.concat(this.folder)
        this.isParentFolder();
      });
    },

    //追加ボタン押下
    registerbtn() {
      this.namechange_flg = false;
      this.parent_namechange_flg = false;
      let count = 0;
      for (let i = 0; i < this.folder.length; i++) {
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

    //フォルダ追加
    createFolder(id){
      let formData = new FormData();
      const item = {
        name: encodeURIComponent(this.folderTitle),
      };
      formData.append("mediaFolder", JSON.stringify(item));
      axios.post('api/mediafolder/register/' + id ,
      formData,
      { headers: { "Content-type": "multipart/form-data", }})
      .then((res) => {
        this.regist_flg = false;
        this.parent_folder_regist_flg = false;
        this.folderTitle = "";
        this.getMediaFolder();
      });

    },

    openkeepFolder(id){
      this.folder[id].isOpen = true;
    },

    //フォルダ削除
    deleteFolder(){
      this.regist_flg = false;
      this.parent_folder_regist_flg = false;
      this.namechange_flg = false;
      this.parent_namechange_flg = false;
      let parentfolderid = 0
      let childfolderid = 0
      for (let i = 0; i < this.folder.length; i++) {
        if (this.folder[i].parent_folder_id == 0 && this.folder[i].isOpen) {
          parentfolderid = this.folder[i].id;
        }
      }
      if(parentfolderid != 0 && parentfolderid != -1){
        for (let i = 0; i < this.folder.length; i++) {
          if (this.folder[i].parent_folder_id == parentfolderid && this.folder[i].isOpen) {
            childfolderid = this.folder[i].id;
          }
        }
        if(childfolderid != 0){
          axios.delete('/api/mediafolder/' + childfolderid)
          .then((res) => {
            this.getMediaFolder();
          });
        }else{
          axios.delete('/api/mediafolder/' + parentfolderid)
          .then((res) => {
          });
          for (let i = 0; i < this.folder.length; i++) {
            if (this.folder[i].parent_folder_id == parentfolderid){
              axios.delete('/api/mediafolder/' + this.folder[i].id )
            }
          }
        }
        this.getMediaFolder();
      }
    },

    //フォルダ名称変更ボタン押下
    changeNameBtn(){
      this.regist_flg = false;
      this.parent_folder_regist_flg = false;
      let parentfolderid = 0
      let childfolderid = 0
      for (let i = 0; i < this.folder.length; i++) {
        if (this.folder[i].parent_folder_id == 0 && this.folder[i].isOpen) {
          parentfolderid = i + 1;
          this.parentfolderTitlechange = this.folder[i].name;
        }
      }
      if(parentfolderid != 0 && parentfolderid != -1){
        for (let i = 0; i < this.folder.length; i++) {
          if (this.folder[i].parent_folder_id == parentfolderid && this.folder[i].isOpen) {
            childfolderid = i + 1;
            this.folderTitlechange = this.folder[i].name;
          }
        }
        if(childfolderid != 0){
          this.namechange_flg = true;
        }else{
          this.parent_namechange_flg = true;
        }
      }
    },

    //フォルダ名変更
    nameChange(id){
      let formData = new FormData();
      if(this.namechange_flg){
        const item = {
          name: encodeURIComponent(this.folderTitlechange),
        };
        formData.append("mediaFolder", JSON.stringify(item));
        axios.post('/api/mediafolder/namechange/' + id ,
        formData,
        { headers: { "Content-type": "multipart/form-data", }})
        .then((res) => {
          this.namechange_flg = false;
          this.parent_namechange_flg = false;
          this.folderTitlechange = "";
          this.getMediaFolder();
        });
      }else if(this.parent_namechange_flg){
        const item = {
          name: encodeURIComponent(this.parentfolderTitlechange),
        };
        formData.append("mediaFolder", JSON.stringify(item));
        axios.post('/api/mediafolder/namechange/' + id ,
        formData,
        { headers: { "Content-type": "multipart/form-data", }})
        .then((res) => {
          this.namechange_flg = false;
          this.parent_namechange_flg = false;
          this.folderTitlechange = "";
          this.getMediaFolder();
        });
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
    border-radius: 10px;
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
    padding: 0 7px;
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
    margin: 5px -7px;
    background-color: #f5f9fa;
    border-right: 7px solid #f5f9fa;
    border-left: 7px solid #f5f9fa;
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
    margin: 5px -7px;
    background-color: #f5f9fa;
    border-right: 7px solid #f5f9fa;
    border-left: 7px solid #f5f9fa;
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