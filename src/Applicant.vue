<template>
  <div id="applicant">
    <mt-header title="cp报名"></mt-header>
    <mt-popup v-model="enterVisible" class="enter-popup" position="right">
      <div class="bg1" v-show="!bg2Visible"></div>
      <div class="bg2" v-show="bg2Visible"></div>
      <div class="foreword">
        <div class="words" v-if="current_status==1">
          <p>于千万人之中遇见你所遇见的人</p>
          <p>于千万年之中，时间的无涯的荒野里</p>
          <p>没有早一步，也没有晚一步</p>
          <p>刚巧赶上了</p>
          <p>那也没有别的话可说，惟有轻轻的问一声</p>
          <p>“噢，你也在这里吗？”</p>
        </div>
        <div class="words" v-if="current_status==1">
          <p>人如果没有梦想</p>
          <p>和咸鱼有什么分别呢？</p>
          <p>无关输赢</p>
          <p>但愿你满怀希望</p>
          <p>你愿意与我相隔千里</p>
          <p>聊聊我们心中最柔软的愿望吗？</p>
        </div>
        <mt-button size="small" :style="{opacity:0.7}" :type="butType" class="-confirm" @click="hideEnterPopup" v-if="current_status==1">我愿意并且我承诺</mt-button>
        <div class="finishied" v-if="current_status==0">
          永远热泪盈眶，永远满怀期待···
          <br>
          <br>
          <br>
          感谢你的参与~本次cp活动已经结束，请关注我们即将开始的下次活动~
        </div>
      </div>
    </mt-popup>
    <div class="introduce">
      要认真填写哦~将用于审核和匹配，以及cp的第一次推送~
    </div>
    <div class="info">
      <mt-field label="昵称" placeholder="cp看到的昵称" v-model.trim="userinfo.alias" :attr="{autofocaus:true}"></mt-field>
      <mt-field label="微信" placeholder="等着TA来加你吧" v-model.trim="userinfo.weichatId"></mt-field>
      <mt-field label="手机号" placeholder="或许，下期就是morning call" type="tel" v-model.trim="userinfo.phonenumber"></mt-field>
      <mt-field label="年龄" placeholder="很重要哦~" type="number" :attr="{ min: 10,max:80 }" v-model.trim="userinfo.age"></mt-field>

      <!-- <mt-field label="生日" placeholder="或许，你会遇到一个另一个你~" type="date" v-model.trim="userinfo.birthday"></mt-field> -->
      
      <mt-radio align="right" title="性别" :options="options" v-model.trim="userinfo.sex"></mt-radio>

      <mt-cell class="-city" title="城市">
        <mt-button v-if="!userinfo.city" size="small" @click="showCityPicker">选择</mt-button>
        <span v-if="!!userinfo.city" @click="showCityPicker">{{userinfo.province}}--{{userinfo.city}} ></span>
      </mt-cell>
      <mt-field label="学校" placeholder="很重要哦~" v-model.trim="userinfo.university"></mt-field>
      <mt-cell title="上传图片" class="upload-input">
        <input id="shareimg" type="file" name="">
      </mt-cell>
      <mt-field label="新年愿望" placeholder="与输赢无关，但愿你心中有愿望。" type="textarea" rows="4" v-model.trim="userinfo.introduce"></mt-field>
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
    <mt-popup v-model="successVisible" class="success-popup" position="right">
      <div class="-p">恭喜你，报名成功！</div>
      <div class="-img">
      </div>
      <div class="-p">Good Luck!</div>
    </mt-popup>
  </div>
</template>

<script>
import {addApplicants,getItems} from './api/index'
import cityPicker from './components/cityPicker'
import {provinces,citys} from './components/cityData'
const debug=location.host=='localhost:8080'
 
