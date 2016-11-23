<template>
  <mt-picker :slots="slots" @change="onValuesChange">
    
  </mt-picker>
</template>

<script>
import {provinces,citys} from './cityData'
export default {
  data () {
    return {
      slots: [
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
      ]
    }
  },
  methods:{
    onValuesChange(picker, values) {
      this.slots[2]['values'] = citys[values[0]]
      console.log(values)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
