<template>
  <div class="cpinfo">
    <div class="-box">
      <div class="-item">
        <div class="-title">
          亲爱的CP：
        </div>
        <div class="-content">
          HELLO，久等了~我是"{{cpinfo.alias}}"，很高兴在那么多人里如此遇到你！
          不管我们是否在同一个城市，我都希望能在接下来的一周里彼此温暖，我把有趣的事情讲给你听，你有不开心的事也希望能找我诉说。毕竟我是个逗比可以逗你开心啊哈哈~
          <p>我来自{{cpinfo.province}},{{cpinfo.city}},这是我的微信“{{cpinfo.weichat_id}}”,想知道更多啊？赶紧加我呀！</p>
        </div>
      </div>
      <div class="-item">
        <div class="-title">
          自我介绍：
        </div>
        <div class="-content">
          {{cpinfo.introduce}}
        </div>
      </div>
      <div class="-item">
        <div class="-title">
          致我那么幸运遇见的你：
        </div>
        <div class="-content">
          {{cpinfo.words_to_cp}}
        </div>
      </div>
      <a class="share" href="http://mp.weixin.qq.com/s?__biz=MzIzNjE4NDI5Nw==&mid=2650650195&idx=1&sn=7cd925d1ef4ef8df655af26558fe4b6e&chksm=f0d2a1d5c7a528c3b469be8be0630f342783c220abb4352ab9432ccb119956437bd4652d0313#rd">@南开一梦</a>
    </div>

  </div>
</template>

<script>
import {getItems} from './api/index'
export default {
  name: 'cpinfo',
  created(){
    this.getCpinfo()
  },
  data () {
    return {
      cp_id:this.$route.params.cp_id,
      activity_num:this.$route.params.activity_num,
      cpinfo:{}
    }
  },
  methods:{
    getCpinfo(){
      let obj={
          table:'cp_applicants',
          field:{
            //查询的域和类型
            id:'i',
            openid:'s',
            headimgurl:'s',
            alias:'s',
            weichat_id  :'s',
            sex:'i',
            age:'i',
            phonenumber :'s',
            province  :'s',
            city  :'s',
            university  :'s',
            introduce :'s',
            words_to_cp :'s',
          },
          condition:{
            id:{
             operate:'=',
             type:'i',
             value:this.cp_id
            },
            activity_num:{
              operate:'=',
              type:'i',
              value:this.activity_num
            }
          }
        }
      getItems(obj)
      .then(data =>{
        console.log(data)
        this.cpinfo=data.items[0]
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='less'>
*{
  margin: 0;
  padding: 0;
}
.cpinfo{
  position: absolute;
  background-color: #888;
  width: 100%;
  height: 100%;
  background: url(./assets/4.jpg);
  background-size: cover;
  display: flex;
  justify-content: center;
  /*flex-direction: column;*/
  .-box{
    width: 90%;
    margin: 20px 0;
    box-sizing: border-box;
    flex-grow: 0;
    flex-shrink: 0;
    background-color: rgba(96,96,96,0.6);
    display: flex;
    flex-direction: column;
    padding: 20px 10px;
    .-item{
      display: flex;
      flex-direction: column;
      color: #fff;
      padding: 20px 0;
      .-title{
        padding: 5px 0;
      }
      .-content{
        text-indent: 2em;
        text-align:justify;
        p{
          text-indent: 2em;
          text-align:justify;
        }
      }
    }
    .share{
      color: #EEE;
      display: block;
      width: 100%;
      text-align: center;
    }
  }
}
</style>
