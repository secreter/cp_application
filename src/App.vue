<template>
  <div id="app">
    <mt-header title="cp报名"></mt-header>
    <mt-popup v-model="enterVisible" class="enter-popup" position="right">
      <div class="bg1"></div>
      <div class="bg2" v-if="bg2Visible"></div>
      <div class="foreword">
        <div class="words">
          <p>褪去都市的繁华</p>
          <p>我们剩下的又还有什么呢</p>
          <p>可怜我们习惯了街头的人来人往</p>
          <p>还骗自己</p>
          <p>TA会如约而至···</p>
        </div>
        <div class="words">
          <p>如果你愿意去感受这个世界</p>
          <p>如果你希望去认真的了解另一个你</p>
          <p>如果你希望尝试着关爱这个城市里的另一个人</p>
          <p>聆听TA的故事</p>
          <p>分享你的欢乐</p>
          <p>那么，我愿意帮助你找到TA</p>
        </div>
        <mt-button size="small" :style="{opacity:0.7}" :type="butType" class="-confirm" @click="hideEnterPopup">我愿意并且我承诺</mt-button>
      </div>
    </mt-popup>
    <div class="introduce">
      要认真填写哦~将用于审核和匹配，以及cp的第一次推送~
    </div>
    <div class="info">
      <mt-field label="昵称" placeholder="cp看到的昵称" v-model="userinfo.alias"></mt-field>
      <mt-field label="微信" placeholder="等着TA来加你吧" v-model="userinfo.weichatId"></mt-field>
      <mt-field label="手机号" placeholder="或许，下期就是morning call" type="tel" v-model="userinfo.phonenumber"></mt-field>
      <mt-field label="年龄" placeholder="很重要哦~" type="number" v-model="userinfo.age"></mt-field>
      <mt-field label="生日" placeholder="或许，你会遇到一个另一个你~" type="date" v-model="userinfo.birthday"></mt-field>
      <mt-radio align="right" title="性别" :options="options" v-model="userinfo.sex"></mt-radio>

      <mt-cell class="-city" title="城市">
        <mt-button v-if="!userinfo.city" size="small" @click="showCityPicker">选择</mt-button>
        <span v-if="!!userinfo.city" @click="showCityPicker">{{userinfo.province}}--{{userinfo.city}} ></span>
      </mt-cell>
      <mt-field label="自我介绍" placeholder="告诉TA，你就是颜色不一样的烟火" type="textarea" rows="4" v-model="userinfo.introduce"></mt-field>
      <mt-field label="致cp的话" placeholder="人生若只如初见。初次见面，却想告诉你——" type="textarea" rows="4" v-model="userinfo.wordsToCp"></mt-field>

    </div>
    <mt-popup v-model="cityVisible" class="city-popup" position="bottom">
      <mt-picker :slots="citySlots" @change="onValuesChange"></mt-picker>
      <div  class="-confirm-wrap">
        <mt-button size="small" type="primary" class="-confirm" @click="hideCityPicker">确定</mt-button>
      </div>
    </mt-popup>
    <div class="footer">
      <mt-button size="small" type="primary" class="-confirm" @click="applicate">确认报名</mt-button>
    </div>
  </div>
</template>

<script>
import cityPicker from './components/cityPicker'
import {provinces,citys} from './components/cityData'
export default {
  name: 'app',
  data() {
    return {
      cityVisible: false,
      enterVisible: true,
      bg2Visible:false,
      butType:'default',
      bgStyle:{
        background: 'url(./assets/2.jpg)',
        backgroundSize: 'cover'
      },
      options:[
        {
          label: '男',
          value: '0',
        },
        {
          label: '女',
          value: '1'
        },
      ],
      citySlots: [
        {
          flex: 1,
          values: provinces,
          className: 'slot1',
          textAlign: 'right'
        }, {
          divider: true,
          content: '-',
          className: 'slot2'
        }, {
          flex: 1,
          values: ['北京市'],
          className: 'slot3',
          textAlign: 'left'
        }
      ],
      userinfo:{
        nickname:'',
        alias:'',
        headimgurl:'',
        weichatId:'',
        phonenumber:'',
        age:0,
        birthday:'',
        sex:'0',
        province: provinces[0],
        city:citys[provinces[0]][0],
        introduce:'',
        wordsToCp:''

      }
    }
  },
  components: {
    cityPicker
  },
  methods:{
    onValuesChange(picker, values) {
      this.citySlots[2]['values'] = citys[values[0]]
      this.userinfo.province = values[0]
      this.userinfo.city = values[1]
      console.log(values)
    },
    showCityPicker(){
      this.cityVisible=true
      // this.userinfo.province = provinces[0]
      // this.userinfo.city = citys[provinces[0]][0]
    },
    hideCityPicker(){
      this.cityVisible=false
    },
    hideEnterPopup(){
      this.butType="danger"
      this.bg2Visible=true
      setTimeout(() => {
        this.enterVisible=false
      },600)
    },
    applicate(){
      console.log(this.userinfo)
    }
  }
}
</script>

<style lang='less'>
*{
  margin: 0;
  padding:0;
}
.enter-popup{
  width: 100%;
  height: 100%;
  display: flex;
  .bg1{
    position: fixed;
    background: url(./assets/2.jpg);
    background-size: cover;
    opacity: 0.6;
    width: 100%;
    height: 100%;
    z-index: -1;
  }
  .bg2{
    position: fixed;
    background: url(./assets/1.jpg);
    background-size: cover;
    opacity: 0.6;
    width: 100%;
    height: 100%;
    z-index: -1;

  }
  .foreword{
    width: 80%;
    background-color: rgba(255,255,255,0.5);
    margin:30px;
    display: flex;
    align-items: center;
    /*justify-content: center;*/
    flex-direction: column;
    padding: 10px;
    .words{
      width: 100%;
      padding-bottom: 20px;
    }
  }
}
.introduce{
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
  font-size: 14px;
  background-color: #eee;
}
.info{
  font-size: 14px !important;
  padding: 10px 20px;
  .mint-cell-wrapper{
    font-size: 14px !important;
  }
  .-city{
    border-top:none;
  }
}
.city-popup{
  width: 100%;
  .-confirm-wrap{
    width: 100%;
    margin: 20px auto;
    text-align: center;
    .-confirm{
      width: 80%;
    }
  }
}
.footer{
  width: 100%;
  background-color: #eee;
  text-align: center;
  padding: 30px 0;
  .-confirm{
    width: 80%;
  }
}
</style>
