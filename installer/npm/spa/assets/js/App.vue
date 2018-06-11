<template>
    <div>
        <div>success</div>
        <router-link to="/foo">Go to Foo</router-link>
        <router-link to="/bar">Go to Bar</router-link>
        <transition>
            <router-view></router-view>
        </transition>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'App',
        componentName: 'App',
        mounted: function(){
            console.log('挂载成功');
        },
    }
</script>