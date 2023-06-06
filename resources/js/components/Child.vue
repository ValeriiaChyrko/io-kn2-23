<template>
  <transition name="page" mode="out-in">
    <slot>
      <router-view ref="routerView"/>
    </slot>
  </transition>
</template>

<script>
export default {
  name: 'Child'
}
</script>