export default {
  name: 'applicant',
  created(){
    let o=this.getUrlParamObj()
    if(!o['o']){
      location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx96bfa7c4e7c79526&redirect_uri=http%3A%2F%2Fitem.redream.cn%2Fcp_application%2Fphp%2Fgetinfo.php&response_type=code&scope=snsapi_userinfo&state=9#wechat_redirect'
      return
    }
    this.weixinInfo=JSON.parse(o['o'])
    this.userinfo.nickname=this.weixinInfo.nickname
    this.userinfo.headimgurl=this.weixinInfo.headimgurl
    this.userinfo.openid=this.weixinInfo.openid

    this.getActivityNum()
  },
  data() {
    return {
      cityVisible: false,
      enterVisible: true,
      bg2Visible:false,
      successVisible:false,
      butType:'default',
      current_status:1,
      weixinInfo:{},
      bgStyle:{
        background: 'url(./assets/2.jpg)',
        backgroundSize: 'cover'
      },
      options:[
        {
          label: '男',
          value: '1',
        },
        {
          label: '女',
          value: '0'
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
        openid: '',
        nickname:'',
        alias:'',
        headimgurl:'',
        weichatId:'',
        phonenumber:'',
        university:'',
        age:0,
        // birthday:'',
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
      },800)
    },
    getActivityNum(){
      let obj={
        table:'cp_activity_status',
        field:{
          current_status:'i',
        },
        condition:{
          // activity_num:{
          //   operate:'=',
          //   type:'i',
          //   value:'1'
          // }
        },
        orderby:{
          activity_num:-1
        },
        limit:{
          from:0,
          num:1,
        }
      }
      getItems(obj)
      .then(data => {
        console.log(data.items[0].current_status)
        this.current_status=data.items[0].current_status
      })
      .catch(e => {
        console.log(e)
      })
    },
    applicate(){
      if (!debug) {
        if (!this.userinfo.alias) {
          alert('昵称不能为空！')
          return
        }
        if (!this.userinfo.weichatId) {
          alert('微信号不能为空！')
          return
        }
        if (!this.userinfo.phonenumber || !/1[0-9]{10}/.test(this.userinfo.phonenumber)) {
          alert('电话不能为空或不是11位数字！')
          return
        }
        if (!this.userinfo.age) {
          alert('年龄不能为空！')
          return
        }
        if (this.userinfo.age < 10 || this.userinfo.age > 60) {
          alert('年龄只能为10-60')
          return
        }
        // if (!this.userinfo.birthday) {
        //   alert('生日不能为空！')
        //   return
        // }
        if (!this.userinfo.introduce) {
          alert('自我介绍不能为空！')
          return
        }
        if (this.userinfo.introduce.length > 100) {
          alert('自我介绍不能超过100字！')
          return
        }
        if (!this.userinfo.wordsToCp) {
          alert('致cp的话不能为空！')
          return
        }
        if (this.userinfo.wordsToCp.length > 100) {
          alert('致cp的话不能超过100字！')
          return
        }
        if (document.getElementById("shareimg").files.length==0) {
          alert('请上传截图以便更多人参与进来哦')
          return
        }
      }
      addApplicants(this.userinfo)
      .then(data => {
        if (data.success) {
            this.successVisible=true
          }else{
            alert('每人每次只能报名一次哦~')
          }
      })
    },
    getUrlParamObj() {
      let str=location.search.substr(1)
      let o={}
      let strArr=str.split('&')
      strArr.forEach((item) => {
        item=item.split('=')
        o[decodeURIComponent(item[0])]=decodeURIComponent(item[1])
      })
      return o
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
    opacity: 0.9;
    width: 100%;
    height: 100%;
    z-index: -2;

  }
  .foreword{
    width: 80%;
    background-color: rgba(255,255,255,0.5);
    margin:30px auto;
    display: flex;
    align-items: center;
    /*justify-content: center;*/
    flex-direction: column;
    padding: 10px;
    .words{
      width: 100%;
      padding-bottom: 20px;
    }
    .finishied{
      padding: 100px 10px;
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
.success-popup{
  background-color: #fff;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-direction: column;
  .-img{
    background: url(./assets/3.jpg);
    background-size: contain;
    width: 100%;
    height: 300px;
    background-color: #444;
  }

}
.upload-input{
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
