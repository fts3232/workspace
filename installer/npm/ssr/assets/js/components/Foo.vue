<template>
    <div>foooooo</div>
</template>

<script type="text/babel">
    import titleMixin from '../mixin/title.js';
    export default {
        mixins: [titleMixin],
        name: 'Foo',
        componentName: 'Foo',
        mounted: function(){
            console.log(this.$store.state.count)
            console.log('Foo挂载成功');
        },
        asyncData ({ store }) {
            // 触发 action 后，会返回 Promise
            return store.dispatch('setItem')
        },
        title: 'foo'
    }
</script>