// import applicants from '../applicants'
// 1. 定义（路由）组件。
// 可以从其他文件 import 进来
// 异步加载
const applicant = resolve => require.ensure([], () => resolve(require('../Applicant.vue')), 'group1') 
const cpinfo = resolve => require.ensure([], () => resolve(require('../cpinfo.vue')), 'group2') 

// 2. 定义路由
// 每个路由应该映射一个组件。 其中"component" 可以是
// 通过 Vue.extend() 创建的组件构造器，
// 或者，只是一个组件配置对象。
// 我们晚点再讨论嵌套路由。
const routes = [
  { path: '/', component: applicant },
  { path: '/applicant', component: applicant },
  { path: '/cpinfo/:activity_num/:cp_id', component: cpinfo },
  // 动态路径参数 以冒号开头
]

export default routes