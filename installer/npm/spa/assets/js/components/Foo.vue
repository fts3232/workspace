<template>
    <div>foooooo</div>
</template>

<script type="text/babel">
    export default {
        name: 'Foo',
        componentName: 'Foo',
        mounted: function(){
            console.log(this.$store.state.items)
            console.log('Foo挂载成功');
        },
        asyncData ({ store, route }) {
            // 触发 action 后，会返回 Promise
            return store.dispatch('fetchItem', route.params.id)
        },
    }
</script>