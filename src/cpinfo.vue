<template>
  <div class="cpinfo">
    <div class="-box">
      <div class="-item">
        <div class="-title">
          你亲爱的CP：
        </div>
        <div class="-content">
          HELLO，久等了~我是{{cpinfo.alias}}，很高兴遇到你！
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
             opreate:'=',
             type:'i',
             value:this.cp_id
            },
            activity_num:{
              opreate:'=',
              type:'i',
              value:this.activity_num
            }
          }
        }
      getItems(obj)
      .then(data =>{
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
      padding: 5px 0;
      .-title{
        padding: 5px 0;
      }
      .-content{
        text-indent: 2em;
      }
    }
  }
}
</style>
