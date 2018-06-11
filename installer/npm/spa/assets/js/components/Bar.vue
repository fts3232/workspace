<template>
    <div>bar</div>
</template>

<script type="text/babel">
    export default {
        name: 'bar',
        componentName: 'bar',
        mounted: function(){
            console.log(this.$store.state.items)
            console.log('Bar挂载成功');
        },
        asyncData ({ store, route }) {
            // 触发 action 后，会返回 Promise
            return store.dispatch('fetchItem', route.params.id)
        },
    }
</script>