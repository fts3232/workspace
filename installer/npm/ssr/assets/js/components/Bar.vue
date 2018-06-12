<template>
    <div>bar</div>
</template>

<script type="text/babel">
    import css from '../../css/style.css';
    import titleMixin from '../mixin/title.js';
    export default {
        mixins: [titleMixin],
        name: 'bar',
        componentName: 'bar',
        mounted: function(){
            console.log(this.$store.state.count)
            console.log('Bar挂载成功');
        },
        beforeMount () {
            const { asyncData } = this.$options
            if (asyncData) {
                // 将获取数据操作分配给 promise
                // 以便在组件中，我们可以在数据准备就绪后
                // 通过运行 `this.dataPromise.then(...)` 来执行其他任务
                this.dataPromise = asyncData({
                    store: this.$store
                })
            }
        },
        asyncData ({ store }) {
            // 触发 action 后，会返回 Promise
            return store.dispatch('setItem')
        },
        title: 'bar'
    }
</script>